<?php

require_once __DIR__ . '/../../config/Database.php';

class AdminController {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
        
        if (!$this->isAdmin()) {
            header('Location: ?page=login');
            exit();
        }
    }

    public function index() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_backup'])) {
            $result = $this->createDatabaseBackup();
            
            if ($result['success']) {
                $_SESSION['flash_message'] = $result['message'];
                $_SESSION['flash_type'] = 'success';
            } else {
                $_SESSION['flash_message'] = $result['message'];
                $_SESSION['flash_type'] = 'error';
            }

            header('Location: ?page=admin');
            exit();
        }

        $stats = $this->getBasicStats();
        
        $data = [
            'pageTitle' => 'Admin Dashboard',
            'stats' => $stats
        ];

        $this->view('admin/dashboard', $data);
    }

    private function createDatabaseBackup() {
        try {
            $backupDir = __DIR__ . '/../../backups';
            if (!is_dir($backupDir)) {
                mkdir($backupDir, 0755, true);
            }

            $timestamp = date('Y-m-d_H-i-s');
            $filename = "videoteka_backup_{$timestamp}.sql";
            $filepath = $backupDir . '/' . $filename;

            $tables = [];
            $stmt = $this->db->query("SHOW TABLES");
            while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
                $tables[] = $row[0];
            }

            $sqlBackup = "-- Videoteka Database Backup\n";
            $sqlBackup .= "-- Generated on: " . date('Y-m-d H:i:s') . "\n\n";
            $sqlBackup .= "SET FOREIGN_KEY_CHECKS = 0;\n\n";
            
            foreach ($tables as $table) {
                $stmt = $this->db->query("SHOW CREATE TABLE `$table`");
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                
                $sqlBackup .= "DROP TABLE IF EXISTS `$table`;\n";
                $sqlBackup .= $row['Create Table'] . ";\n\n";

                $stmt = $this->db->query("SELECT * FROM `$table`");
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                if (!empty($rows)) {
                    $columns = array_keys($rows[0]);
                    $sqlBackup .= "INSERT INTO `$table` (`" . implode('`, `', $columns) . "`) VALUES\n";
                    
                    foreach ($rows as $index => $row) {
                        $values = [];
                        foreach ($row as $value) {
                            if ($value === null) {
                                $values[] = 'NULL';
                            } else {
                                $values[] = "'" . addslashes($value) . "'";
                            }
                        }
                        
                        $sqlBackup .= "(" . implode(', ', $values) . ")";
                        
                        if ($index < count($rows) - 1) {
                            $sqlBackup .= ",\n";
                        } else {
                            $sqlBackup .= ";\n\n";
                        }
                    }
                }
            }
            
            $sqlBackup .= "SET FOREIGN_KEY_CHECKS = 1;\n";

            if (file_put_contents($filepath, $sqlBackup)) {
                $this->logActivity($_SESSION['user_id'], 'create_backup', "Database backup created: $filename");
                
                return [
                    'success' => true,
                    'message' => "Sigurnosna kopija uspješno stvorena: $filename"
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Greška pri spremanju sigurnosne kopije.'
                ];
            }
            
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Greška pri stvaranju sigurnosne kopije: ' . $e->getMessage()
            ];
        }
    }

    public function users() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';
            
            switch ($action) {
                case 'store':
                    $this->storeUser();
                    break;
                case 'update':
                    $this->updateUser();
                    break;
                case 'delete':
                    $this->deleteUser();
                    break;
                case 'activate':
                    $this->updateUserStatus($_POST['user_id'], 'active');
                    $_SESSION['flash_message'] = 'Korisnik aktiviran.';
                    break;
                case 'deactivate':
                    $this->updateUserStatus($_POST['user_id'], 'inactive');
                    $_SESSION['flash_message'] = 'Korisnik deaktiviran.';
                    break;
            }
            
            header('Location: ?page=admin&section=users');
            exit();
        }
        
        $stmt = $this->db->query("SELECT * FROM users ORDER BY created_at DESC");
        $users = $stmt->fetchAll();
        
        $data = [
            'pageTitle' => 'Upravljanje korisnicima',
            'users' => $users
        ];
        
        $this->view('admin/users', $data);
    }

    public function config() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $moviesPerPage = $_POST['movies_per_page'] ?? 12;
            $maxFailedAttempts = $_POST['max_failed_attempts'] ?? 3;

            $config = [
                'movies_per_page' => (int)$moviesPerPage,
                'max_failed_attempts' => (int)$maxFailedAttempts
            ];
            
            file_put_contents(__DIR__ . '/../../config/admin_settings.json', json_encode($config));
            $_SESSION['flash_message'] = 'Postavke spremljene.';
            
            header('Location: ?page=admin&section=config');
            exit();
        }

        $configFile = __DIR__ . '/../../config/admin_settings.json';
        if (file_exists($configFile)) {
            $settings = json_decode(file_get_contents($configFile), true);
        } else {
            $settings = ['movies_per_page' => 12, 'max_failed_attempts' => 3];
        }
        
        $data = [
            'pageTitle' => 'Sistemske postavke',
            'settings' => $settings
        ];
        
        $this->view('admin/settings', $data);
    }

    public function logs() {
        $search = $_GET['search'] ?? '';
        $whereDesc = '';
        $params = [];
        
        if ($search) {
            $whereDesc = "WHERE description LIKE ?";
            $params[] = "%$search%";
        }
        
        $sql = "SELECT al.*, u.username 
                FROM activity_logs al 
                LEFT JOIN users u ON al.user_id = u.id 
                $whereDesc
                ORDER BY al.created_at DESC 
                LIMIT 50";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $logs = $stmt->fetchAll();
        
        $data = [
            'pageTitle' => 'Dnevnik aktivnosti',
            'logs' => $logs,
            'search' => $search
        ];
        
        $this->view('admin/logs', $data);
    }

    public function stats() {
        $dateFrom = $_GET['date_from'] ?? date('Y-m-d', strtotime('-7 days'));
        $dateTo = $_GET['date_to'] ?? date('Y-m-d');

        $stmt = $this->db->prepare("
            SELECT DATE(created_at) as date, COUNT(*) as count 
            FROM activity_logs 
            WHERE action = 'login' 
            AND DATE(created_at) BETWEEN ? AND ?
            GROUP BY DATE(created_at)
            ORDER BY date
        ");
        $stmt->execute([$dateFrom, $dateTo]);
        $loginStats = $stmt->fetchAll();

        $stmt = $this->db->prepare("
            SELECT DATE(created_at) as date, COUNT(*) as count 
            FROM users 
            WHERE DATE(created_at) BETWEEN ? AND ?
            GROUP BY DATE(created_at)
            ORDER BY date
        ");
        $stmt->execute([$dateFrom, $dateTo]);
        $registrationStats = $stmt->fetchAll();
        
        $data = [
            'pageTitle' => 'Statistike',
            'loginStats' => $loginStats,
            'registrationStats' => $registrationStats,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo
        ];
        
        $this->view('admin/stats', $data);
    }

    private function storeUser() {
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $firstName = trim($_POST['first_name'] ?? '');
        $lastName = trim($_POST['last_name'] ?? '');
        $role = $_POST['role'] ?? 'user';
        $status = $_POST['status'] ?? 'active';

        if (empty($username) || empty($email) || empty($password) || empty($firstName) || empty($lastName)) {
            $_SESSION['flash_message'] = 'Sva polja su obavezna.';
            $_SESSION['flash_type'] = 'error';
            return;
        }
        
        if (strlen($password) < 6) {
            $_SESSION['flash_message'] = 'Lozinka mora imati najmanje 6 znakova.';
            $_SESSION['flash_type'] = 'error';
            return;
        }

        $stmt = $this->db->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$username]);
        if ($stmt->fetch()) {
            $_SESSION['flash_message'] = 'Korisničko ime već postoji.';
            $_SESSION['flash_type'] = 'error';
            return;
        }

        $stmt = $this->db->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $_SESSION['flash_message'] = 'Email adresa već postoji.';
            $_SESSION['flash_type'] = 'error';
            return;
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("
            INSERT INTO users (username, email, password, first_name, last_name, role, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        
        if ($stmt->execute([$username, $email, $hashedPassword, $firstName, $lastName, $role, $status])) {
            $this->logActivity($_SESSION['user_id'], 'admin_create_user', "Created user: $username");
            $_SESSION['flash_message'] = 'Korisnik je uspješno stvoren.';
            $_SESSION['flash_type'] = 'success';
        } else {
            $_SESSION['flash_message'] = 'Greška pri stvaranju korisnika.';
            $_SESSION['flash_type'] = 'error';
        }
    }

    private function updateUser() {
        $userId = $_POST['user_id'] ?? null;
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $firstName = trim($_POST['first_name'] ?? '');
        $lastName = trim($_POST['last_name'] ?? '');
        $role = $_POST['role'] ?? 'user';
        $status = $_POST['status'] ?? 'active';
        
        if (!$userId) {
            $_SESSION['flash_message'] = 'Korisnik nije specificiran.';
            $_SESSION['flash_type'] = 'error';
            return;
        }

        if (empty($username) || empty($email) || empty($firstName) || empty($lastName)) {
            $_SESSION['flash_message'] = 'Sva polja su obavezna.';
            $_SESSION['flash_type'] = 'error';
            return;
        }

        $stmt = $this->db->prepare("SELECT id FROM users WHERE username = ? AND id != ?");
        $stmt->execute([$username, $userId]);
        if ($stmt->fetch()) {
            $_SESSION['flash_message'] = 'Korisničko ime već postoji.';
            $_SESSION['flash_type'] = 'error';
            return;
        }

        $stmt = $this->db->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
        $stmt->execute([$email, $userId]);
        if ($stmt->fetch()) {
            $_SESSION['flash_message'] = 'Email adresa već postoji.';
            $_SESSION['flash_type'] = 'error';
            return;
        }

        $sql = "UPDATE users SET username = ?, email = ?, first_name = ?, last_name = ?, role = ?, status = ?";
        $params = [$username, $email, $firstName, $lastName, $role, $status];

        if (!empty($password)) {
            if (strlen($password) < 6) {
                $_SESSION['flash_message'] = 'Lozinka mora imati najmanje 6 znakova.';
                $_SESSION['flash_type'] = 'error';
                return;
            }
            $sql .= ", password = ?";
            $params[] = password_hash($password, PASSWORD_DEFAULT);
        }
        
        $sql .= " WHERE id = ?";
        $params[] = $userId;
        
        $stmt = $this->db->prepare($sql);
        if ($stmt->execute($params)) {
            $this->logActivity($_SESSION['user_id'], 'admin_update_user', "Updated user: $username");
            $_SESSION['flash_message'] = 'Korisnik je uspješno ažuriran.';
            $_SESSION['flash_type'] = 'success';
        } else {
            $_SESSION['flash_message'] = 'Greška pri ažuriranju korisnika.';
            $_SESSION['flash_type'] = 'error';
        }
    }

    private function deleteUser() {
        $userId = $_POST['user_id'] ?? null;
        
        if (!$userId) {
            $_SESSION['flash_message'] = 'Korisnik nije specificiran.';
            $_SESSION['flash_type'] = 'error';
            return;
        }

        if ($userId == $_SESSION['user_id']) {
            $_SESSION['flash_message'] = 'Ne možete obrisati svoj račun.';
            $_SESSION['flash_type'] = 'error';
            return;
        }

        $stmt = $this->db->prepare("SELECT username FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch();
        
        if ($user) {
            try {
                $this->db->beginTransaction();

                $stmt = $this->db->prepare("DELETE FROM activity_logs WHERE user_id = ?");
                $stmt->execute([$userId]);

                $stmt = $this->db->prepare("DELETE FROM rentals WHERE user_id = ?");
                $stmt->execute([$userId]);

                $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
                $stmt->execute([$userId]);
                
                $this->db->commit();
                
                $this->logActivity($_SESSION['user_id'], 'admin_delete_user', "Deleted user: {$user['username']}");
                $_SESSION['flash_message'] = 'Korisnik je uspješno obrisan.';
                $_SESSION['flash_type'] = 'success';
                
            } catch (Exception $e) {
                $this->db->rollback();
                $_SESSION['flash_message'] = 'Greška pri brisanju korisnika.';
                $_SESSION['flash_type'] = 'error';
            }
        } else {
            $_SESSION['flash_message'] = 'Korisnik ne postoji.';
            $_SESSION['flash_type'] = 'error';
        }
    }
    
    private function isAdmin() {
        return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
    }
    
    private function getBasicStats() {
        $stats = [];
        
        $stmt = $this->db->query("SELECT COUNT(*) FROM users WHERE role = 'user'");
        $stats['total_users'] = $stmt->fetchColumn();
        
        $stmt = $this->db->query("SELECT COUNT(*) FROM movies");
        $stats['total_movies'] = $stmt->fetchColumn();
        
        $stmt = $this->db->query("SELECT COUNT(*) FROM activity_logs WHERE action = 'login' AND DATE(created_at) = CURDATE()");
        $stats['today_logins'] = $stmt->fetchColumn();
        
        return $stats;
    }
    
    private function updateUserStatus($userId, $status) {
        $stmt = $this->db->prepare("UPDATE users SET status = ? WHERE id = ?");
        $stmt->execute([$status, $userId]);
        
        $this->logActivity($_SESSION['user_id'], 'admin_user_status', "Changed user $userId status to $status");
    }
    
    private function logActivity($userId, $action, $description) {
        $stmt = $this->db->prepare("INSERT INTO activity_logs (user_id, action, description) VALUES (?, ?, ?)");
        $stmt->execute([$userId, $action, $description]);
    }
    
    private function view($view, $data = []) {
        extract($data);
        require_once __DIR__ . '/../views/templates/header.tpl.php';
        require_once __DIR__ . '/../views/' . $view . '.php';
        require_once __DIR__ . '/../views/templates/footer.tpl.php';
    }
}