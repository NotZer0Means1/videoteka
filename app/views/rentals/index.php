<!-- User Rentals Page -->
<div class="container">
    <h1>Moji iznajmljivanja</h1>
    
    <div class="rentals-nav">
        <a href="?page=movies" class="btn btn-outline">← Pregledaj filmove</a>
        <a href="?page=rentals" class="btn btn-primary">Moja iznajmljivanja</a>
    </div>
    
    <!-- Flash Messages -->
    <?php if (isset($_SESSION['flash_message'])): ?>
        <div class="alert alert-<?php echo $_SESSION['flash_type']; ?>">
            <?php echo htmlspecialchars($_SESSION['flash_message']); ?>
        </div>
        <?php 
        unset($_SESSION['flash_message']);
        unset($_SESSION['flash_type']);
        ?>
    <?php endif; ?>
    
    <?php if (empty($rentals)): ?>
        <div class="no-rentals">
            <h3>Nemate iznajmljene filmove</h3>
            <p>Idite na stranicu filmova i iznajmite svoj prvi film!</p>
            <a href="?page=movies" class="btn btn-primary btn-large">Pregledaj filmove</a>
        </div>
    <?php else: ?>
        <!-- Rentals Grid -->
        <div class="rentals-grid">
            <?php foreach ($rentals as $rental): ?>
                <div class="rental-card">
                    <div class="rental-poster">
                        <?php if ($rental['poster_url']): ?>
                            <img src="<?php echo htmlspecialchars($rental['poster_url']); ?>" 
                                 alt="<?php echo htmlspecialchars($rental['title']); ?>"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="poster-fallback" style="display: none;">🎬</div>
                        <?php else: ?>
                            <div class="poster-fallback">🎬</div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="rental-info">
                        <h3 class="rental-title">
                            <a href="?page=movies&action=show&id=<?php echo $rental['movie_id']; ?>">
                                <?php echo htmlspecialchars($rental['title']); ?>
                            </a>
                        </h3>
                        
                        <div class="rental-meta">
                            <p><strong>Godina:</strong> <?php echo $rental['year']; ?></p>
                            <p><strong>Iznajmljeno:</strong> <?php echo date('d.m.Y H:i', strtotime($rental['rental_date'])); ?></p>
                            
                            <?php if ($rental['due_date']): ?>
                                <p><strong>Vrati do:</strong> 
                                    <span class="due-date <?php echo strtotime($rental['due_date']) < time() ? 'overdue' : ''; ?>">
                                        <?php echo date('d.m.Y H:i', strtotime($rental['due_date'])); ?>
                                    </span>
                                </p>
                            <?php endif; ?>
                            
                            <?php if ($rental['return_date']): ?>
                                <p><strong>Vraćeno:</strong> <?php echo date('d.m.Y H:i', strtotime($rental['return_date'])); ?></p>
                            <?php endif; ?>
                        </div>
                        
                        <div class="rental-status">
                            <span class="status-badge status-<?php echo $rental['status']; ?>">
                                <?php 
                                $statusLabels = [
                                    'active' => 'Aktivno',
                                    'returned' => 'Vraćeno',
                                    'overdue' => 'Zakašnjelo'
                                ];
                                echo $statusLabels[$rental['status']] ?? $rental['status'];
                                ?>
                            </span>
                        </div>
                        
                        <?php if ($rental['status'] === 'active'): ?>
                            <div class="rental-actions">
                                <form method="POST" action="?page=rentals&action=return">
                                    <input type="hidden" name="rental_id" value="<?php echo $rental['id']; ?>">
                                    <button type="submit" 
                                            class="btn btn-primary btn-small"
                                            onclick="return confirm('Sigurno želite vratiti film?')">
                                        Vrati film
                                    </button>
                                </form>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Rental Stats -->
        <div class="rental-stats">
            <?php
            $activeCount = count(array_filter($rentals, function($r) { return $r['status'] === 'active'; }));
            $returnedCount = count(array_filter($rentals, function($r) { return $r['status'] === 'returned'; }));
            $overdueCount = count(array_filter($rentals, function($r) { return $r['status'] === 'overdue'; }));
            ?>
            <div class="stat-item">
                <span class="stat-number"><?php echo $activeCount; ?></span>
                <span class="stat-label">Aktivno</span>
            </div>
            <div class="stat-item">
                <span class="stat-number"><?php echo $returnedCount; ?></span>
                <span class="stat-label">Vraćeno</span>
            </div>
            <?php if ($overdueCount > 0): ?>
                <div class="stat-item">
                    <span class="stat-number overdue"><?php echo $overdueCount; ?></span>
                    <span class="stat-label">Zakašnjelo</span>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>

<style>
.rentals-nav {
    display: flex;
    gap: 10px;
    margin: 20px 0;
}

.no-rentals {
    text-align: center;
    background-color: #1a1a1a;
    padding: 60px 20px;
    border-radius: 10px;
    border: 1px solid #333;
    margin: 40px 0;
}

.no-rentals h3 {
    color: #00bcd4;
    margin-bottom: 15px;
}

.rentals-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 25px;
    margin: 30px 0;
}

.rental-card {
    background-color: #1a1a1a;
    border: 1px solid #333;
    border-radius: 10px;
    overflow: hidden;
    transition: all 0.3s;
}

.rental-card:hover {
    transform: translateY(-2px);
    border-color: #00bcd4;
}

.rental-poster {
    height: 200px;
    background-color: #333;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.rental-poster img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.poster-fallback {
    font-size: 48px;
    color: #00bcd4;
}

.rental-info {
    padding: 20px;
}

.rental-title {
    margin-bottom: 15px;
    font-size: 18px;
}

.rental-title a {
    color: #fff;
    text-decoration: none;
}

.rental-title a:hover {
    color: #00bcd4;
}

.rental-meta {
    margin-bottom: 15px;
    font-size: 14px;
    line-height: 1.6;
}

.rental-meta p {
    margin: 5px 0;
    color: #b0b0b0;
}

.due-date {
    color: #00bcd4;
    font-weight: bold;
}

.due-date.overdue {
    color: #ff4444;
}

.rental-status {
    margin-bottom: 15px;
}

.status-badge {
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: bold;
}

.status-active {
    background-color: #00bcd4;
    color: #000;
}

.status-returned {
    background-color: #00ff88;
    color: #000;
}

.status-overdue {
    background-color: #ff4444;
    color: #fff;
}

.rental-actions {
    text-align: center;
}

.btn-small {
    padding: 6px 12px;
    font-size: 12px;
}

.rental-stats {
    display: flex;
    justify-content: center;
    gap: 40px;
    margin: 40px 0;
    padding: 20px;
    background-color: #1a1a1a;
    border-radius: 10px;
    border: 1px solid #333;
}

.stat-item {
    text-align: center;
}

.stat-number {
    display: block;
    font-size: 24px;
    font-weight: bold;
    color: #00bcd4;
}

.stat-number.overdue {
    color: #ff4444;
}

.stat-label {
    color: #b0b0b0;
    font-size: 14px;
}

@media (max-width: 768px) {
    .rentals-grid {
        grid-template-columns: 1fr;
    }
    
    .rental-stats {
        flex-direction: column;
        gap: 20px;
    }
}
</style>