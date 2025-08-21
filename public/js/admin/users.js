// Simple Users Admin JS

function showAddUserRow() {
    document.getElementById('addUserRow').style.display = 'table-row';
    document.getElementById('new_username').focus();
}

function cancelAdd() {
    document.getElementById('addUserRow').style.display = 'none';
    clearAddForm();
}

function clearAddForm() {
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
    
    submitForm('store', {
        username: username,
        first_name: firstName,
        last_name: lastName,
        email: email,
        password: password,
        role: role,
        status: status
    });
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
    
    submitForm('update', {
        action: 'update',
        user_id: userId,
        username: username,
        first_name: firstName,
        last_name: lastName,
        email: email,
        password: password,
        role: role,
        status: status
    });
}

function deleteUser(userId, username) {
    if (confirm('Sigurno želite obrisati korisnika "' + username + '"?')) {
        submitForm('delete', {
            user_id: userId
        });
    }
}

function submitForm(action, data) {
    const form = document.createElement('form');
    form.method = 'POST';
    
    // Add action
    const actionInput = document.createElement('input');
    actionInput.type = 'hidden';
    actionInput.name = 'action';
    actionInput.value = action;
    form.appendChild(actionInput);
    
    // Add data
    for (const key in data) {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = key;
        input.value = data[key];
        form.appendChild(input);
    }
    
    document.body.appendChild(form);
    form.submit();
}