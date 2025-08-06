// Login Page JavaScript

document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('loginForm');
    const usernameInput = document.getElementById('username');
    const passwordInput = document.getElementById('password');
    
    // Form submission validation
    loginForm.addEventListener('submit', function(e) {
        const username = usernameInput.value.trim();
        const password = passwordInput.value;
        
        if (!username) {
            e.preventDefault();
            alert('Molimo unesite korisničko ime!');
            usernameInput.focus();
            return false;
        }
        
        if (!password) {
            e.preventDefault();
            alert('Molimo unesite lozinku!');
            passwordInput.focus();
            return false;
        }
        
        // Show loading state
        const submitBtn = this.querySelector('button[type="submit"]');
        submitBtn.innerHTML = 'Prijavljivanje...';
        submitBtn.disabled = true;
    });
    
    // Remove validation styling on input
    usernameInput.addEventListener('input', function() {
        this.style.borderColor = '#444';
    });
    
    passwordInput.addEventListener('input', function() {
        this.style.borderColor = '#444';
    });
    
    // Focus on username field when page loads
    usernameInput.focus();
});