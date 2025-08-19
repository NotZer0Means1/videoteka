<?php
/**
 * Home Controller with Real Database Data
 */

require_once __DIR__ . '/../../config/Database.php';

class HomeController {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function index() {

        $featuredMovies = $this->getFeaturedMovies();
        
        $stats = $this->getSystemStats();
        
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
        
        $data = [
            'pageTitle' => 'Početna',
            'featuredMovies' => $featuredMovies,
            'stats' => $stats,
            'features' => $features
        ];
        
        $this->view('home/index', $data);
    }
    

    private function getFeaturedMovies() {
        try {
            $stmt = $this->db->query("
                SELECT m.*, g.name as genre_name 
                FROM movies m 
                LEFT JOIN genres g ON m.genre_id = g.id 
                ORDER BY 
                    CASE 
                        WHEN m.rating IS NOT NULL THEN m.rating 
                        ELSE 0 
                    END DESC,
                    m.year DESC
                LIMIT 8
            ");
            
            $movies = $stmt->fetchAll();
            
            if (empty($movies)) {
                return [];
            }
            
            $featuredMovies = [];
            foreach ($movies as $movie) {
                $featuredMovies[] = [
                    'id' => $movie['id'],
                    'title' => $movie['title'],
                    'year' => $movie['year'],
                    'rating' => $movie['rating'] ? number_format($movie['rating'], 1) : null,
                    'poster_url' => $movie['poster_url'],
                    'director' => $movie['director'],
                    'genre_name' => $movie['genre_name'],
                    'is_available' => $movie['is_available'],
                    'icon' => $this->getMovieIcon($movie['genre_name'])];
            }
        
            
            return $featuredMovies;
            
        } catch (Exception $e) {
            error_log("Error fetching featured movies: " . $e->getMessage());
            return [];
        }
    }
    
    private function getSystemStats() {
        try {
            $stmt = $this->db->query("SELECT COUNT(*) as count FROM movies");
            $totalMovies = $stmt->fetch()['count'] ?? 0;
            
            $stmt = $this->db->query("SELECT COUNT(*) as count FROM users WHERE role = 'user'");
            $totalUsers = $stmt->fetch()['count'] ?? 0;
            
            $stmt = $this->db->query("
                SELECT 
                    COUNT(*) as total,
                    SUM(CASE WHEN is_available = 1 THEN 1 ELSE 0 END) as available
                FROM movies
            ");
            $movieStats = $stmt->fetch();
            
            $availabilityPercentage = $movieStats['total'] > 0 
                ? round(($movieStats['available'] / $movieStats['total']) * 100) 
                : 100;
            
            return [
                'total_movies' => $totalMovies,
                'total_users' => $totalUsers,
                'availability' => $availabilityPercentage . '%'
            ];
            
        } catch (Exception $e) {
            error_log("Error fetching system stats: " . $e->getMessage());
            return [
                'total_movies' => '0',
                'total_users' => '0',
                'availability' => '100%'
            ];
        }
    }
    
    private function getMovieIcon($genre) {
        $genreIcons = [
            'Action' => '💥',
            'Comedy' => '😂',
            'Drama' => '🎭',
            'Horror' => '👻',
            'Romance' => '💕',
            'Sci-Fi' => '🚀',
            'Thriller' => '😱',
            'Animation' => '🎨',
            'Crime' => '🔫',
            'Adventure' => '🗺️',
            'Fantasy' => '🧙',
            'Mystery' => '🔍',
            'War' => '⚔️',
            'Western' => '🤠',
            'Musical' => '🎵',
            'Biography' => '📖',
            'History' => '🏛️',
            'Sport' => '⚽',
            'Family' => '👨‍👩‍👧‍👦'
        ];

        foreach ($genreIcons as $genreName => $icon) {
            if (stripos($genre, $genreName) !== false) {
                return $icon;
            }
        }
        return '🎬';
    }
    
    private function view($view, $data = []) {
        extract($data);
        require_once __DIR__ . '/../views/templates/header.tpl.php';
        require_once __DIR__ . '/../views/' . $view . '.php';
        require_once __DIR__ . '/../views/templates/footer.tpl.php';
    }
}