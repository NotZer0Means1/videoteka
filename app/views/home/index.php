<!-- Hero Section -->
<section class="hero" id="home">
    <div class="container">
        <h1>Dobrodošli u Videoteku</h1>
        <p>Vaš omiljeni servis za iznajmljivanje filmova</p>
        
        <div class="hero-stats">
            <div class="stat-item">
                <span class="stat-number"><?php echo $stats['total_movies']; ?>+</span>
                <span class="stat-label">Filmova</span>
            </div>
            <div class="stat-item">
                <span class="stat-number"><?php echo $stats['total_users']; ?>+</span>
                <span class="stat-label">Članova</span>
            </div>
            <div class="stat-item">
                <span class="stat-number"><?php echo $stats['availability']; ?></span>
                <span class="stat-label">Dostupnost</span>
            </div>
        </div>
        
        <div class="hero-buttons">
            <a href="register.php" class="btn btn-primary btn-large">Registriraj se besplatno</a>
            <a href="movies.php" class="btn btn-outline btn-large">Pregledaj filmove</a>
        </div>
    </div>
</section>

<!-- Search Section -->
<section class="search-section">
    <div class="container">
        <form class="search-box" method="GET" action="search.php">
            <input type="text" name="q" class="search-input" placeholder="Pretraži filmove po nazivu, redatelju ili glumcima...">
            <button type="submit" class="search-btn">Pretraži</button>
        </form>
    </div>
</section>

<!-- Featured Movies -->
<section class="featured-movies" id="movies">
    <div class="container">
        <h2 class="section-title">Izdvojeni filmovi</h2>
        <div class="movies-grid">
            <?php foreach ($featuredMovies as $movie): ?>
                <div class="movie-card">
                    <div class="movie-poster">
                        <?php echo $movie['icon']; ?>
                        <div class="movie-overlay">
                            <a href="movie.php?id=<?php echo $movie['id']; ?>" class="btn btn-primary">Pogledaj detalje</a>
                        </div>
                    </div>
                    <div class="movie-info">
                        <h3 class="movie-title"><?php echo htmlspecialchars($movie['title']); ?></h3>
                        <div class="movie-meta">
                            <span><?php echo $movie['year']; ?></span>
                            <span class="movie-rating">⭐ <?php echo $movie['rating']; ?></span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Features -->
<section class="features">
    <div class="container">
        <h2 class="section-title">Zašto odabrati nas?</h2>
        <div class="features-grid">
            <?php foreach ($features as $feature): ?>
                <div class="feature-card">
                    <div class="feature-icon"><?php echo $feature['icon']; ?></div>
                    <h3 class="feature-title"><?php echo htmlspecialchars($feature['title']); ?></h3>
                    <p class="feature-desc"><?php echo htmlspecialchars($feature['description']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>