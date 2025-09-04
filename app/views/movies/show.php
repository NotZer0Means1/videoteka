<!-- Movie Detail Page -->
<div class="container">
    <div class="movie-detail">
        <div class="movie-poster-large">
            <?php if ($movie['poster_url']): ?>
                <img src="<?php echo htmlspecialchars($movie['poster_url']); ?>" 
                     alt="<?php echo htmlspecialchars($movie['title']); ?>"
                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                <div class="poster-fallback-large" style="display: none;">🎬</div>
            <?php else: ?>
                <div class="poster-fallback-large">🎬</div>
            <?php endif; ?>
        </div>
        
        <div class="movie-details-full">
            <h1><?php echo htmlspecialchars($movie['title']); ?></h1>
            
            <div class="movie-meta-full">
                <div class="meta-item">
                    <span class="meta-label">Godina</span>
                    <span class="meta-value"><?php echo $movie['year']; ?></span>
                </div>
                
                <?php if ($movie['rating']): ?>
                <div class="meta-item">
                    <span class="meta-label">IMDB Ocjena</span>
                    <span class="meta-value">⭐ <?php echo $movie['rating']; ?>/10</span>
                </div>
                <?php endif; ?>
                
                <?php if ($movie['genre_name']): ?>
                <div class="meta-item">
                    <span class="meta-label">Žanr</span>
                    <span class="meta-value"><?php echo htmlspecialchars($movie['genre_name']); ?></span>
                </div>
                <?php endif; ?>
                
                <?php if ($movie['director']): ?>
                <div class="meta-item">
                    <span class="meta-label">Redatelj</span>
                    <span class="meta-value"><?php echo htmlspecialchars($movie['director']); ?></span>
                </div>
                <?php endif; ?>
                
                <?php if ($movie['runtime']): ?>
                <div class="meta-item">
                    <span class="meta-label">Trajanje</span>
                    <span class="meta-value"><?php echo htmlspecialchars($movie['runtime']); ?></span>
                </div>
                <?php endif; ?>
                
                <div class="meta-item">
                    <span class="meta-label">Status</span>
                    <span class="meta-value">
                        <?php if ($movie['is_available']): ?>
                            <span class="status-available">Dostupno</span>
                        <?php else: ?>
                            <span class="status-rented">Iznajmljeno</span>
                        <?php endif; ?>
                    </span>
                </div>
            </div>
            
            <?php if ($movie['actors']): ?>
            <div class="actors-section">
                <h3>Glavne uloge</h3>
                <p><?php echo htmlspecialchars($movie['actors']); ?></p>
            </div>
            <?php endif; ?>
            
            <?php if ($movie['plot']): ?>
            <div class="plot-section">
                <h3>Radnja</h3>
                <p><?php echo htmlspecialchars($movie['plot']); ?></p>
            </div>
            <?php endif; ?>
            
            <div class="movie-actions">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <?php if ($movie['is_available']): ?>
                        <a href="?page=rentals&action=rent&movie_id=<?php echo $movie['id']; ?>" class="btn btn-primary btn-large">
                            Iznajmi film
                        </a>
                    <?php else: ?>
                        <span class="btn btn-disabled btn-large">Film je iznajmljen</span>
                    <?php endif; ?>
                <?php else: ?>
                    <p class="login-notice">
                        <a href="?page=login">Prijavite se</a> da biste mogli iznajmiti film.
                    </p>
                <?php endif; ?>
                
                <a href="?page=movies" class="btn btn-outline">← Povratak na filmove</a>
                
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    <a href="?page=movies&action=delete&id=<?php echo $movie['id']; ?>" 
                       class="btn btn-danger"
                       onclick="return confirm('Sigurno želite obrisati ovaj film?')">
                        Obriši film
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>