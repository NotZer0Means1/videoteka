<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h1>Prijava</h1>
            <p>Prijavite se u svoj račun</p>
        </div>
        
        <?php if (isset($registered) && $registered): ?>
            <div class="alert alert-success">
                Registracija uspješna! Možete se prijaviti sa svojim podacima.
            </div>
        <?php endif; ?>
        
        <?php if ($failedAttempts > 0): ?>
            <div class="alert alert-warning">
                <strong>Upozorenje:</strong> <?php echo $failedAttempts; ?> neuspješnih pokušaja prijave.
                <?php if ($showCaptcha): ?>
                    Molimo potvrdite da niste robot.
                <?php endif; ?>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($errors)): ?>
            <div class="alert alert-error">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <form method="POST" class="auth-form" id="loginForm">
            <div class="form-group">
                <label for="username">Korisničko ime</label>
                <input type="text" 
                       id="username" 
                       name="username" 
                       required
                       autofocus>
            </div>
            
            <div class="form-group">
                <label for="password">Lozinka</label>
                <input type="password" 
                       id="password" 
                       name="password" 
                       required>
            </div>
            
            <?php if ($showCaptcha): ?>
                <div class="form-group recaptcha-group">
                    <label>Sigurnosna provjera *</label>
                    <?php echo $recaptcha_widget; ?>
                    <small class="form-help">Potrebno nakon neuspješnih pokušaja</small>
                </div>
            <?php endif; ?>
            
            <button type="submit" class="btn btn-primary btn-full">
                Prijavite se
            </button>
        </form>
        
        <div class="auth-footer">
            <p>Nemate račun? <a href="?page=register">Registrirajte se</a></p>
            <p><a href="?page=home">← Povratak na početnu</a></p>
        </div>
        
        <div class="demo-info">
            <h4>Demo računi za testiranje:</h4>
            <p><strong>Admin:</strong> admin / admin123</p>
            <p><strong>Korisnik:</strong> testuser / user123</p>
        </div>
    </div>
</div>

<?php if ($showCaptcha): ?>
    <?php echo $recaptcha_script; ?>
<?php endif; ?>

<script src="js/login.js"></script>