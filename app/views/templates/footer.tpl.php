<footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>Videoteka</h3>
                    <p>Vas pouzdani partner za iznajmljivanje filmova. Uzivajte u sirokoj kolekciji najnovijih i najomiljenijih filmova.</p>
                </div>
                
                <div class="footer-section">
                    <h3>Brze veze</h3>
                    <ul class="footer-links">
                        <li><a href="?page=home">Pocetna</a></li>
                        <li><a href="?page=movies">Filmovi</a></li>
                        <li><a href="?page=contact">Kontakt</a></li>
                        <li><a href="about.php">O nama</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h3>Kontakt</h3>
                    <p>📍 Split, Hrvatska</p>
                    <p>📞 +385 1 234 5678</p>
                    <p>✉️ info@videoteka.hr</p>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> Vladimir Shevalev.</p>
            </div>
        </div>
    </footer>

    <!-- Cookie Banner Modal -->
    <div class="cookie-modal" id="cookieModal">
        <div class="cookie-modal-content">
            <div class="cookie-form">
                <h3>🍪 Kolačići (Cookies)</h3>
                <p>Ova stranica koristi kolačiće za poboljšanje korisničkog iskustva i funkcionalnosti.</p>
                
                <div class="cookie-buttons">
                    <button class="btn btn-primary" onclick="acceptCookies()">
                        Prihvaćam sve kolačiće
                    </button>
                    <button class="btn btn-outline" onclick="declineCookies()">
                        Odbacujem
                    </button>
                </div>
                
                <div class="cookie-footer">
                    <small>Možete promijeniti postavke kolačića u bilo koje vrijeme u vašem pregledniku.</small>
                </div>
            </div>
        </div>
    </div>

    <script src="js/main.js"></script>
    <script src="js/cookie.js"></script>
</body>
</html>