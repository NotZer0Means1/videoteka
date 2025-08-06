<!-- Register Page -->
<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h1>Registracija</h1>
            <p>Stvorite svoj račun za pristup videoteci</p>
        </div>
        
        <!-- Show errors if any -->
        <?php if (!empty($errors)): ?>
            <div class="alert alert-error">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <form method="POST" class="auth-form" id="registerForm">
            <div class="form-row">
                <div class="form-group">
                    <label for="first_name">Ime *</label>
                    <input type="text" 
                           id="first_name" 
                           name="first_name" 
                           value="<?php echo htmlspecialchars($data['first_name'] ?? ''); ?>"
                           required>
                </div>
                
                <div class="form-group">
                    <label for="last_name">Prezime *</label>
                    <input type="text" 
                           id="last_name" 
                           name="last_name" 
                           value="<?php echo htmlspecialchars($data['last_name'] ?? ''); ?>"
                           required>
                </div>
            </div>
            
            <div class="form-group">
                <label for="username">Korisničko ime *</label>
                <input type="text" 
                       id="username" 
                       name="username" 
                       value="<?php echo htmlspecialchars($data['username'] ?? ''); ?>"
                       required
                       minlength="3">
                <small class="form-help">Najmanje 3 znaka</small>
            </div>
            
            <div class="form-group">
                <label for="email">Email adresa *</label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       value="<?php echo htmlspecialchars($data['email'] ?? ''); ?>"
                       required>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="password">Lozinka *</label>
                    <input type="password" 
                           id="password" 
                           name="password" 
                           required
                           minlength="6">
                    <small class="form-help">Najmanje 6 znakova</small>
                </div>
                
                <div class="form-group">
                    <label for="confirm_password">Potvrdi lozinku *</label>
                    <input type="password" 
                           id="confirm_password" 
                           name="confirm_password" 
                           required>
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary btn-full">
                Registriraj se
            </button>
        </form>
        
        <div class="auth-footer">
            <p>Već imate račun? <a href="?page=login">Prijavite se</a></p>
        </div>
    </div>
</div>

<script src="js/register.js"></script>