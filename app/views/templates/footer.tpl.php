</main>

<footer class="footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-section">
                <h3>Videoteka</h3>
                <p>Vaš pouzdani partner za iznajmljivanje filmova. Uživajte u širokoj kolekciji najnovijih i najomiljenijih filmova.</p>
            </div>
            
            <div class="footer-section">
                <h3>Brze veze</h3>
                <ul class="footer-links">
                    <li><a href="?page=home">Početna</a></li>
                    <li><a href="?page=movies">Filmovi</a></li>
                    <li><a href="?page=contact">Kontakt</a></li>
                    <li><a href="?page=rss">RSS kanal</a></li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h3>Kontakt</h3>
                <p>Split, Hrvatska</p>
                <p>+385 1 234 5678</p>
                <p>info@videoteka.hr</p>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> Vladimir Shevalev. Sva prava pridržana.</p>
        </div>
    </div>
</footer>

<div class="cookie-modal" id="cookieModal">
    <div class="cookie-modal-content">
        <div class="cookie-form">
            <h3>Kolačići</h3>
            <p>Ova stranica koristi kolačiće za poboljšanje korisničkog iskustva.</p>
            
            <div class="cookie-buttons">
                <button class="btn btn-primary" onclick="acceptCookies()">Prihvaćam</button>
                <button class="btn btn-outline" onclick="declineCookies()">Odbacujem</button>
            </div>
            
            <div class="cookie-footer">
                <small>Možete promijeniti postavke u pregledniku.</small>
            </div>
        </div>
    </div>
</div>

<script src="js/main.js"></script>
<script src="js/cookie.js"></script>
</body>
</html>