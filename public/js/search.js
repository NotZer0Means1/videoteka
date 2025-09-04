document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const genreSelect = document.getElementById('genreSelect');
    const sortSelect = document.getElementById('sortSelect');
    const moviesContainer = document.getElementById('moviesContainer');
    const movieCount = document.getElementById('movieCount');
    
    let searchTimeout;
    
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(performSearch, 200);
        });
    }

    if (genreSelect) {
        genreSelect.addEventListener('change', performSearch);
    }
    
    if (sortSelect) {
        sortSelect.addEventListener('change', performSearch);
    }
    
    function performSearch() {
        const search = searchInput ? searchInput.value : '';
        const genre = genreSelect ? genreSelect.value : '';
        const sort = sortSelect ? sortSelect.value : 'title';
        
        const params = new URLSearchParams();
        if (search) params.append('search', search);
        if (genre && genre !== 'all') params.append('genre', genre);
        params.append('sort', sort);      

        fetch('?page=movies&action=ajax_search&' + params.toString(), {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                displayMovies(data.movies);
                updateMovieCount(data.count);
            } else {
                console.error('Search error:', data.error);
            }
        })
        .catch(error => {
            console.error('AJAX error:', error);
        })
        .finally(() => {
        });
    }
    function displayMovies(movies) {
        if (!moviesContainer) return;
        
        if (movies.length === 0) {
            moviesContainer.innerHTML = '<div class="no-movies"><p>Nema filmova koji odgovaraju kriterijima pretrage.</p></div>';
            return;
        }
        
        let html = '';
        movies.forEach(movie => {
            html += `
                <div class="movie-card">
                    <div class="movie-poster">
                        ${movie.poster_url ? 
                            `<img src="${movie.poster_url}" alt="${movie.title}">` : 
                            '<div class="no-poster">🎬</div>'
                        }
                        <div class="movie-overlay">
                            <a href="?page=movies&action=show&id=${movie.id}" class="btn btn-primary">Detalji</a>
                        </div>
                    </div>
                    <div class="movie-info">
                        <h3 class="movie-title">${movie.title}</h3>
                        <div class="movie-meta">
                            <span class="movie-year">${movie.year}</span>
                            ${movie.genre_name ? `<span class="movie-genre">${movie.genre_name}</span>` : ''}
                            ${movie.rating ? `<span class="movie-rating">⭐ ${movie.rating}</span>` : ''}
                        </div>
                        ${movie.director ? `<p class="movie-director">Redatelj: ${movie.director}</p>` : ''}
                    </div>
                </div>
            `;
        });

        moviesContainer.innerHTML = html;
    }

    function updateMovieCount(count) {
        if (movieCount) {
            movieCount.textContent = count;
        }
    }
});