<?php
class DocumentationController {
    
    public function index() {
        $data = [
            'pageTitle' => 'Dokumentacija'
        ];
        
        $this->view('docs/index', $data);
    }
    
    private function view($view, $data = []) {
        extract($data);
        require_once __DIR__ . '/../views/templates/header.tpl.php';
        require_once __DIR__ . '/../views/' . $view . '.php';
        require_once __DIR__ . '/../views/templates/footer.tpl.php';
    }
}