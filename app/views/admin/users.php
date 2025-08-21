<!-- Users Management -->
<div class="container">
    <div class="admin-header">
        <h1>Upravljanje korisnicima</h1>
        <button onclick="showAddUserRow()" class="btn btn-primary">+ Dodaj korisnika</button>
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
        <table>
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
                <!-- Add new user row -->
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
                        <button onclick="saveNewUser()" class="btn btn-primary btn-small">Spremi</button>
                        <button onclick="cancelAdd()" class="btn btn-outline btn-small">Odustani</button>
                        <div style="margin-top: 5px;">
                            <input type="password" id="new_password" placeholder="Lozinka" style="width: 80px;" required>
                        </div>
                    </td>
                </tr>
                
                <?php foreach ($users as $user): ?>
                    <!-- Normal view -->
                    <tr id="row_<?php echo $user['id']; ?>">
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
                        <td>
                            <?php if ($user['id'] != $_SESSION['user_id']): ?>
                                <button onclick="editUser(<?php echo $user['id']; ?>)" class="btn btn-outline btn-small">
                                    Uredi
                                </button>
                                <button onclick="deleteUser(<?php echo $user['id']; ?>, '<?php echo htmlspecialchars($user['username']); ?>')" 
                                        class="btn btn-danger btn-small">
                                    Obriši
                                </button>
                            <?php else: ?>
                                <em>Vaš račun</em>
                            <?php endif; ?>
                        </td>
                    </tr>
                    
                    <!-- Edit row -->
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
                            </select>
                        </td>
                        <td>
                            <button onclick="saveUser(<?php echo $user['id']; ?>)" class="btn btn-primary btn-small">Spremi</button>
                            <button onclick="cancelEdit(<?php echo $user['id']; ?>)" class="btn btn-outline btn-small">Odustani</button>
                            <div style="margin-top: 5px;">
                                <input type="password" id="edit_password_<?php echo $user['id']; ?>" placeholder="Nova lozinka" style="width: 80px;">
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="js/admin/users.js"></script>