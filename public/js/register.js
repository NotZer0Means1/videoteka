document.addEventListener('DOMContentLoaded', function() {
    const registerForm = document.getElementById('registerForm');
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('confirm_password');
    const usernameInput = document.getElementById('username');

    registerForm.addEventListener('submit', function(e) {
        const password = passwordInput.value;
        const confirmPassword = confirmPasswordInput.value;
        const username = usernameInput.value;

        if (password !== confirmPassword) {
            e.preventDefault();
            alert('Lozinke se ne podudaraju!');
            return false;
        }

        if (password.length < 6) {
            e.preventDefault();
            alert('Lozinka mora imati najmanje 6 znakova!');
            return false;
        }

        if (username.length < 3) {
            e.preventDefault();
            alert('Korisnicko ime mora imati najmanje 3 znaka!');
            return false;
        }

        const submitBtn = this.querySelector('button[type="submit"]');
        submitBtn.innerHTML = 'Registriranje...';
        submitBtn.disabled = true;
    });

    confirmPasswordInput.addEventListener('input', function() {
        const password = passwordInput.value;
        const confirmPassword = this.value;
        
        if (confirmPassword && password !== confirmPassword) {
            this.style.borderColor = '#ff4444';
        } else {
            this.style.borderColor = '#00bcd4';
        }
    });

    usernameInput.addEventListener('blur', function() {
        const username = this.value.trim();
        
        if (username.length > 0 && username.length < 3) {
            this.style.borderColor = '#ff4444';
        } else if (username.length >= 3) {
            this.style.borderColor = '#00bcd4';
        }
    });

    passwordInput.addEventListener('input', function() {
        const password = this.value;
        
        if (password.length < 6 && password.length > 0) {
            this.style.borderColor = '#ff4444';
        } else if (password.length >= 6) {
            this.style.borderColor = '#00bcd4';
        }
    });
});