document.addEventListener('DOMContentLoaded', function() {
    const usernameInput = document.getElementById('username');
    
    if (!usernameInput) {
        return;
    }
    
    let checkTimeout;
    
    const statusDiv = document.createElement('div');
    statusDiv.className = 'username-status';
    usernameInput.parentNode.appendChild(statusDiv);
    
    usernameInput.addEventListener('input', function() {
        const username = this.value.trim();
        
        clearTimeout(checkTimeout);
        
        if (username === '') {
            statusDiv.innerHTML = '';
            this.style.borderColor = '#444';
            return;
        }
        
        if (username.length < 3) {
            statusDiv.innerHTML = '<span style="color: #ff4444;">✗ Najmanje 3 znaka</span>';
            this.style.borderColor = '#ff4444';
            return;
        }
        
        statusDiv.innerHTML = '<span style="color: #999;">🔍 Provjeravam...</span>';
        this.style.borderColor = '#999';
        
        checkTimeout = setTimeout(() => {
            checkUsername(username);
        }, 500);
    });
    

    function checkUsername(username) {
        const formData = new FormData();
        formData.append('username', username);
        
        fetch('?page=check_username&action=check', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            updateUsernameStatus(data);
        })
        .catch(error => {
            console.error('Error:', error);
            statusDiv.innerHTML = '<span style="color: #ff4444;">⚠️ Greška pri provjeri</span>';
            usernameInput.style.borderColor = '#ff4444';
        });
    }
    
    function updateUsernameStatus(data) {
        if (data.available) {
            statusDiv.innerHTML = '<span style="color: #00ff88;">✓ ' + data.message + '</span>';
            usernameInput.style.borderColor = '#00ff88';
        } else {
            statusDiv.innerHTML = '<span style="color: #ff4444;">✗ ' + data.message + '</span>';
            usernameInput.style.borderColor = '#ff4444';
        }
    }
});