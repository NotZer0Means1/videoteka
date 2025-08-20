<!-- Simple Activity Logs -->
<div class="container">
    <h1>Dnevnik aktivnosti</h1>
    
    <div class="admin-nav">
        <a href="?page=admin" class="btn btn-outline">Dashboard</a>
        <a href="?page=admin&section=users" class="btn btn-outline">Korisnici</a>
        <a href="?page=admin&section=logs" class="btn btn-primary">Dnevnik</a>
        <a href="?page=admin&section=stats" class="btn btn-outline">Statistike</a>
        <a href="?page=admin&section=config" class="btn btn-outline">Postavke</a>
    </div>
    
    <!-- Simple search -->
    <div class="search-form">
        <form method="GET">
            <input type="hidden" name="page" value="admin">
            <input type="hidden" name="section" value="logs">
            <input type="text" 
                   name="search" 
                   value="<?php echo htmlspecialchars($search); ?>" 
                   placeholder="Pretraži opis aktivnosti...">
            <button type="submit" class="btn btn-primary">Pretraži</button>
            <?php if ($search): ?>
                <a href="?page=admin&section=logs" class="btn btn-outline">Poništi</a>
            <?php endif; ?>
        </form>
    </div>
    
    <div class="logs-table">
        <table>
            <thead>
                <tr>
                    <th>Datum</th>
                    <th>Korisnik</th>
                    <th>Akcija</th>
                    <th>Opis</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($logs as $log): ?>
                    <tr>
                        <td><?php echo date('d.m.Y H:i', strtotime($log['created_at'])); ?></td>
                        <td>
                            <?php if ($log['username']): ?>
                                <?php echo htmlspecialchars($log['username']); ?>
                            <?php else: ?>
                                <em>Sistem</em>
                            <?php endif; ?>
                        </td>
                        <td><?php echo htmlspecialchars($log['action']); ?></td>
                        <td><?php echo htmlspecialchars($log['description']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<style>
.search-form {
    margin: 20px 0;
}

.search-form form {
    display: flex;
    gap: 10px;
    align-items: center;
}

.search-form input[type="text"] {
    flex: 1;
    max-width: 400px;
}

.logs-table {
    background-color: #1a1a1a;
    border-radius: 10px;
    overflow: hidden;
    margin: 20px 0;
}

.logs-table table {
    width: 100%;
    border-collapse: collapse;
}

.logs-table th,
.logs-table td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #333;
}

.logs-table th {
    background-color: #2a2a2a;
    color: #00bcd4;
    font-weight: bold;
}

.logs-table td {
    color: #e0e0e0;
}
</style>