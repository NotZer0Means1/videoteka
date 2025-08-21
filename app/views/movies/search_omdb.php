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

<style>
.page-header {
    text-align: center;
    margin-bottom: 40px;
}

.page-header h1 {
    color: #00bcd4;
    margin-bottom: 10px;
}

.search-section {
    background-color: #1a1a1a;
    padding: 30px;
    border-radius: 10px;
    margin-bottom: 30px;
    border: 1px solid #333;
}

.search-input-group {
    display: flex;
    gap: 10px;
    margin-bottom: 15px;
}

.search-input-group input {
    flex: 1;
    padding: 12px 20px;
    background-color: #2a2a2a;
    border: 2px solid #444;
    border-radius: 5px;
    color: #e0e0e0;
    font-size: 16px;


.poster-fallback {
    font-size: 48px;
    color: #00bcd4;
}

.movie-info {
    padding: 20px;
}

.movie-title {
    color: #fff;
    font-size: 16px;
    margin-bottom: 8px;
}

.movie-year {
    color: #b0b0b0;
    margin-bottom: 15px;
}

.movie-actions {
    text-align: center;
}

.search-instructions {
    background-color: #1a1a1a;
    padding: 30px;
    border-radius: 10px;
    border: 1px solid #333;
}

.search-instructions h3 {
    color: #00bcd4;
    margin-bottom: 20px;
}

.search-instructions ol {
    color: #e0e0e0;
    line-height: 1.6;
}

.no-results {
    text-align: center;
    padding: 40px;
    background-color: #1a1a1a;
    border-radius: 10px;
    border: 1px solid #333;
}

.no-results h3 {
    color: #00bcd4;
    margin-bottom: 15px;
}
</style>