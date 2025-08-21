<!-- Simple Statistics -->
<div class="container">
    <h1>Statistike sustava</h1>
    
    <div class="admin-nav">
        <a href="?page=admin" class="btn btn-outline">Dashboard</a>
        <a href="?page=admin&section=users" class="btn btn-outline">Korisnici</a>
        <a href="?page=admin&section=logs" class="btn btn-outline">Dnevnik</a>
        <a href="?page=admin&section=stats" class="btn btn-primary">Statistike</a>
        <a href="?page=admin&section=config" class="btn btn-outline">Postavke</a>
    </div>
    
    <!-- Date filter -->
    <div class="filter-form">
        <form method="GET">
            <input type="hidden" name="page" value="admin">
            <input type="hidden" name="section" value="stats">
            
            <label for="date_from">Od:</label>
            <input type="date" name="date_from" value="<?php echo $dateFrom; ?>">
            
            <label for="date_to">Do:</label>
            <input type="date" name="date_to" value="<?php echo $dateTo; ?>">
            
            <button type="submit" class="btn btn-primary">Filtriraj</button>
        </form>
    </div>
    
    <!-- Login Statistics -->
    <div class="stats-section">
        <h2>Statistike prijava</h2>
        <?php if (empty($loginStats)): ?>
            <p>Nema podataka za odabrani period.</p>
        <?php else: ?>
            <table class="stats-table">
                <thead>
                    <tr>
                        <th>Datum</th>
                        <th>Broj prijava</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($loginStats as $stat): ?>
                        <tr>
                            <td><?php echo date('d.m.Y', strtotime($stat['date'])); ?></td>
                            <td><?php echo $stat['count']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
    
    <!-- Registration Statistics -->
    <div class="stats-section">
        <h2>Statistike registracija</h2>
        <?php if (empty($registrationStats)): ?>
            <p>Nema podataka za odabrani period.</p>
        <?php else: ?>
            <table class="stats-table">
                <thead>
                    <tr>
                        <th>Datum</th>
                        <th>Broj registracija</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($registrationStats as $stat): ?>
                        <tr>
                            <td><?php echo date('d.m.Y', strtotime($stat['date'])); ?></td>
                            <td><?php echo $stat['count']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<style>

</style>