<!-- Movies Index with AJAX Search -->
<div class="movies-page">
    <div class="container">
        <h1>Filmovi u videoteci</h1>
        
        <!-- Search and Filters -->
        <div class="search-section">
            <div class="search-controls">
                <input type="text" 
                       id="searchInput" 
                       placeholder="Pretraži filmove (naziv, redatelj, glumci)..." 
                       value="<?php echo htmlspecialchars($search); ?>"
                       class="search-input">
                
                <select id="genreSelect" class="filter-select">
                    <option value="all">Svi žanrovi</option>
                    <?php foreach ($genres as $genre): ?>
                        <option value="<?php echo $genre['id']; ?>" 
                                <?php echo ($selectedGenre == $genre['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($genre['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                
                <select id="sortSelect" class="filter-select">
                    <option value="title" <?php echo ($selectedSort === 'title') ? 'selected' : ''; ?>>
                        Naziv A-Z
                    </option>
                    <option value="year" <?php echo ($selectedSort === 'year') ? 'selected' : ''; ?>>
                        Godina (najnoviji)
                    </option>
                    <option value="rating" <?php echo ($selectedSort === 'rating') ? 'selected' : ''; ?>>
                        Ocjena (najviša)
                    </option>
                    <option value="director" <?php echo ($selectedSort === 'director') ? 'selected' : ''; ?>>
                        Redatelj A-Z
                    </option>
                </select>
            </div>
            
            <div class="search-info">
                <span>Prikazano <strong id="movieCount"><?php echo $totalMovies; ?></strong> filmova</span>
            </div>
        </div>
        
        <!-- Movies Grid -->
        <div id="moviesContainer" class="movies-grid">
            <?php if (empty($movies)): ?>
                <div class="no-movies">
                    <p>Nema filmova koji odgovaraju kriterijima pretrage.</p>
                </div>
            <?php else: ?>
                <?php foreach ($movies as $movie): ?>
                    <div class="movie-card">
                        <div class="movie-poster">
                            <?php if ($movie['poster_url']): ?>
                                <img src="<?php echo htmlspecialchars($movie['poster_url']); ?>" 
                                     alt="<?php echo htmlspecialchars($movie['title']); ?>"
                                     loading="lazy">
                            <?php else: ?>
                                <div class="no-poster">🎬</div>
                            <?php endif; ?>
                            
                            <div class="movie-overlay">
                                <a href="?page=movies&action=show&id=<?php echo $movie['id']; ?>" 
                                   class="btn btn-primary">Pogledaj detalje</a>
                                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                                    <a href="?page=movies&action=delete&id=<?php echo $movie['id']; ?>" 
                                       class="btn btn-danger"
                                       onclick="return confirm('Jeste li sigurni da želite obrisati film?')">Obriši</a>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="movie-info">
                            <h3 class="movie-title"><?php echo htmlspecialchars($movie['title']); ?></h3>
                            <div class="movie-meta">
                                <span class="movie-year"><?php echo $movie['year']; ?></span>
                                <?php if ($movie['genre_name']): ?>
                                    <span class="movie-genre"><?php echo htmlspecialchars($movie['genre_name']); ?></span>
                                <?php endif; ?>
                                <?php if ($movie['rating']): ?>
                                    <span class="movie-rating">⭐ <?php echo number_format($movie['rating'], 1); ?></span>
                                <?php endif; ?>
                            </div>
                            <?php if ($movie['director']): ?>
                                <p class="movie-director">
                                    Redatelj: <?php echo htmlspecialchars($movie['director']); ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        
        <!-- Pagination (for non-AJAX fallback) -->
        <?php if ($totalPages > 1): ?>
            <div class="pagination">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="?page=movies&page_num=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>&genre=<?php echo $selectedGenre; ?>&sort=<?php echo $selectedSort; ?>" 
                       class="<?php echo ($i === $currentPage) ? 'active' : ''; ?>">
                        <?php echo $i; ?>
                    </a>
                <?php endfor; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Load CSS and JavaScript -->
<link rel="stylesheet" href="css/movies/ajax.css">
<script src="js/search.js"></script>