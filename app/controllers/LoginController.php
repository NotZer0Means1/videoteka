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
                $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ? AND status = 'active'");
                $stmt->execute([$username]);
                $user = $stmt->fetch();
                
                if ($user && password_verify($password, $user['password'])) {
                    if (session_status() == PHP_SESSION_NONE) {
                        session_start();
                    }
                    
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['first_name'] = $user['first_name'];
                    $_SESSION['last_name'] = $user['last_name'];
                    $_SESSION['role'] = $user['role'];
                    
                    unset($_SESSION['failed_attempts']);
                    
                    $this->logActivity($user['id'], 'login', 'User logged in with reCAPTCHA');
                    
                    header('Location: ?page=home');
                    exit();
                    
                } else {
                    $_SESSION['failed_attempts'] = $failedAttempts + 1;
                    $errors[] = 'Neispravno korisničko ime ili lozinka.';
                    
                    if ($_SESSION['failed_attempts'] >= 2) {
                        $showCaptcha = true;
                    }
                    
                    $this->logActivity(null, 'failed_login', "Failed login: $username");
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
    
    private function logActivity($user_id, $action, $description) {
        $stmt = $this->db->prepare("
            INSERT INTO activity_logs (user_id, action, description) 
            VALUES (?, ?, ?)
        ");
        $stmt->execute([$user_id, $action, $description]);
    }
    
    private function view($view, $data = []) {
        extract($data);
        
        require_once __DIR__ . '/../views/templates/header.tpl.php';
        require_once __DIR__ . '/../views/' . $view . '.php';
        require_once __DIR__ . '/../views/templates/footer.tpl.php';
    }
}