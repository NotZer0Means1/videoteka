<!-- Hero Section -->
<section class="hero" id="home">
    <div class="container">
        <h1>Dobrodošli u Videoteku</h1>
        <p>Vaš omiljeni servis za iznajmljivanje filmova</p>
        
        <div class="hero-stats">
            <div class="stat-item">
                <span class="stat-number"><?php echo $stats['total_movies']; ?></span>
                <span class="stat-label">Filmova</span>
            </div>
            <div class="stat-item">
                <span class="stat-number"><?php echo $stats['total_users']; ?></span>
                <span class="stat-label">Članova</span>
            </div>
            <div class="stat-item">
                <span class="stat-number"><?php echo $stats['availability']; ?></span>
                <span class="stat-label">Dostupnost</span>
            </div>
        </div>

<!-- Search Section -->
<section class="search-section">
    <div class="container">
        <form class="search-box" method="GET" action="?page=movies">
            <input type="text" name="search" class="search-input" placeholder="Pretraži filmove po nazivu, redatelju ili glumcima...">
            <button type="submit" class="search-btn">Pretraži</button>
        </form>
    </div>
</section>

<!-- Featured Movies -->
<section class="featured-movies" id="movies">
    <div class="container">
        <h2 class="section-title">
            <?php if (!empty($featuredMovies)): ?>
                Izdvojeni filmovi
            <?php else: ?>
                Filmovi
            <?php endif; ?>
        </h2>
        
        <?php if (!empty($featuredMovies)): ?>
            <div class="movies-grid">
                <?php foreach ($featuredMovies as $movie): ?>
                    <div class="movie-card">
                        <div class="movie-poster">
                            <?php if ($movie['poster_url']): ?>
                                <img src="<?php echo htmlspecialchars($movie['poster_url']); ?>" 
                                     alt="<?php echo htmlspecialchars($movie['title']); ?>"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div class="poster-fallback" style="display: none;"><?php echo $movie['icon']; ?></div>
                            <?php else: ?>
                                <div class="poster-fallback"><?php echo $movie['icon']; ?></div>
                            <?php endif; ?>
                            
                            <div class="movie-overlay">
                                <a href="?page=movies&action=show&id=<?php echo $movie['id']; ?>" class="btn btn-primary">Pogledaj detalje</a>
                                <?php if (isset($_SESSION['user_id'])): ?>
                                    <?php if ($movie['is_available']): ?>
                                        <a href="?page=rentals&action=rent&movie_id=<?php echo $movie['id']; ?>" class="btn btn-outline">Iznajmi</a>
                                    <?php else: ?>
                                        <span class="btn btn-disabled">Iznajmljeno</span>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="movie-info">
                            <h3 class="movie-title">
                                <a href="?page=movies&action=show&id=<?php echo $movie['id']; ?>">
                                    <?php echo htmlspecialchars($movie['title']); ?>
                                </a>
                            </h3>
                            <div class="movie-meta">
                                <span><?php echo $movie['year']; ?></span>
                                <?php if ($movie['rating']): ?>
                                    <span class="movie-rating">⭐ <?php echo $movie['rating']; ?></span>
                                <?php endif; ?>
                            </div>
                            
                            <?php if ($movie['director']): ?>
                                <p class="movie-director">
                                    <strong>Redatelj:</strong> <?php echo htmlspecialchars($movie['director']); ?>
                                </p>
                            <?php endif; ?>
                            
                            <?php if ($movie['genre_name']): ?>
                                <span class="movie-genre"><?php echo htmlspecialchars($movie['genre_name']); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="text-center" style="margin-top: 40px;">
                <a href="?page=movies" class="btn btn-primary btn-large">Pogledaj sve filmove</a>
            </div>
        <?php else: ?>
            <!-- No movies available -->
            <div class="no-movies-message">
                <div style="text-align: center; padding: 60px 20px; background-color: #1a1a1a; border-radius: 10px; border: 1px solid #333;">
                    <h3 style="color: #00bcd4; margin-bottom: 20px;">🎬 Trenutno nema filmova</h3>
                    <p style="color: #b0b0b0; margin-bottom: 30px;">Filmovi će biti dodani uskoro. Registrirajte se da budete među prvima koji će ih vidjeti!</p>
                    
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                        <a href="?page=movies&action=search_omdb" class="btn btn-primary btn-large">Dodaj prvi film</a>
                    <?php elseif (!isset($_SESSION['user_id'])): ?>
                        <a href="?page=register" class="btn btn-primary btn-large">Registriraj se</a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>