<!-- Simple Admin Dashboard -->
<div class="container">
    <h1>Admin Dashboard</h1>
    
    <div class="admin-nav">
        <a href="?page=admin" class="btn btn-primary">Dashboard</a>
        <a href="?page=admin&section=users" class="btn btn-outline">Korisnici</a>
        <a href="?page=admin&section=logs" class="btn btn-outline">Dnevnik</a>
        <a href="?page=admin&section=stats" class="btn btn-outline">Statistike</a>
        <a href="?page=admin&section=config" class="btn btn-outline">Postavke</a>
    </div>
    
    <div class="stats-cards">
        <div class="stat-card">
            <h3><?php echo $stats['total_users']; ?></h3>
            <p>Ukupno korisnika</p>
        </div>
        <div class="stat-card">
            <h3><?php echo $stats['total_movies']; ?></h3>
            <p>Ukupno filmova</p>
        </div>
        <div class="stat-card">
            <h3><?php echo $stats['today_logins']; ?></h3>
            <p>Danas prijava</p>
        </div>
    </div>
</div>

<style>
.admin-nav {
    display: flex;
    gap: 10px;
    margin: 20px 0;
    flex-wrap: wrap;
}

.stats-cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin: 30px 0;
}

.stat-card {
    background-color: #1a1a1a;
    padding: 20px;
    border-radius: 10px;
    text-align: center;
    border: 1px solid #333;
}

.stat-card h3 {
    font-size: 36px;
    color: #00bcd4;
    margin: 0;
}

.stat-card p {
    color: #b0b0b0;
    margin: 10px 0 0 0;
}
</style>