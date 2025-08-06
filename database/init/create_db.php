<?php
/**
 * Database Initialization Script
 * Run this file once to set up the database
 * Contains schema and seed data in one file
 */

// Database config
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'videoteka';

try {
    // Connect to MySQL
    $pdo = new PDO("mysql:host=$host", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create database and tables
    $schema = "
        CREATE DATABASE IF NOT EXISTS videoteka;
        USE videoteka;

        CREATE TABLE IF NOT EXISTS users (
            id INT PRIMARY KEY AUTO_INCREMENT,
            username VARCHAR(50) UNIQUE NOT NULL,
            email VARCHAR(100) UNIQUE NOT NULL,
            password VARCHAR(255) NOT NULL,
            first_name VARCHAR(100) NOT NULL,
            last_name VARCHAR(100) NOT NULL,
            role ENUM('admin', 'user') DEFAULT 'user',
            status ENUM('active', 'inactive', 'pending') DEFAULT 'active',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );

        CREATE TABLE IF NOT EXISTS genres (
            id INT PRIMARY KEY AUTO_INCREMENT,
            name VARCHAR(50) UNIQUE NOT NULL
        );

        CREATE TABLE IF NOT EXISTS movies (
            id INT PRIMARY KEY AUTO_INCREMENT,
            title VARCHAR(255) NOT NULL,
            year INT NOT NULL,
            director VARCHAR(255),
            actors TEXT,
            plot TEXT,
            poster_url VARCHAR(500),
            rating DECIMAL(3,1),
            genre_id INT,
            is_available BOOLEAN DEFAULT TRUE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (genre_id) REFERENCES genres(id),
            FULLTEXT(title, director, actors)
        );

        CREATE TABLE IF NOT EXISTS rentals (
            id INT PRIMARY KEY AUTO_INCREMENT,
            user_id INT NOT NULL,
            movie_id INT NOT NULL,
            rental_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            due_date TIMESTAMP NULL,
            return_date TIMESTAMP NULL,
            status ENUM('active', 'returned', 'overdue') DEFAULT 'active',
            FOREIGN KEY (user_id) REFERENCES users(id),
            FOREIGN KEY (movie_id) REFERENCES movies(id)
        );

        CREATE TABLE IF NOT EXISTS activity_logs (
            id INT PRIMARY KEY AUTO_INCREMENT,
            user_id INT,
            action VARCHAR(50) NOT NULL,
            description TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id)
        );

        CREATE TABLE IF NOT EXISTS contact_messages (
            id INT PRIMARY KEY AUTO_INCREMENT,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL,
            subject VARCHAR(200) NOT NULL,
            message TEXT NOT NULL,
            is_read BOOLEAN DEFAULT FALSE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );
    ";
    
    // Execute schema
    $statements = explode(';', $schema);
    foreach ($statements as $statement) {
        $statement = trim($statement);
        if (!empty($statement)) {
            $pdo->exec($statement);
        }
    }
    
    // Use the database
    $pdo->exec("USE $dbname");
    
    // Insert sample data
    $seedData = [
        // Insert genres
        "INSERT IGNORE INTO genres (name) VALUES 
         ('Action'), ('Comedy'), ('Drama'), ('Horror'), ('Romance'), 
         ('Sci-Fi'), ('Thriller'), ('Animation'), ('Crime'), ('Adventure')",
        
        // Insert admin user (password: admin123)
        "INSERT IGNORE INTO users (username, email, password, first_name, last_name, role) VALUES 
         ('admin', 'admin@videoteka.com', 'admin123', 'Admin', 'User', 'admin')",
        
        // Insert test user (password: user123)  
        "INSERT IGNORE INTO users (username, email, password, first_name, last_name, role) VALUES 
         ('testuser', 'user@test.com', 'user123', 'Test', 'User', 'user')",
        
        // Insert sample movies
        "INSERT IGNORE INTO movies (title, year, director, actors, plot, rating, genre_id) VALUES 
         ('The Matrix', 1999, 'Wachowski Sisters', 'Keanu Reeves, Laurence Fishburne', 'A computer hacker learns reality is a simulation', 8.7, 6)",
        
        "INSERT IGNORE INTO movies (title, year, director, actors, plot, rating, genre_id) VALUES 
         ('Pulp Fiction', 1994, 'Quentin Tarantino', 'John Travolta, Samuel L. Jackson', 'Interconnected stories of crime in Los Angeles', 8.9, 9)",
        
        "INSERT IGNORE INTO movies (title, year, director, actors, plot, rating, genre_id) VALUES 
         ('The Shawshank Redemption', 1994, 'Frank Darabont', 'Tim Robbins, Morgan Freeman', 'Two imprisoned men bond over years', 9.3, 3)",
        
        "INSERT IGNORE INTO movies (title, year, director, actors, plot, rating, genre_id) VALUES 
         ('The Dark Knight', 2008, 'Christopher Nolan', 'Christian Bale, Heath Ledger', 'Batman faces the Joker', 9.0, 1)",
        
        "INSERT IGNORE INTO movies (title, year, director, actors, plot, rating, genre_id) VALUES 
         ('Forrest Gump', 1994, 'Robert Zemeckis', 'Tom Hanks', 'Life story of a simple man', 8.8, 3)",
        
        "INSERT IGNORE INTO movies (title, year, director, actors, plot, rating, genre_id) VALUES 
         ('Inception', 2010, 'Christopher Nolan', 'Leonardo DiCaprio', 'Dreams within dreams', 8.8, 6)",
        
        "INSERT IGNORE INTO movies (title, year, director, actors, plot, rating, genre_id) VALUES 
         ('Titanic', 1997, 'James Cameron', 'Leonardo DiCaprio, Kate Winslet', 'Love story on a sinking ship', 7.8, 5)",
        
        "INSERT IGNORE INTO movies (title, year, director, actors, plot, rating, genre_id) VALUES 
         ('The Godfather', 1972, 'Francis Ford Coppola', 'Marlon Brando, Al Pacino', 'Crime family saga', 9.2, 9)",
        
        "INSERT IGNORE INTO movies (title, year, director, actors, plot, rating, genre_id) VALUES 
         ('Toy Story', 1995, 'John Lasseter', 'Tom Hanks, Tim Allen', 'Toys come to life', 8.3, 8)",
        
        "INSERT IGNORE INTO movies (title, year, director, actors, plot, rating, genre_id) VALUES 
         ('Jaws', 1975, 'Steven Spielberg', 'Roy Scheider', 'Shark terrorizes beach town', 8.0, 7)",
        
        // Insert sample contact message
        "INSERT IGNORE INTO contact_messages (name, email, subject, message) VALUES 
         ('Marko Marić', 'marko@example.com', 'Upit o filmovima', 'Pozdrav, zanima me kada će biti dostupan novi film Avengers. Hvala!')",
        
        // Insert sample activity logs
        "INSERT IGNORE INTO activity_logs (user_id, action, description) VALUES 
         (1, 'login', 'Administrator login')",
        
        "INSERT IGNORE INTO activity_logs (user_id, action, description) VALUES 
         (2, 'register', 'New user registration')"
    ];
    
    // Execute each insert statement
    foreach ($seedData as $sql) {
        $pdo->exec($sql);
    }
    

    
} catch (Exception $e) {
    
}
?>