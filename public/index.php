<?php
session_start();

$page = $_GET['page'] ?? 'home';
$action = $_GET['action'] ?? 'index';

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
        
    case 'check_username':
        require_once '../app/controllers/AjaxUsernameController.php';
        $controller = new AjaxUsernameController();
        $controller->check();
        break;
        
    case 'movies':
        require_once '../app/controllers/MovieController.php';
        $controller = new MovieController();
        
        switch ($action) {
            case 'show':
                $controller->show($_GET['id'] ?? null);
                break;
            case 'add':
                $controller->add();
                break;
            case 'delete':
                $controller->delete($_GET['id'] ?? null);
                break;
            case 'ajax_search':
                $controller->ajaxSearch();
                break;
            default:
                $controller->index();
                break;
        }
        break;
        
    case 'rentals':
        require_once '../app/controllers/RentalController.php';
        $controller = new RentalController();
        
        switch ($action) {
            case 'rent':
                $controller->rent();
                break;
            case 'return':
                $controller->returnMovie();
                break;
            case 'admin':
                $controller->admin();
                break;
            default:
                $controller->index();
                break;
        }
        break;
        
    case 'admin':
        require_once '../app/controllers/AdminController.php';
        $controller = new AdminController();
        
        $section = $_GET['section'] ?? 'dashboard';
        
        switch ($section) {
            case 'users':
                $controller->users();
                break;
            case 'config':
                $controller->config();
                break;
            case 'logs':
                $controller->logs();
                break;
            case 'stats':
                $controller->stats();
                break;
            case 'backup':
                $controller->backup();
                break;
            case 'rentals':
                require_once '../app/controllers/RentalController.php';
                $rentalController = new RentalController();
                $rentalController->admin();
                break;
            default:
                $controller->index();
                break;
        }
        break;
}
?>