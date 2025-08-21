<!-- Movies Index Page -->
<div class="container">
    <div class="movies-header">
        <h1>Filmovi</h1>
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <a href="?page=movies&action=search_omdb" class="btn btn-primary">Dodaj novi film</a>
        <?php endif; ?>
    </div>
    
    <!-- Search and Filter Section -->
    <div class="movies-filters">
        <form method="GET" class="filter-form" id="movieFilters">
            <input type="hidden" name="page" value="movies">
            
            <div class="filter-row">
                <div class="search-group">
                    <input type="text" 
                           name="search" 
                           id="movieSearch"
                           value="<?php echo htmlspecialchars($search); ?>" 
                           placeholder="Pretraži po nazivu, redatelju ili glumcima...">
                </div>
                
                <div class="filter-group">
                    <select name="genre" id="genreFilter">
                        <option value="">Svi žanrovi</option>
                        <?php foreach ($genres as $genre): ?>
                            <option value="<?php echo $genre['id']; ?>" 
                                    <?php echo $selectedGenre == $genre['id'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($genre['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="filter-group">
                    <select name="sort" id="sortFilter">
                        <option value="title" <?php echo $selectedSort === 'title' ? 'selected' : ''; ?>>Naziv A-Z</option>
                        <option value="year" <?php echo $selectedSort === 'year' ? 'selected' : ''; ?>>Najnoviji</option>
                        <option value="rating" <?php echo $selectedSort === 'rating' ? 'selected' : ''; ?>>Najbolji</option>
                        <option value="director" <?php echo $selectedSort === 'director' ? 'selected' : ''; ?>>Redatelj</option>
                    </select>
                </div>
                
                <button type="submit" class="btn btn-primary">Filtriraj</button>
                <?php if ($search || $selectedGenre): ?>
                    <a href="?page=movies" class="btn btn-outline">Poništi</a>
                <?php endif; ?>
            </div>
        </form>
    </div>
    
    <!-- Results Info -->
    <div class="results-info">
        <p>Pronađeno <strong><?php echo $totalMovies; ?></strong> filmova</p>
        <?php if ($search): ?>
            <p>Rezultati pretrage za: "<strong><?php echo htmlspecialchars($search); ?></strong>"</p>
        <?php endif; ?>
    </div>
    
    <!-- Movies Grid -->
    <?php if (empty($movies)): ?>
        <div class="no-results">
            <h3>Nema filmova</h3>
            <?php if ($search || $selectedGenre): ?>
                <p>Pokušajte promijeniti kriterije pretrage.</p>
                <a href="?page=movies" class="btn btn-outline">Prikaži sve filmove</a>
            <?php else: ?>
                <p>Trenutno nema filmova u bazi podataka.</p>
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    <a href="?page=movies&action=search_omdb" class="btn btn-primary">Dodaj prvi film</a>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <div class="movies-grid">
            <?php foreach ($movies as $movie): ?>
                <div class="movie-card" data-movie-id="<?php echo $movie['id']; ?>">
                    <div class="movie-poster">
                        <?php if ($movie['poster_url']): ?>
                            <img src="<?php echo htmlspecialchars($movie['poster_url']); ?>" 
                                 alt="<?php echo htmlspecialchars($movie['title']); ?>"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="poster-fallback" style="display: none;"></div>
                        <?php else: ?>
                            <div class="poster-fallback"></div>
                        <?php endif; ?>
                        
                        <div class="movie-overlay">
                            <a href="?page=movies&action=show&id=<?php echo $movie['id']; ?>" class="btn btn-primary">Detalji</a>
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <?php if ($movie['is_available']): ?>
                                    <a href="?page=rentals&action=rent&movie_id=<?php echo $movie['id']; ?>" class="btn btn-outline">Iznajmi</a>
                                <?php else: ?>
                                    <span class="btn btn-disabled">Iznajmljeno</span>
                                <?php endif; ?>
                            <?php endif; ?>
                            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                                <a href="?page=movies&action=delete&id=<?php echo $movie['id']; ?>" 
                                   class="btn btn-danger btn-small"
                                   onclick="return confirm('Sigurno želite obrisati film?')">Obriši</a>
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
                            <span class="movie-year"><?php echo $movie['year']; ?></span>
                            <?php if ($movie['rating']): ?>
                                <span class="movie-rating">⭐ <?php echo $movie['rating']; ?></span>
                            <?php endif; ?>
                        </div>
                        
                        <div class="movie-details">
                            <?php if ($movie['director']): ?>
                                <p class="movie-director">
                                    <strong>Redatelj:</strong> <?php echo htmlspecialchars($movie['director']); ?>
                                </p>
                            <?php endif; ?>
                            
                            <?php if ($movie['genre_name']): ?>
                                <span class="movie-genre"><?php echo htmlspecialchars($movie['genre_name']); ?></span>
                            <?php endif; ?>
                            
                            <div class="availability-status">
                                <?php if ($movie['is_available']): ?>
                                    <span class="status-available">✓ Dostupno</span>
                                <?php else: ?>
                                    <span class="status-rented">Iznajmljeno</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Pagination -->
        <?php if ($totalPages > 1): ?>
            <div class="pagination">
                <?php if ($currentPage > 1): ?>
                    <a href="?page=movies&search=<?php echo urlencode($search); ?>&genre=<?php echo $selectedGenre; ?>&sort=<?php echo $selectedSort; ?>&page_num=<?php echo $currentPage - 1; ?>" 
                       class="btn btn-outline">« Prethodna</a>
                <?php endif; ?>
                
                <div class="page-numbers">
                    <?php for ($i = max(1, $currentPage - 2); $i <= min($totalPages, $currentPage + 2); $i++): ?>
                        <?php if ($i === $currentPage): ?>
                            <span class="current-page"><?php echo $i; ?></span>
                        <?php else: ?>
                            <a href="?page=movies&search=<?php echo urlencode($search); ?>&genre=<?php echo $selectedGenre; ?>&sort=<?php echo $selectedSort; ?>&page_num=<?php echo $i; ?>" 
                               class="page-link"><?php echo $i; ?></a>
                        <?php endif; ?>
                    <?php endfor; ?>
                </div>
                
                <?php if ($currentPage < $totalPages): ?>
                    <a href="?page=movies&search=<?php echo urlencode($search); ?>&genre=<?php echo $selectedGenre; ?>&sort=<?php echo $selectedSort; ?>&page_num=<?php echo $currentPage + 1; ?>" 
                       class="btn btn-outline">Sljedeća »</a>
                <?php endif; ?>
            </div>
            
            <div class="pagination-info">
                Stranica <?php echo $currentPage; ?> od <?php echo $totalPages; ?> 
                (ukupno <?php echo $totalMovies; ?> filmova)
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>

<script>

document.addEventListener('DOMContentLoaded', function() {
    const genreFilter = document.getElementById('genreFilter');
    const sortFilter = document.getElementById('sortFilter');
    const form = document.getElementById('movieFilters');
    
    if (genreFilter) {
        genreFilter.addEventListener('change', function() {
            form.submit();
        });
    }
    
    if (sortFilter) {
        sortFilter.addEventListener('change', function() {
            form.submit();
        });
    }
});
</script>