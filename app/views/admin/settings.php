<!-- Simple Settings -->
<div class="container">
    <h1>Sistemske postavke</h1>
    
    <div class="admin-nav">
        <a href="?page=admin" class="btn btn-outline">Dashboard</a>
        <a href="?page=admin&section=users" class="btn btn-outline">Korisnici</a>
        <a href="?page=admin&section=logs" class="btn btn-outline">Dnevnik</a>
        <a href="?page=admin&section=stats" class="btn btn-outline">Statistike</a>
        <a href="?page=admin&section=config" class="btn btn-primary">Postavke</a>
    </div>
    
    <?php if (isset($_SESSION['flash_message'])): ?>
        <div class="alert alert-success">
            <?php echo $_SESSION['flash_message']; unset($_SESSION['flash_message']); ?>
        </div>
    <?php endif; ?>
    
    <div class="settings-form">
        <form method="POST">
            <div class="form-group">
                <label for="movies_per_page">Filmova po stranici</label>
                <input type="number" 
                       id="movies_per_page" 
                       name="movies_per_page" 
                       value="<?php echo $settings['movies_per_page']; ?>" 
                       min="1" max="50">
            </div>
            
            <div class="form-group">
                <label for="max_failed_attempts">Maksimalno neuspješnih prijava</label>
                <input type="number" 
                       id="max_failed_attempts" 
                       name="max_failed_attempts" 
                       value="<?php echo $settings['max_failed_attempts']; ?>" 
                       min="1" max="10">
            </div>
            
            <button type="submit" class="btn btn-primary">Spremi postavke</button>
        </form>
    </div>
</div>

<style>
.settings-form {
    background-color: #1a1a1a;
    padding: 30px;
    border-radius: 10px;
    max-width: 500px;
    margin: 20px 0;
}
</style>