document.addEventListener('DOMContentLoaded', function() {
    const searchForm = document.querySelector('.search-box');
    const searchInput = document.querySelector('.search-input');
    
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            const searchTerm = searchInput.value.trim();
            if (!searchTerm) {
                e.preventDefault();
                alert('Molimo unesite pojam za pretraživanje');
            }
        });
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const movieCards = document.querySelectorAll('.movie-card');
    
    movieCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const links = document.querySelectorAll('a[href^="#"]');
    
    links.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);
            
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });
});

function validateForm(form) {
    const inputs = form.querySelectorAll('input[required]');
    let isValid = true;
    
    inputs.forEach(input => {
        if (!input.value.trim()) {
            input.style.borderColor = '#ff4444';
            isValid = false;
        } else {
            input.style.borderColor = '#00bcd4';
        }
    });
    
    return isValid;
}

function showLoading(button, text = 'Učitavanje...') {
    button.disabled = true;
    button.innerHTML = text;
    button.style.opacity = '0.7';
}

function hideLoading(button, originalText) {
    button.disabled = false;
    button.innerHTML = originalText;
    button.style.opacity = '1';
}