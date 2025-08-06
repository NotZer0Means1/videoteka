<?php
/**
 * Front Controller - Entry Point
 * Simple routing for videoteka
 */

// Start session
session_start();

// Get the requested page
$page = $_GET['page'] ?? 'home';

// Route to appropriate controller
switch ($page) {
    case 'home':
    default:
        require_once '../app/controllers/HomeController.php';
        $controller = new HomeController();
        $controller->index();
        break;
        
    case 'register':
        require_once '../app/controllers/RegisterController.php';
        $controller = new RegisterController();
        $controller->index();
        break;
        
    case 'login':
        require_once '../app/controllers/LoginController.php';
        $controller = new LoginController();
        $controller->index();
        break;
        
    case 'logout':
        require_once '../app/controllers/LoginController.php';
        $controller = new LoginController();
        $controller->logout();
        break;
        
    case 'movies':
        // Later: require_once '../app/controllers/MovieController.php';
        echo "Movies page - coming soon";
        break;
        
    case 'contact':
        // Later: require_once '../app/controllers/ContactController.php';
        echo "Contact page - coming soon";
        break;
}
?>