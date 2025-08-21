<div class="container">
    <div class="page-header">
        <h1>Dodaj film iz OMDB baze</h1>
        <p>Pretražite i dodajte filmove iz Online Movie Database</p>
        <a href="?page=movies" class="btn btn-outline">← Povratak na filmove</a>
    </div>
    
    <div class="search-section">
        <form method="GET" class="omdb-search-form">
            <input type="hidden" name="page" value="movies">
            <input type="hidden" name="action" value="search_omdb">
            
            <div class="search-input-group">
                <input type="text" 
                       name="q" 
                       value="<?php echo htmlspecialchars($searchQuery); ?>" 
                       placeholder="Unesite naziv filma..."
                       required>
                <button type="submit" class="btn btn-primary">
                    Pretraži OMDB
                </button>
            </div>
        </form>
    </div>
    
    <?php if (!empty($searchResults)): ?>
        <div class="search-results">
            <h2>Rezultati pretrage za: "<?php echo htmlspecialchars($searchQuery); ?>"</h2>
            <p class="results-count">Pronađeno <?php echo count($searchResults); ?> filmova</p>
            
            <div class="movies-grid">
                <?php foreach ($searchResults as $movie): ?>
                    <div class="omdb-movie-card">
                        <div class="movie-poster">
                            <?php if ($movie['Poster'] !== 'N/A'): ?>
                                <img src="<?php echo htmlspecialchars($movie['Poster']); ?>" 
                                     alt="<?php echo htmlspecialchars($movie['Title']); ?>"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div class="poster-fallback" style="display: none;">🎬</div>
                            <?php else: ?>
                                <div class="poster-fallback">🎬</div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="movie-info">
                            <h3 class="movie-title"><?php echo htmlspecialchars($movie['Title']); ?></h3>
                            <p class="movie-year"><?php echo htmlspecialchars($movie['Year']); ?></p>
                            
                            <div class="movie-actions">
                                <form method="POST" action="?page=movies&action=add_from_omdb">
                                    <input type="hidden" name="imdb_id" value="<?php echo htmlspecialchars($movie['imdbID']); ?>">
                                    <button type="submit" 
                                            class="btn btn-primary"
                                            onclick="return confirm('Dodati ovaj film u videoteku?')">
                                        Dodaj film
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php elseif (!empty($searchQuery)): ?>
        <div class="no-results">
            <h3>Nema rezultata</h3>
            <p>Nema filmova koji odgovaraju vašoj pretrazi za "<?php echo htmlspecialchars($searchQuery); ?>".</p>
        </div>
    <?php else: ?>
        <div class="search-instructions">
            <h3>Kako dodati film:</h3>
            <ol>
                <li>Unesite naziv filma u polje za pretraživanje</li>
                <li>Pregledajte rezultate iz OMDB baze</li>
                <li>Kliknite "Dodaj film" za film koji želite</li>
                <li>Film će biti automatski dodan s podacima iz OMDB</li>
            </ol>
        </div>
    <?php endif; ?>
</div>