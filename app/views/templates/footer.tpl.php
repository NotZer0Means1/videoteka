<!-- Footer -->
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
                        <li><a href="index.php">Početna</a></li>
                        <li><a href="movies.php">Filmovi</a></li>
                        <li><a href="contact.php">Kontakt</a></li>
                        <li><a href="about.php">O nama</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h3>Kontakt</h3>
                    <p>📍 Zagreb, Hrvatska</p>
                    <p>📞 +385 1 234 5678</p>
                    <p>✉️ info@videoteka.hr</p>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> Videoteka. Sva prava pridržana.</p>
            </div>
        </div>
    </footer>

    <!-- Cookie Banner -->
    <div class="cookie-banner" id="cookieBanner">
        <div class="cookie-content">
            <p>🍪 Ova stranica koristi kolačiće za poboljšanje korisničkog iskustva.</p>
            <div class="cookie-buttons">
                <button class="btn btn-outline" onclick="declineCookies()">Odbaci</button>
                <button class="btn btn-primary" onclick="acceptCookies()">Prihvati</button>
            </div>
        </div>
    </div>

    <script src="public/js/main.js"></script>
</body>
</html>