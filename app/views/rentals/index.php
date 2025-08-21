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
