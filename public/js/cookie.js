document.addEventListener('DOMContentLoaded', function() {
    if (!localStorage.getItem('cookiesAccepted')) {
        document.getElementById('cookieModal').style.display = 'block';
    }
});

function acceptCookies() {
    localStorage.setItem('cookiesAccepted', 'true');
    document.getElementById('cookieModal').style.display = 'none';
}

function declineCookies() {
    document.getElementById('cookieModal').style.display = 'none';
    localStorage.setItem('cookiesDeclined', 'true');
}