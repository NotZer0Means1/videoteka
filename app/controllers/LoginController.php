<?php
/**
 * Login Controller
 * Handles user login and logout only
 */

require_once __DIR__ . '/../../config/Database.php';

class LoginController {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function index() {
        $errors = [];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';
            
            if (empty($username)) {
                $errors[] = 'Korisničko ime je obavezno.';
            }
            
            if (empty($password)) {
                $errors[] = 'Lozinka je obavezna.';
            }
            
            if (empty($errors)) {
                $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ? AND status = 'active'");
                $stmt->execute([$username]);
                $user = $stmt->fetch();
                
                if ($user && password_verify($password, $user['password'])) {
                    // Start session and log in user
                    if (session_status() == PHP_SESSION_NONE) {
                        session_start();
                    }
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['first_name'] = $user['first_name'];
                    $_SESSION['last_name'] = $user['last_name'];
                    $_SESSION['role'] = $user['role'];
                    
                    // Log activity
                    $this->logActivity($user['id'], 'login', 'User logged in');
                    
                    // Redirect to home
                    header('Location: ?page=home');
                    exit();
                } else {
                    $errors[] = 'Neispravno korisničko ime ili lozinka.';
                }
            }
        }
        
        $viewData = [
            'pageTitle' => 'Prijava',
            'errors' => $errors,
            'registered' => isset($_GET['registered'])
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
    
    // Log user activity
    private function logActivity($user_id, $action, $description) {
        $stmt = $this->db->prepare("
            INSERT INTO activity_logs (user_id, action, description) 
            VALUES (?, ?, ?)
        ");
        $stmt->execute([$user_id, $action, $description]);
    }
    
    // Load view
    private function view($view, $data = []) {
        extract($data);
        
        require_once __DIR__ . '/../views/templates/header.tpl.php';
        require_once __DIR__ . '/../views/' . $view . '.php';
        require_once __DIR__ . '/../views/templates/footer.tpl.php';
    }
}