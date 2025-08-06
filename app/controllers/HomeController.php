<?php
/**
 * Home Controller
 * Handles homepage requests
 */

class HomeController {
    
    public function index() {
        // Get sample data (later from database)
        $featuredMovies = [
            [
                'id' => 1,
                'title' => 'The Matrix',
                'year' => 1999,
                'rating' => 8.7,
                'icon' => '🎭'
            ],
            [
                'id' => 2,
                'title' => 'Pulp Fiction',
                'year' => 1994,
                'rating' => 8.9,
                'icon' => '🎬'
            ],
            [
                'id' => 3,
                'title' => 'The Dark Knight',
                'year' => 2008,
                'rating' => 9.0,
                'icon' => '🎪'
            ],
            [
                'id' => 4,
                'title' => 'Inception',
                'year' => 2010,
                'rating' => 8.8,
                'icon' => '🎯'
            ]
        ];
        
        $stats = [
            'total_movies' => 1000,
            'total_users' => 500,
            'availability' => '24/7'
        ];
        
        $features = [
            [
                'icon' => '📱',
                'title' => 'Jednostavno korištenje',
                'description' => 'Intuitivno sučelje za brzo pronalaženje i iznajmljivanje filmova'
            ],
            [
                'icon' => '🚀',
                'title' => 'Brza dostava',
                'description' => 'Filmovi dostupni odmah nakon iznajmljivanja'
            ],
            [
                'icon' => '💎',
                'title' => 'Kvaliteta',
                'description' => 'Samo najbolji filmovi u HD kvaliteti'
            ]
        ];
        
        // Prepare data for view
        $data = [
            'pageTitle' => 'Početna',
            'featuredMovies' => $featuredMovies,
            'stats' => $stats,
            'features' => $features
        ];
        
        // Load view
        $this->view('home/index', $data);
    }
    
    // Helper method to load views
    private function view($view, $data = []) {
        // Extract data to variables
        extract($data);
        
        // Load header
        require_once __DIR__ . '/../views/templates/header.tpl.php';
        
        // Load main content
        require_once __DIR__ . '/../views/' . $view . '.php';
        
        // Load footer
        require_once __DIR__ . '/../views/templates/footer.tpl.php';
    }
}