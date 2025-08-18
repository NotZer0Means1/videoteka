<?php

require_once __DIR__ . '/../../config/Database.php';

class AjaxUsernameController {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function check() {
        header('Content-Type: application/json');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['error' => 'Only POST requests allowed']);
            return;
        }
        
        $username = trim($_POST['username'] ?? '');
        
        if (empty($username)) {
            echo json_encode([
                'available' => false,
                'message' => 'Korisnicko ime je obavezno.'
            ]);
            return;
        }
        
        if (strlen($username) < 3) {
            echo json_encode([
                'available' => false,
                'message' => 'Korisnicko ime mora imati najmanje 3 znaka.'
            ]);
            return;
        }
        
        try {
            $stmt = $this->db->prepare("SELECT id FROM users WHERE username = ?");
            $stmt->execute([$username]);
            $existingUser = $stmt->fetch();
            
            if ($existingUser) {
                echo json_encode([
                    'available' => false,
                    'message' => 'Korisnicko ime vec postoji.'
                ]);
            } else {
                echo json_encode([
                    'available' => true,
                    'message' => 'Korisnicko ime je dostupno!'
                ]);
            }
            
        } catch (Exception $e) {
            echo json_encode([
                'available' => false,
                'message' => 'Greska pri provjeri. Pokusajte ponovno.'
            ]);
        }
    }
}