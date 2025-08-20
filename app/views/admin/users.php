<!-- Simple Users Management with Inline CRUD -->
<div class="container">
    <div class="admin-header">
        <h1>Upravljanje korisnicima</h1>
        <button onclick="showAddUserRow()" class="btn btn-primary">+ Dodaj novog korisnika</button>
    </div>
    
    <div class="admin-nav">
        <a href="?page=admin" class="btn btn-outline">Dashboard</a>
        <a href="?page=admin&section=users" class="btn btn-primary">Korisnici</a>
        <a href="?page=admin&section=logs" class="btn btn-outline">Dnevnik</a>
        <a href="?page=admin&section=stats" class="btn btn-outline">Statistike</a>
        <a href="?page=admin&section=config" class="btn btn-outline">Postavke</a>
    </div>
    
    <?php if (isset($_SESSION['flash_message'])): ?>
        <div class="alert alert-<?php echo $_SESSION['flash_type'] ?? 'success'; ?>">
            <?php echo $_SESSION['flash_message']; unset($_SESSION['flash_message'], $_SESSION['flash_type']); ?>
        </div>
    <?php endif; ?>
    
    <div class="users-table">
        <table id="usersTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Korisničko ime</th>
                    <th>Ime</th>
                    <th>Prezime</th>
                    <th>Email</th>
                    <th>Uloga</th>
                    <th>Status</th>
                    <th>Akcije</th>
                </tr>
            </thead>
            <tbody>
                <!-- Add new user row (hidden by default) -->
                <tr id="addUserRow" style="display: none;" class="edit-row">
                    <td>-</td>
                    <td><input type="text" id="new_username" placeholder="Korisničko ime" required></td>
                    <td><input type="text" id="new_first_name" placeholder="Ime" required></td>
                    <td><input type="text" id="new_last_name" placeholder="Prezime" required></td>
                    <td><input type="email" id="new_email" placeholder="Email" required></td>
                    <td>
                        <select id="new_role">
                            <option value="user">Korisnik</option>
                            <option value="admin">Admin</option>
                        </select>
                    </td>
                    <td>
                        <select id="new_status">
                            <option value="active">Aktivan</option>
                            <option value="inactive">Neaktivan</option>
                        </select>
                    </td>
                    <td>
                        <button onclick="saveNewUser()" class="btn btn-primary btn-small">💾 Spremi</button>
                        <button onclick="cancelAdd()" class="btn btn-outline btn-small">❌ Odustani</button>
                        <div style="margin-top: 5px;">
                            <input type="password" id="new_password" placeholder="Lozinka (min 6)" style="width: 100px; font-size: 11px;" required>
                        </div>
                    </td>
                </tr>
                
                <?php foreach ($users as $user): ?>
                    <!-- Normal view row -->
                    <tr id="row_<?php echo $user['id']; ?>" class="user-row">
                        <td><?php echo $user['id']; ?></td>
                        <td><?php echo htmlspecialchars($user['username']); ?></td>
                        <td><?php echo htmlspecialchars($user['first_name']); ?></td>
                        <td><?php echo htmlspecialchars($user['last_name']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td>
                            <span class="role-badge role-<?php echo $user['role']; ?>">
                                <?php echo $user['role'] === 'admin' ? 'Admin' : 'Korisnik'; ?>
                            </span>
                        </td>
                        <td>
                            <span class="status-<?php echo $user['status']; ?>">
                                <?php echo $user['status']; ?>
                            </span>
                        </td>
                        <td class="actions-cell">
                            <?php if ($user['id'] != $_SESSION['user_id']): ?>
                                <button onclick="editUser(<?php echo $user['id']; ?>)" class="btn btn-outline btn-small">
                                    ✏️ Uredi
                                </button>
                                <button onclick="deleteUser(<?php echo $user['id']; ?>, '<?php echo htmlspecialchars($user['username']); ?>')" 
                                        class="btn btn-danger btn-small">
                                    🗑️ Obriši
                                </button>
                            <?php else: ?>
                                <em class="current-user">Vaš račun</em>
                            <?php endif; ?>
                        </td>
                    </tr>
                    
                    <!-- Edit row (hidden by default) -->
                    <tr id="edit_<?php echo $user['id']; ?>" style="display: none;" class="edit-row">
                        <td><?php echo $user['id']; ?></td>
                        <td><input type="text" id="edit_username_<?php echo $user['id']; ?>" value="<?php echo htmlspecialchars($user['username']); ?>"></td>
                        <td><input type="text" id="edit_first_name_<?php echo $user['id']; ?>" value="<?php echo htmlspecialchars($user['first_name']); ?>"></td>
                        <td><input type="text" id="edit_last_name_<?php echo $user['id']; ?>" value="<?php echo htmlspecialchars($user['last_name']); ?>"></td>
                        <td><input type="email" id="edit_email_<?php echo $user['id']; ?>" value="<?php echo htmlspecialchars($user['email']); ?>"></td>
                        <td>
                            <select id="edit_role_<?php echo $user['id']; ?>">
                                <option value="user" <?php echo $user['role'] === 'user' ? 'selected' : ''; ?>>Korisnik</option>
                                <option value="admin" <?php echo $user['role'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
                            </select>
                        </td>
                        <td>
                            <select id="edit_status_<?php echo $user['id']; ?>">
                                <option value="active" <?php echo $user['status'] === 'active' ? 'selected' : ''; ?>>Aktivan</option>
                                <option value="inactive" <?php echo $user['status'] === 'inactive' ? 'selected' : ''; ?>>Neaktivan</option>
                                <option value="pending" <?php echo $user['status'] === 'pending' ? 'selected' : ''; ?>>Na čekanju</option>
                            </select>
                        </td>
                        <td>
                            <button onclick="saveUser(<?php echo $user['id']; ?>)" class="btn btn-primary btn-small">💾 Spremi</button>
                            <button onclick="cancelEdit(<?php echo $user['id']; ?>)" class="btn btn-outline btn-small">❌ Odustani</button>
                            <div style="margin-top: 5px;">
                                <input type="password" id="edit_password_<?php echo $user['id']; ?>" placeholder="Nova lozinka" style="width: 100px; font-size: 11px;">
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<style>
.admin-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.users-table {
    background-color: #1a1a1a;
    border-radius: 10px;
    overflow: hidden;
    margin: 20px 0;
}

.users-table table {
    width: 100%;
    border-collapse: collapse;
}

.users-table th,
.users-table td {
    padding: 8px;
    text-align: left;
    border-bottom: 1px solid #333;
}

.users-table th {
    background-color: #2a2a2a;
    color: #00bcd4;
    font-weight: bold;
}

.users-table td {
    color: #e0e0e0;
}

.edit-row {
    background-color: #2a2a2a !important;
}

.edit-row input,
.edit-row select {
    width: 100%;
    padding: 4px;
    background-color: #1a1a1a;
    border: 1px solid #555;
    color: #e0e0e0;
    border-radius: 3px;
    font-size: 12px;
}

.edit-row input:focus,
.edit-row select:focus {
    outline: none;
    border-color: #00bcd4;
}

.actions-cell {
    white-space: nowrap;
    min-width: 150px;
}

.actions-cell .btn {
    margin: 1px;
    font-size: 10px;
    padding: 3px 5px;
}

.role-badge {
    padding: 2px 6px;
    border-radius: 4px;
    font-size: 11px;
    font-weight: bold;
}

.role-admin {
    background-color: #ff4444;
    color: #fff;
}

.role-user {
    background-color: #00bcd4;
    color: #000;
}

.status-active {
    color: #00ff88;
    font-weight: bold;
}

.status-inactive {
    color: #ff8800;
    font-weight: bold;
}

.status-pending {
    color: #ffff00;
    font-weight: bold;
}

.btn-danger {
    background-color: #ff4444;
    color: #fff;
}

.btn-danger:hover {
    background-color: #ff6666;
}

.current-user {
    color: #999;
    font-style: italic;
}

.alert-error {
    background-color: #4a1a1a;
    border: 1px solid #ff4444;
    color: #ffaaaa;
}
</style>

<script>
function showAddUserRow() {
    document.getElementById('addUserRow').style.display = 'table-row';
    document.getElementById('new_username').focus();
}

function cancelAdd() {
    document.getElementById('addUserRow').style.display = 'none';
    // Clear form
    document.getElementById('new_username').value = '';
    document.getElementById('new_first_name').value = '';
    document.getElementById('new_last_name').value = '';
    document.getElementById('new_email').value = '';
    document.getElementById('new_password').value = '';
}

function editUser(userId) {
    document.getElementById('row_' + userId).style.display = 'none';
    document.getElementById('edit_' + userId).style.display = 'table-row';
}

function cancelEdit(userId) {
    document.getElementById('edit_' + userId).style.display = 'none';
    document.getElementById('row_' + userId).style.display = 'table-row';
}

function saveNewUser() {
    const username = document.getElementById('new_username').value.trim();
    const firstName = document.getElementById('new_first_name').value.trim();
    const lastName = document.getElementById('new_last_name').value.trim();
    const email = document.getElementById('new_email').value.trim();
    const password = document.getElementById('new_password').value;
    const role = document.getElementById('new_role').value;
    const status = document.getElementById('new_status').value;
    
    if (!username || !firstName || !lastName || !email || !password) {
        alert('Molimo unesite sva obavezna polja.');
        return;
    }
    
    if (password.length < 6) {
        alert('Lozinka mora imati najmanje 6 znakova.');
        return;
    }
    
    // Create form and submit
    const form = document.createElement('form');
    form.method = 'POST';
    form.innerHTML = `
        <input type="hidden" name="action" value="store">
        <input type="hidden" name="username" value="${username}">
        <input type="hidden" name="first_name" value="${firstName}">
        <input type="hidden" name="last_name" value="${lastName}">
        <input type="hidden" name="email" value="${email}">
        <input type="hidden" name="password" value="${password}">
        <input type="hidden" name="role" value="${role}">
        <input type="hidden" name="status" value="${status}">
    `;
    document.body.appendChild(form);
    form.submit();
}

function saveUser(userId) {
    const username = document.getElementById('edit_username_' + userId).value.trim();
    const firstName = document.getElementById('edit_first_name_' + userId).value.trim();
    const lastName = document.getElementById('edit_last_name_' + userId).value.trim();
    const email = document.getElementById('edit_email_' + userId).value.trim();
    const password = document.getElementById('edit_password_' + userId).value;
    const role = document.getElementById('edit_role_' + userId).value;
    const status = document.getElementById('edit_status_' + userId).value;
    
    if (!username || !firstName || !lastName || !email) {
        alert('Molimo unesite sva obavezna polja.');
        return;
    }
    
    // Create form and submit
    const form = document.createElement('form');
    form.method = 'POST';
    form.innerHTML = `
        <input type="hidden" name="action" value="update">
        <input type="hidden" name="user_id" value="${userId}">
        <input type="hidden" name="username" value="${username}">
        <input type="hidden" name="first_name" value="${firstName}">
        <input type="hidden" name="last_name" value="${lastName}">
        <input type="hidden" name="email" value="${email}">
        <input type="hidden" name="password" value="${password}">
        <input type="hidden" name="role" value="${role}">
        <input type="hidden" name="status" value="${status}">
    `;
    document.body.appendChild(form);
    form.submit();
}

function deleteUser(userId, username) {
    if (confirm(`PAŽNJA: Sigurno želite obrisati korisnika "${username}"? Ova akcija je nepovratna.`)) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.innerHTML = `
            <input type="hidden" name="action" value="delete">
            <input type="hidden" name="user_id" value="${userId}">
        `;
        document.body.appendChild(form);
        form.submit();
    }
}
</script>