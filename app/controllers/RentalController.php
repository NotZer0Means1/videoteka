<?php
/**
 * Rental Controller - Movie rental system
 */

require_once __DIR__ . '/../../config/Database.php';

class RentalController {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
        
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: ?page=login');
            exit();
        }
    }
    
    /**
     * Show user's rentals
     */
    public function index() {
        $userId = $_SESSION['user_id'];
        
        // Get user's active and past rentals
        $stmt = $this->db->prepare("
            SELECT r.*, m.title, m.year, m.poster_url 
            FROM rentals r 
            JOIN movies m ON r.movie_id = m.id 
            WHERE r.user_id = ? 
            ORDER BY r.rental_date DESC
        ");
        $stmt->execute([$userId]);
        $rentals = $stmt->fetchAll();
        
        $data = [
            'pageTitle' => 'Moji iznajmljivanja',
            'rentals' => $rentals
        ];
        
        $this->view('rentals/index', $data);
    }
    
    /**
     * Rent a movie
     */
    public function rent() {
        $movieId = $_GET['movie_id'] ?? $_POST['movie_id'] ?? null;
        $userId = $_SESSION['user_id'];
        
        if (!$movieId) {
            $_SESSION['flash_message'] = 'Film nije specificiran.';
            $_SESSION['flash_type'] = 'error';
            header('Location: ?page=movies');
            exit();
        }
        
        // Check if movie exists and is available
        $stmt = $this->db->prepare("SELECT * FROM movies WHERE id = ? AND is_available = 1");
        $stmt->execute([$movieId]);
        $movie = $stmt->fetch();
        
        if (!$movie) {
            $_SESSION['flash_message'] = 'Film nije dostupan za iznajmljivanje.';
            $_SESSION['flash_type'] = 'error';
            header('Location: ?page=movies');
            exit();
        }
        
        // Check if user already has this movie rented
        $stmt = $this->db->prepare("
            SELECT id FROM rentals 
            WHERE user_id = ? AND movie_id = ? AND status = 'active'
        ");
        $stmt->execute([$userId, $movieId]);
        if ($stmt->fetch()) {
            $_SESSION['flash_message'] = 'Već imate iznajmljen ovaj film.';
            $_SESSION['flash_type'] = 'warning';
            header('Location: ?page=movies&action=show&id=' . $movieId);
            exit();
        }
        
        // Check if user has too many active rentals (max 3)
        $stmt = $this->db->prepare("
            SELECT COUNT(*) FROM rentals 
            WHERE user_id = ? AND status = 'active'
        ");
        $stmt->execute([$userId]);
        $activeRentals = $stmt->fetchColumn();
        
        if ($activeRentals >= 3) {
            $_SESSION['flash_message'] = 'Možete imati maksimalno 3 aktivna iznajmljivanja.';
            $_SESSION['flash_type'] = 'warning';
            header('Location: ?page=rentals');
            exit();
        }
        
        try {
            $this->db->beginTransaction();
            
            // Create rental record
            $dueDate = date('Y-m-d H:i:s', strtotime('+7 days')); // 7 days rental period
            $stmt = $this->db->prepare("
                INSERT INTO rentals (user_id, movie_id, due_date, status) 
                VALUES (?, ?, ?, 'active')
            ");
            $stmt->execute([$userId, $movieId, $dueDate]);
            
            // Mark movie as unavailable
            $stmt = $this->db->prepare("UPDATE movies SET is_available = 0 WHERE id = ?");
            $stmt->execute([$movieId]);
            
            // Log activity
            $this->logActivity($userId, 'rent_movie', "Rented movie: {$movie['title']}");
            
            $this->db->commit();
            
            $_SESSION['flash_message'] = "Film '{$movie['title']}' je uspješno iznajmljen!";
            $_SESSION['flash_type'] = 'success';
            
        } catch (Exception $e) {
            $this->db->rollback();
            $_SESSION['flash_message'] = 'Greška pri iznajmljivanju filma.';
            $_SESSION['flash_type'] = 'error';
        }
        
        header('Location: ?page=rentals');
        exit();
    }
    
    /**
     * Return a movie
     */
    public function returnMovie() {
        $rentalId = $_POST['rental_id'] ?? null;
        $userId = $_SESSION['user_id'];
        
        if (!$rentalId) {
            $_SESSION['flash_message'] = 'Iznajmljivanje nije specificirano.';
            $_SESSION['flash_type'] = 'error';
            header('Location: ?page=rentals');
            exit();
        }
        
        // Check if rental belongs to user and is active
        $stmt = $this->db->prepare("
            SELECT r.*, m.title 
            FROM rentals r 
            JOIN movies m ON r.movie_id = m.id 
            WHERE r.id = ? AND r.user_id = ? AND r.status = 'active'
        ");
        $stmt->execute([$rentalId, $userId]);
        $rental = $stmt->fetch();
        
        if (!$rental) {
            $_SESSION['flash_message'] = 'Neispravno iznajmljivanje.';
            $_SESSION['flash_type'] = 'error';
            header('Location: ?page=rentals');
            exit();
        }
        
        try {
            $this->db->beginTransaction();
            
            // Update rental record
            $stmt = $this->db->prepare("
                UPDATE rentals 
                SET status = 'returned', return_date = NOW() 
                WHERE id = ?
            ");
            $stmt->execute([$rentalId]);
            
            // Mark movie as available
            $stmt = $this->db->prepare("UPDATE movies SET is_available = 1 WHERE id = ?");
            $stmt->execute([$rental['movie_id']]);
            
            // Log activity
            $this->logActivity($userId, 'return_movie', "Returned movie: {$rental['title']}");
            
            $this->db->commit();
            
            $_SESSION['flash_message'] = "Film '{$rental['title']}' je uspješno vraćen!";
            $_SESSION['flash_type'] = 'success';
            
        } catch (Exception $e) {
            $this->db->rollback();
            $_SESSION['flash_message'] = 'Greška pri vraćanju filma.';
            $_SESSION['flash_type'] = 'error';
        }
        
        header('Location: ?page=rentals');
        exit();
    }
    
    /**
     * Admin view of all rentals
     */
    public function admin() {
        // Check if user is admin
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('Location: ?page=login');
            exit();
        }
        
        $status = $_GET['status'] ?? '';
        $search = $_GET['search'] ?? '';
        
        // Build query
        $whereClause = "WHERE 1=1";
        $params = [];
        
        if ($status) {
            $whereClause .= " AND r.status = ?";
            $params[] = $status;
        }
        
        if ($search) {
            $whereClause .= " AND (m.title LIKE ? OR u.username LIKE ? OR u.first_name LIKE ? OR u.last_name LIKE ?)";
            $searchTerm = "%$search%";
            $params = array_merge($params, [$searchTerm, $searchTerm, $searchTerm, $searchTerm]);
        }
        
        // Get rentals with user and movie info
        $sql = "SELECT r.*, m.title, m.year, m.poster_url, 
                       u.username, u.first_name, u.last_name
                FROM rentals r 
                JOIN movies m ON r.movie_id = m.id 
                JOIN users u ON r.user_id = u.id 
                $whereClause
                ORDER BY r.rental_date DESC 
                LIMIT 100";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $rentals = $stmt->fetchAll();
        
        // Get stats
        $stats = [
            'total' => $this->getRentalCount(),
            'active' => $this->getRentalCount('active'),
            'returned' => $this->getRentalCount('returned'),
            'overdue' => $this->getOverdueCount()
        ];
        
        $data = [
            'pageTitle' => 'Upravljanje iznajmljivanjima',
            'rentals' => $rentals,
            'stats' => $stats,
            'selectedStatus' => $status,
            'search' => $search
        ];
        
        $this->view('rentals/admin', $data);
    }
    
    /**
     * Mark overdue rentals
     */
    public function markOverdue() {
        // Only admin can do this
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('Location: ?page=login');
            exit();
        }
        
        // Update overdue rentals
        $stmt = $this->db->prepare("
            UPDATE rentals 
            SET status = 'overdue' 
            WHERE status = 'active' 
            AND due_date < NOW()
        ");
        $stmt->execute();
        
        $updatedCount = $stmt->rowCount();
        
        if ($updatedCount > 0) {
            $this->logActivity($_SESSION['user_id'], 'mark_overdue', "Marked $updatedCount rentals as overdue");
            $_SESSION['flash_message'] = "Označeno $updatedCount iznajmljivanja kao zakašnjela.";
            $_SESSION['flash_type'] = 'success';
        } else {
            $_SESSION['flash_message'] = 'Nema zakašnjelih iznajmljivanja.';
            $_SESSION['flash_type'] = 'info';
        }
        
        header('Location: ?page=admin&section=rentals');
        exit();
    }
    
    // Helper methods
    
    private function getRentalCount($status = null) {
        if ($status) {
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM rentals WHERE status = ?");
            $stmt->execute([$status]);
        } else {
            $stmt = $this->db->query("SELECT COUNT(*) FROM rentals");
        }
        return $stmt->fetchColumn();
    }
    
    private function getOverdueCount() {
        $stmt = $this->db->query("
            SELECT COUNT(*) 
            FROM rentals 
            WHERE status = 'active' 
            AND due_date < NOW()
        ");
        return $stmt->fetchColumn();
    }
    
    private function logActivity($userId, $action, $description) {
        $stmt = $this->db->prepare("
            INSERT INTO activity_logs (user_id, action, description) 
            VALUES (?, ?, ?)
        ");
        $stmt->execute([$userId, $action, $description]);
    }
    
    private function view($view, $data = []) {
        extract($data);
        require_once __DIR__ . '/../views/templates/header.tpl.php';
        require_once __DIR__ . '/../views/' . $view . '.php';
        require_once __DIR__ . '/../views/templates/footer.tpl.php';
    }
}