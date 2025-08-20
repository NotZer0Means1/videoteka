<?php

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../../config/Config.php';
require_once __DIR__ . '/../helpers/RecaptchaHelper.php';

class LoginController {
    private $db;
    private $recaptcha;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
        $this->recaptcha = new Recaptcha(Config::RECAPTCHA_SITE_KEY, Config::RECAPTCHA_SECRET_KEY);
    }
    
    public function index() {
        $errors = [];
        $showCaptcha = false;
        
        // Get max failed attempts from admin settings JSON
        $maxFailedAttempts = $this->getMaxFailedAttempts();
        
        $failedAttempts = $_SESSION['failed_attempts'] ?? 0;
        
        if ($failedAttempts >= 2) {
            $showCaptcha = true;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';
            $recaptcha_response = $_POST['g-recaptcha-response'] ?? '';
            
            if (empty($username)) {
                $errors[] = 'Korisničko ime je obavezno.';
            }
            
            if (empty($password)) {
                $errors[] = 'Lozinka je obavezna.';
            }
            
            if ($showCaptcha) {
                if (empty($recaptcha_response)) {
                    $errors[] = 'Molimo potvrdite da niste robot.';
                } elseif (!$this->recaptcha->verify($recaptcha_response)) {
                    $errors[] = 'reCAPTCHA provjera nije uspjela.';
                }
            }
            
            if (empty($errors)) {
                $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ?");
                $stmt->execute([$username]);
                $user = $stmt->fetch();
                
                if ($user) {
                    if ($user['status'] !== 'active') {
                        $errors[] = 'Račun je deaktiviran zbog previše neuspješnih pokušaja prijave.';
                    } elseif (password_verify($password, $user['password'])) {
                        if (session_status() == PHP_SESSION_NONE) {
                            session_start();
                        }
                        
                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['username'] = $user['username'];
                        $_SESSION['first_name'] = $user['first_name'];
                        $_SESSION['last_name'] = $user['last_name'];
                        $_SESSION['role'] = $user['role'];
                        
                        $this->resetFailedAttempts($user['id']);
                        unset($_SESSION['failed_attempts']);
                        
                        $this->logActivity($user['id'], 'login', 'User logged in successfully');
                        
                        header('Location: ?page=home');
                        exit();
                    } else {
                        // Wrong password - increment failed attempts
                        $newFailedCount = $this->incrementFailedAttempts($user['id']);
                        
                        if ($newFailedCount >= $maxFailedAttempts) {
                            // Deactivate account
                            $this->deactivateAccount($user['id']);
                            $errors[] = "Račun je deaktiviran zbog {$maxFailedAttempts} neuspješnih pokušaja prijave.";
                            $this->logActivity($user['id'], 'account_deactivated', "Account deactivated after {$newFailedCount} failed attempts");
                        } else {
                            $attemptsLeft = $maxFailedAttempts - $newFailedCount;
                            $errors[] = "Neispravna lozinka. Preostalo pokušaja: {$attemptsLeft}";
                            $this->logActivity($user['id'], 'failed_login', "Failed login attempt #{$newFailedCount}");
                        }
                        
                        $_SESSION['failed_attempts'] = $failedAttempts + 1;
                        if ($_SESSION['failed_attempts'] >= 2) {
                            $showCaptcha = true;
                        }
                    }
                } else {
                    // User not found
                    $_SESSION['failed_attempts'] = $failedAttempts + 1;
                    $errors[] = 'Neispravno korisničko ime ili lozinka.';
                    
                    if ($_SESSION['failed_attempts'] >= 2) {
                        $showCaptcha = true;
                    }
                    
                    $this->logActivity(null, 'failed_login', "Failed login attempt for username: $username");
                }
            }
        }
        
        $viewData = [
            'pageTitle' => 'Prijava',
            'errors' => $errors,
            'registered' => isset($_GET['registered']),
            'showCaptcha' => $showCaptcha,
            'failedAttempts' => $failedAttempts,
            'recaptcha_widget' => $showCaptcha ? $this->recaptcha->getWidget() : '',
            'recaptcha_script' => $showCaptcha ? $this->recaptcha->getScript() : ''
        ];
        
        $this->view('auth/login', $viewData);
    }
    
    public function logout() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        if (isset($_SESSION['user_id'])) {
            $this->logActivity($_SESSION['user_id'], 'logout', 'User logged out');
        }
        
        session_destroy();
        header('Location: ?page=home');
        exit();
    }
    
    private function getMaxFailedAttempts() {
        $configFile = __DIR__ . '/../../config/admin_settings.json';
        if (file_exists($configFile)) {
            $settings = json_decode(file_get_contents($configFile), true);
            return (int)($settings['max_failed_attempts'] ?? 3);
        }
        return 3;
    }
    
    private function incrementFailedAttempts($userId) {
        $stmt = $this->db->prepare("UPDATE users SET failed_attempts = failed_attempts + 1 WHERE id = ?");
        $stmt->execute([$userId]);
        
        $stmt = $this->db->prepare("SELECT failed_attempts FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchColumn();
    }
    
    private function resetFailedAttempts($userId) {
        $stmt = $this->db->prepare("UPDATE users SET failed_attempts = 0 WHERE id = ?");
        $stmt->execute([$userId]);
    }
    
    private function deactivateAccount($userId) {
        $stmt = $this->db->prepare("UPDATE users SET status = 'inactive' WHERE id = ?");
        $stmt->execute([$userId]);
    }
    
    private function logActivity($user_id, $action, $description) {
        $stmt = $this->db->prepare("INSERT INTO activity_logs (user_id, action, description) VALUES (?, ?, ?)");
        $stmt->execute([$user_id, $action, $description]);
    }
    
    private function view($view, $data = []) {
        extract($data);
        require_once __DIR__ . '/../views/templates/header.tpl.php';
        require_once __DIR__ . '/../views/' . $view . '.php';
        require_once __DIR__ . '/../views/templates/footer.tpl.php';
    }
}