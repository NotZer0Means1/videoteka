<?php

class OMDBService {
    private $apiKey;
    private $baseUrl = 'http://www.omdbapi.com/';
    
    public function __construct($apiKey) {
        $this->apiKey = $apiKey;
    }
    
    public function searchMovies($title, $page = 1) {
        $url = $this->baseUrl . '?' . http_build_query([
            'apikey' => $this->apiKey,
            's' => $title,
            'page' => $page,
            'type' => 'movie'
        ]);
        
        $response = $this->makeRequest($url);
        
        if ($response && isset($response['Response']) && $response['Response'] === 'True') {
            return [
                'success' => true,
                'movies' => $response['Search'],
                'totalResults' => (int)$response['totalResults']
            ];
        }
        
        return [
            'success' => false,
            'error' => $response['Error'] ?? 'Unknown error'
        ];
    }

    public function getMovieDetails($imdbId) {
        $url = $this->baseUrl . '?' . http_build_query([
            'apikey' => $this->apiKey,
            'i' => $imdbId,
            'plot' => 'full'
        ]);
        
        $response = $this->makeRequest($url);
        
        if ($response && isset($response['Response']) && $response['Response'] === 'True') {
            return [
                'success' => true,
                'movie' => $response
            ];
        }
        
        return [
            'success' => false,
            'error' => $response['Error'] ?? 'Movie not found'
        ];
    }
    
    public function getMovieByTitle($title) {
        $url = $this->baseUrl . '?' . http_build_query([
            'apikey' => $this->apiKey,
            't' => $title,
            'plot' => 'full'
        ]);
        
        $response = $this->makeRequest($url);
        
        if ($response && isset($response['Response']) && $response['Response'] === 'True') {
            return [
                'success' => true,
                'movie' => $response
            ];
        }
        
        return [
            'success' => false,
            'error' => $response['Error'] ?? 'Movie not found'
        ];
    }
    
    private function makeRequest($url) {
        $context = stream_context_create([
            'http' => [
                'timeout' => 10,
                'user_agent' => 'Videoteka/1.0'
            ]
        ]);
        
        $response = @file_get_contents($url, false, $context);
        
        if ($response === false) {
            return null;
        }
        
        return json_decode($response, true);
    }

    public function convertToDbFormat($omdbMovie) {
        return [
            'title' => $omdbMovie['Title'] ?? '',
            'year' => isset($omdbMovie['Year']) ? (int)$omdbMovie['Year'] : null,
            'director' => $omdbMovie['Director'] ?? null,
            'actors' => $omdbMovie['Actors'] ?? null,
            'plot' => $omdbMovie['Plot'] ?? null,
            'poster_url' => ($omdbMovie['Poster'] ?? 'N/A') !== 'N/A' ? $omdbMovie['Poster'] : null,
            'rating' => isset($omdbMovie['imdbRating']) && $omdbMovie['imdbRating'] !== 'N/A' 
                       ? (float)$omdbMovie['imdbRating'] : null,
            'genre' => $omdbMovie['Genre'] ?? 'Drama',
            'runtime' => $omdbMovie['Runtime'] ?? null,
            'imdb_id' => $omdbMovie['imdbID'] ?? null
        ];
    }
}