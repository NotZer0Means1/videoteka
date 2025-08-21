
<div class="container">
    <div class="docs-header">
        <h1>Dokumentacija - Videoteka</h1>
        <p>Jednostavna uputa za korištenje sustava</p>
    </div>
    <br>
    <br>
    <section class="docs-section">
        <h2>Brzi početak</h2>
        <div class="docs-content">
            <p>Videoteka je sustav za iznajmljivanje filmova koji omogućuje korisnicima pregledavanje, pretraživanje i iznajmljivanje filmova.</p>
            
            <div class="steps">
                <div class="step">
                    <span class="step-number">1</span>
                    <div class="step-content">
                        <h4>Registracija</h4>
                        <p>Registrirajte se <a href="?page=register">ovdje</a> ili se prijavite ako već imate račun</p>
                    </div>
                </div>
                
                <div class="step">
                    <span class="step-number">2</span>
                    <div class="step-content">
                        <h4>Pregled filmova</h4>
                        <p>Idite na <a href="?page=movies">stranicu filmova</a> i pregledajte dostupne naslove</p>
                    </div>
                </div>
                
                <div class="step">
                    <span class="step-number">3</span>
                    <div class="step-content">
                        <h4>Iznajmljivanje</h4>
                        <p>Kliknite "Iznajmi" na željenom filmu i pratite upute</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <br>
    <br>
    <section class="docs-section">
        <h2>Vodič za korisnike</h2>
        <div class="docs-content">
            
            <div class="docs-card">
                <h3>Registracija i prijava</h3>
                <ul>
                    <li>Idite na <strong>Registracija</strong> i unesite svoje podatke</li>
                    <li>Popunite sva obavezna polja (*)</li>
                    <li>Potvrdite da niste robot (reCAPTCHA)</li>
                    <li>Nakon registracije možete se prijaviti</li>
                </ul>
            </div>

            <div class="docs-card">
                <h3>Pregled i pretraživanje filmova</h3>
                <ul>
                    <li>Na <strong>početnoj stranici</strong> vidite izdvojene filmove</li>
                    <li>Na stranici <strong>Filmovi</strong> možete:</li>
                    <li style="margin-left: 20px;">• Pretraživati po nazivu, redatelju ili glumcima</li>
                    <li style="margin-left: 20px;">• Filtrirati po žanru</li>
                    <li style="margin-left: 20px;">• Sortirati po različitim kriterijima</li>
                    <li>Kliknite na film za detaljne informacije</li>
                </ul>
            </div>

            <div class="docs-card">
                <h3>Iznajmljivanje filmova</h3>
                <ul>
                    <li>Morate biti prijavljeni da biste iznajmili film</li>
                    <li>Kliknite <strong>"Iznajmi"</strong> na dostupnom filmu</li>
                    <li>Film će biti dodan u vaša iznajmljivanja na 7 dana</li>
                    <li>Možete imati maksimalno 3 aktivna iznajmljivanja</li>
                    <li>Pratite svoja iznajmljivanja na stranici <strong>"Moja iznajmljivanja"</strong></li>
                </ul>
            </div>

            <div class="docs-card">
                <h3>Vraćanje filmova</h3>
                <ul>
                    <li>Idite na <strong>"Moja iznajmljivanja"</strong></li>
                    <li>Kliknite <strong>"Vrati film"</strong> pokraj aktivnog iznajmljivanja</li>
                    <li>Film će biti označen kao vraćen i ponovno dostupan</li>
                    <li>Pazite na datum vraćanja - filmovi mogu postati zakašnjeli</li>
                </ul>
            </div>
        </div>
    </section>
    <br>
    <br>
    <section class="docs-section">
        <h2>Vodič za administratore</h2>
        <div class="docs-content">
            <div class="admin-note">
                <strong>Napomena:</strong> Ove funkcije dostupne su samo korisnicima s admin ulogom.
            </div>

            <div class="docs-card">
                <h3>Dodavanje filmova</h3>
                <ul>
                    <li>Idite na <strong>"Dodaj film"</strong> u navigaciji</li>
                    <li>Unesite naziv filma za pretraživanje OMDB baze</li>
                    <li>Odaberite željeni film iz rezultata</li>
                    <li>Kliknite <strong>"Dodaj film"</strong> - podaci će se automatski spremiti</li>
                </ul>
            </div>

            <div class="docs-card">
                <h3>Upravljanje korisnicima</h3>
                <ul>
                    <li>Idite na <strong>"Admin"</strong> → <strong>"Korisnici"</strong></li>
                    <li>Možete dodavati, uređivati i brisati korisnike</li>
                    <li>Mijenjanje statusa korisnika (aktivan/neaktivan)</li>
                    <li>Dodjeljivanje admin uloge</li>
                </ul>
            </div>

            <div class="docs-card">
                <h3>Dnevnik aktivnosti</h3>
                <ul>
                    <li>Pregled svih aktivnosti u sustavu</li>
                    <li>Filtriranje po opisu aktivnosti</li>
                    <li>Praćenje prijava, registracija i drugih akcija</li>
                </ul>
            </div>

            <div class="docs-card">
                <h3>Statistike</h3>
                <ul>
                    <li>Pregled statistika prijava i registracija</li>
                    <li>Filtriranje po datumskom rasponu</li>
                    <li>Osnovne informacije o sustavu</li>
                </ul>
            </div>

            <div class="docs-card">
                <h3>Sistemske postavke</h3>
                <ul>
                    <li>Konfiguracija broja filmova po stranici</li>
                    <li>Postavka maksimalnog broja neuspješnih prijava</li>
                    <li>Ostale sistemske konfiguracije</li>
                </ul>
            </div>
        </div>
    </section>
    <br>
    <br>
    <section class="docs-section">
        <h2>Tehnički podaci</h2>
        <div class="docs-content">
            
            <div class="docs-card">
                <h3>Značajke sustava</h3>
                <ul>
                    <li><strong>Sigurnost:</strong> reCAPTCHA zaštita, hash lozinki, prepared statements</li>
                    <li><strong>Pretraživanje:</strong> Full-text pretraga preko naziva, redatelja i glumaca</li>
                    <li><strong>OMDB integracija:</strong> Automatsko dohvaćanje podataka o filmovima</li>
                    <li><strong>Responsive dizajn:</strong> Prilagođava se svim uređajima</li>
                    <li><strong>AJAX:</strong> Provjera korisničkog imena u stvarnom vremenu</li>
                    <li><strong>RSS kanal:</strong> <a href="?page=rss">Najnoviji filmovi</a></li>
                </ul>
            </div>

            <div class="docs-card">
                <h3>Demo računi</h3>
                <div class="demo-accounts">
                    <div class="demo-account">
                        <strong>Administrator:</strong><br>
                        Korisničko ime: <code>admin</code><br>
                        Lozinka: <code>admin123</code>
                    </div>
                    <div class="demo-account">
                        <strong>Korisnik:</strong><br>
                        Korisničko ime: <code>user</code><br>
                        Lozinka: <code>user123</code>
                    </div>
                </div>
            </div>

            <div class="docs-card">
                <h3>Struktura baze podataka</h3>
                <ul>
                    <li><strong>users</strong> - korisnici sustava</li>
                    <li><strong>movies</strong> - filmovi u videoteci</li>
                    <li><strong>genres</strong> - žanrovi filmova</li>
                    <li><strong>rentals</strong> - iznajmljivanja filmova</li>
                    <li><strong>activity_logs</strong> - dnevnik aktivnosti</li>
                    <li><strong>contact_messages</strong> - poruke s kontakt obrasca</li>
                </ul>
            </div>
        </div>
    </section>
</div>