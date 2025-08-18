<?php

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../../config/Config.php';
require_once __DIR__ . '/../helpers/RecaptchaHelper.php';

class RegisterController {
    private $db;
    private $recaptcha;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
        $this->recaptcha = new Recaptcha(Config::RECAPTCHA_SITE_KEY, Config::RECAPTCHA_SECRET_KEY);
    }
    
    public function index() {
        $errors = [];
        $data = [];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';
            $first_name = trim($_POST['first_name'] ?? '');
            $last_name = trim($_POST['last_name'] ?? '');
            $recaptcha_response = $_POST['g-recaptcha-response'] ?? '';
            
            if (empty($recaptcha_response)) {
                $errors[] = 'Molimo potvrdite da niste robot.';
            } elseif (!$this->recaptcha->verify($recaptcha_response)) {
                $errors[] = 'reCAPTCHA provjera nije uspjela. Pokušajte ponovno.';
            }
            
            if (empty($username)) {
                $errors[] = 'Korisničko ime je obavezno.';
            } elseif (strlen($username) < 3) {
                $errors[] = 'Korisničko ime mora imati najmanje 3 znaka.';
            }
            
            if (empty($email)) {
                $errors[] = 'Email je obavezan.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Email adresa nije valjana.';
            }
            
            if (empty($password)) {
                $errors[] = 'Lozinka je obavezna.';
            } elseif (strlen($password) < 6) {
                $errors[] = 'Lozinka mora imati najmanje 6 znakova.';
            }
            
            if ($password !== $confirm_password) {
                $errors[] = 'Lozinke se ne podudaraju.';
            }
            
            if (empty($first_name)) {
                $errors[] = 'Ime je obavezno.';
            }
            
            if (empty($last_name)) {
                $errors[] = 'Prezime je obavezno.';
            }
            
            if (empty($errors)) {
                $stmt = $this->db->prepare("SELECT id FROM users WHERE username = ?");
                $stmt->execute([$username]);
                if ($stmt->fetch()) {
                    $errors[] = 'Korisničko ime već postoji.';
                }
            }
            
            if (empty($errors)) {
                $stmt = $this->db->prepare("SELECT id FROM users WHERE email = ?");
                $stmt->execute([$email]);
                if ($stmt->fetch()) {
                    $errors[] = 'Email adresa već postoji.';
                }
            }
            
            if (empty($errors)) {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                
                $stmt = $this->db->prepare("
                    INSERT INTO users (username, email, password, first_name, last_name, status) 
                    VALUES (?, ?, ?, ?, ?, 'active')
                ");
                
                if ($stmt->execute([$username, $email, $hashed_password, $first_name, $last_name])) {
                    $user_id = $this->db->lastInsertId();
                    $this->logActivity($user_id, 'register', 'User registered successfully');
                    
                    header('Location: ?page=login&registered=1');
                    exit();
                } else {
                    $errors[] = 'Greška pri stvaranju računa. Pokušajte ponovno.';
                }
            }
            
            $data = [
                'username' => $username,
                'email' => $email,
                'first_name' => $first_name,
                'last_name' => $last_name
            ];
        }
        
        $viewData = [
            'pageTitle' => 'Registracija',
            'errors' => $errors,
            'data' => $data,
            'recaptcha_widget' => $this->recaptcha->getWidget(),
            'recaptcha_script' => $this->recaptcha->getScript()
        ];
        
        $this->view('auth/register', $viewData);
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