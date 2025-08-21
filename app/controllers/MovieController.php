<?php
require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../../config/Config.php';
require_once __DIR__ . '/../helpers/OMDBService.php';

class MovieController {
    private $db;
    private $omdbService;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
        $this->omdbService = new OMDBService(Config::OMDB_API_KEY);
    }
    
    public function index() {
        $search = $_GET['search'] ?? '';
        $genre = $_GET['genre'] ?? '';
        $sort = $_GET['sort'] ?? 'title';
        $page = (int)($_GET['page_num'] ?? 1);
        $perPage = 12;
        $offset = ($page - 1) * $perPage;
        
        $where = "WHERE 1=1";
        $params = [];
        
        if ($search) {
            $where .= " AND (m.title LIKE ? OR m.director LIKE ? OR m.actors LIKE ?)";
            $searchTerm = "%$search%";
            $params = [$searchTerm, $searchTerm, $searchTerm];
        }
        
        if ($genre) {
            $where .= " AND g.id = ?";
            $params[] = $genre;
        }
        
        $orderClause = match($sort) {
            'year' => 'ORDER BY m.year DESC',
            'rating' => 'ORDER BY m.rating DESC',
            'director' => 'ORDER BY m.director ASC',
            default => 'ORDER BY m.title ASC'
        };
        
        $sql = "SELECT m.*, g.name as genre_name 
                FROM movies m 
                LEFT JOIN genres g ON m.genre_id = g.id 
                $where 
                $orderClause 
                LIMIT ? OFFSET ?";
        
        $params[] = $perPage;
        $params[] = $offset;
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $movies = $stmt->fetchAll();
        
        $countSql = "SELECT COUNT(*) FROM movies m LEFT JOIN genres g ON m.genre_id = g.id $where";
        $countParams = array_slice($params, 0, -2);
        $countStmt = $this->db->prepare($countSql);
        $countStmt->execute($countParams);
        $totalMovies = $countStmt->fetchColumn();
        $totalPages = ceil($totalMovies / $perPage);
        
        $genreStmt = $this->db->query("SELECT * FROM genres ORDER BY name");
        $genres = $genreStmt->fetchAll();
        
        $data = [
            'pageTitle' => 'Filmovi',
            'movies' => $movies,
            'genres' => $genres,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'search' => $search,
            'selectedGenre' => $genre,
            'selectedSort' => $sort,
            'totalMovies' => $totalMovies
        ];
        
        $this->view('movies/index', $data);
    }
    
    public function show($id) {
        $stmt = $this->db->prepare("
            SELECT m.*, g.name as genre_name 
            FROM movies m 
            LEFT JOIN genres g ON m.genre_id = g.id 
            WHERE m.id = ?
        ");
        $stmt->execute([$id]);
        $movie = $stmt->fetch();
        
        if (!$movie) {
            header('HTTP/1.0 404 Not Found');
            $this->view('errors/404');
            return;
        }
        
        $data = [
            'pageTitle' => $movie['title'],
            'movie' => $movie
        ];
        
        $this->view('movies/show', $data);
    }
    
    public function searchOMDB() {
        if (!$this->isAdmin()) {
            header('Location: ?page=login');
            exit();
        }
        
        $searchResults = [];
        $searchQuery = '';
        $errors = [];
        
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['q'])) {
            $searchQuery = trim($_GET['q']);
            
            if (strlen($searchQuery) >= 2) {
                $result = $this->omdbService->searchMovies($searchQuery);
                
                if ($result['success']) {
                    $searchResults = $result['movies'];
                } else {
                    $errors[] = $result['error'];
                }
            } else {
                $errors[] = 'Unesite najmanje 2 znaka za pretraživanje.';
            }
        }
        
        $data = [
            'pageTitle' => 'Dodaj film iz OMDB',
            'searchResults' => $searchResults,
            'searchQuery' => $searchQuery,
            'errors' => $errors
        ];
        
        $this->view('movies/search_omdb', $data);
    }
    
    public function addFromOMDB() {
        if (!$this->isAdmin()) {
            header('Location: ?page=login');
            exit();
        }
        
        $imdbId = $_POST['imdb_id'] ?? '';
        
        if (empty($imdbId)) {
            $_SESSION['flash_message'] = 'IMDB ID nije specificiran.';
            $_SESSION['flash_type'] = 'error';
            header('Location: ?page=movies&action=search_omdb');
            exit();
        }
        
        $stmt = $this->db->prepare("SELECT id FROM movies WHERE imdb_id = ?");
        $stmt->execute([$imdbId]);
        if ($stmt->fetch()) {
            $_SESSION['flash_message'] = 'Film već postoji u bazi podataka.';
            $_SESSION['flash_type'] = 'warning';
            header('Location: ?page=movies&action=search_omdb');
            exit();
        }
        
        $result = $this->omdbService->getMovieDetails($imdbId);
        
        if (!$result['success']) {
            $_SESSION['flash_message'] = 'Greška pri dohvaćanju podataka filma: ' . $result['error'];
            $_SESSION['flash_type'] = 'error';
            header('Location: ?page=movies&action=search_omdb');
            exit();
        }
        
        $movieData = $this->omdbService->convertToDbFormat($result['movie']);
        
        try {
            $this->db->beginTransaction();
            
            $genreId = $this->getOrCreateGenre($movieData['genre']);
            
            $stmt = $this->db->prepare("
                INSERT INTO movies (
                    title, year, director, actors, plot, poster_url, 
                    rating, genre_id, runtime, imdb_id
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            
            $stmt->execute([
                $movieData['title'],
                $movieData['year'],
                $movieData['director'],
                $movieData['actors'],
                $movieData['plot'],
                $movieData['poster_url'],
                $movieData['rating'],
                $genreId,
                $movieData['runtime'],
                $movieData['imdb_id']
            ]);
            
            $this->db->commit();
            
            $this->logActivity($_SESSION['user_id'], 'add_movie_omdb', 
                              "Added movie from OMDB: {$movieData['title']}");
            
            $_SESSION['flash_message'] = "Film '{$movieData['title']}' je uspješno dodan.";
            $_SESSION['flash_type'] = 'success';
            
        } catch (Exception $e) {
            $this->db->rollback();
            $_SESSION['flash_message'] = 'Greška pri spremanju filma u bazu podataka.';
            $_SESSION['flash_type'] = 'error';
        }
        
        header('Location: ?page=movies');
        exit();
    }
    
    public function delete($id) {
        if (!$this->isAdmin()) {
            header('Location: ?page=login');
            exit();
        }

        $stmt = $this->db->prepare("SELECT title FROM movies WHERE id = ?");
        $stmt->execute([$id]);
        $movie = $stmt->fetch();
        
        if ($movie) {
            $stmt = $this->db->prepare("DELETE FROM movies WHERE id = ?");
            if ($stmt->execute([$id])) {
                $this->logActivity($_SESSION['user_id'], 'delete_movie', 'Deleted movie: ' . $movie['title']);
                $_SESSION['flash_message'] = 'Film je uspješno obrisan.';
                $_SESSION['flash_type'] = 'success';
            } else {
                $_SESSION['flash_message'] = 'Greška pri brisanju filma.';
                $_SESSION['flash_type'] = 'error';
            }
        }
        
        header('Location: ?page=movies');
        exit();
    }
    
    private function getOrCreateGenre($genreString) {
        $genres = explode(',', $genreString);
        $genreName = trim($genres[0]);

        $stmt = $this->db->prepare("SELECT id FROM genres WHERE name = ?");
        $stmt->execute([$genreName]);
        $genre = $stmt->fetch();
        
        if ($genre) {
            return $genre['id'];
        }

        $stmt = $this->db->prepare("INSERT INTO genres (name) VALUES (?)");
        $stmt->execute([$genreName]);
        return $this->db->lastInsertId();
    }
    
    private function isAdmin() {
        return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
    }
    
    private function logActivity($userId, $action, $description) {
        $stmt = $this->db->prepare("INSERT INTO activity_logs (user_id, action, description) VALUES (?, ?, ?)");
        $stmt->execute([$userId, $action, $description]);
    }
    
    private function view($view, $data = []) {
        extract($data);
        require_once __DIR__ . '/../views/templates/header.tpl.php';
        require_once __DIR__ . '/../views/' . $view . '.php';
        require_once __DIR__ . '/../views/templates/footer.tpl.php';
    }
}