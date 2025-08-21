<?php

require_once __DIR__ . '/../../config/Database.php';

class RssController {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function index() {
        header('Content-Type: application/rss+xml; charset=utf-8');
        
        $stmt = $this->db->query("
            SELECT m.*, g.name as genre_name 
            FROM movies m 
            LEFT JOIN genres g ON m.genre_id = g.id 
            ORDER BY m.created_at DESC 
            LIMIT 20
        ");
        $movies = $stmt->fetchAll();
        
        $rssData = [
            'title' => 'Videoteka - Najnoviji filmovi',
            'description' => 'Najnoviji filmovi dodani u našu videoteku',
            'link' => 'http://localhost/videoteka',
            'movies' => $movies
        ];
        
        require_once __DIR__ . '/../views/rss/feed.php';
    }
}