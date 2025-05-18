document.addEventListener('DOMContentLoaded', function() {
    // Force le déverrouillage de tous les boutons au chargement
    document.querySelectorAll('.btn-vip, .btn-bannir').forEach(btn => {
        btn.removeAttribute('disabled');
        btn.classList.remove('processing');
    });
    
    // Gestion des clics sur les boutons VIP
    document.addEventListener('click', function(event) {
        // Trouve le bouton le plus proche, que ce soit le clic direct ou sur un élément enfant
        const vipButton = event.target.closest('.btn-vip');
        
        if (vipButton) {
            event.preventDefault();
            event.stopPropagation();
            
            // Données du bouton
            const userLogin = vipButton.closest('tr').dataset.userLogin;
            const originalText = vipButton.textContent.trim();
            
            // Bloque le bouton pendant le traitement
            vipButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Traitement...';
            vipButton.setAttribute('disabled', 'disabled');
            vipButton.classList.add('processing');
            
            // Appel Ajax
            fetch('../php/api/update_user_status.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    user_login: userLogin,
                    action: 'toggle_vip'
                })
            })
            .then(response => response.json())
            .then(data => {
                // Réactive toujours le bouton
                vipButton.removeAttribute('disabled');
                vipButton.classList.remove('processing');
                
                if (data.success) {
                    // Mise à jour du texte du bouton
                    vipButton.textContent = data.new_status === 'vip' ? 'Retirer VIP' : 'Rendre VIP';
                    
                    // Mise à jour du champ rôle
                    const roleField = vipButton.closest('tr').querySelector('[data-field-name="role"]');
                    if (roleField) roleField.textContent = data.new_status;
                    
                    showNotification('Statut VIP modifié avec succès');
                } else {
                    vipButton.textContent = originalText;
                    showNotification('Erreur: ' + data.message, 'error');
                }
            })
            .catch(error => {
                vipButton.textContent = originalText;
                vipButton.removeAttribute('disabled');
                vipButton.classList.remove('processing');
                showNotification('Erreur de connexion', 'error');
                console.error(error);
            });
        }
    });
    
    // Gestion des clics sur les boutons Bannir - SÉPARÉ INTENTIONNELLEMENT POUR ÉVITER LES INTERFÉRENCES
    document.addEventListener('click', function(event) {
        // Trouve le bouton le plus proche, que ce soit le clic direct ou sur un élément enfant
        const banButton = event.target.closest('.btn-bannir');
        
        if (banButton) {
            event.preventDefault();
            event.stopPropagation();
            
            // Données du bouton
            const userLogin = banButton.closest('tr').dataset.userLogin;
            const originalText = banButton.textContent.trim();
            const row = banButton.closest('tr');
            
            // Bloque le bouton pendant le traitement
            banButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Traitement...';
            banButton.setAttribute('disabled', 'disabled');
            banButton.classList.add('processing');
            
            // Appel Ajax
            fetch('../php/api/update_user_status.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    user_login: userLogin,
                    action: 'toggle_ban'
                })
            })
            .then(response => response.json())
            .then(data => {
                // Réactive toujours le bouton
                banButton.removeAttribute('disabled');
                banButton.classList.remove('processing');
                
                if (data.success) {
                    // Mise à jour du texte du bouton
                    banButton.textContent = data.new_status === 'banned' ? 'Débannir Utilisateur' : 'Bannir Utilisateur';
                    
                    // Mise à jour du statut visuel et du rôle
                    const statusSpan = row.querySelector('.statut');
                    const roleField = row.querySelector('[data-field-name="role"]');
                    
                    if (statusSpan) {
                        if (data.new_status === 'banned') {
                            statusSpan.textContent = 'Banni';
                            statusSpan.classList.remove('actif');
                            statusSpan.classList.add('banni');
                            row.dataset.status = 'banned';
                            if (roleField) roleField.textContent = 'banned';
                        } else {
                            statusSpan.textContent = 'Actif';
                            statusSpan.classList.remove('banni');
                            statusSpan.classList.add('actif');
                            row.dataset.status = 'active';
                            if (roleField) roleField.textContent = 'user';
                        }
                    }
                    
                    showNotification('Statut utilisateur modifié avec succès');
                } else {
                    banButton.textContent = originalText;
                    showNotification('Erreur: ' + data.message, 'error');
                }
            })
            .catch(error => {
                banButton.textContent = originalText;
                banButton.removeAttribute('disabled');
                banButton.classList.remove('processing');
                showNotification('Erreur de connexion', 'error');
                console.error(error);
            });
        }
    });
    
    // Débloquer tous les boutons toutes les 5 secondes (sécurité)
    setInterval(function() {
        document.querySelectorAll('.btn-vip, .btn-bannir').forEach(btn => {
            if (btn.hasAttribute('disabled')) {
                console.log('Déblocage automatique d\'un bouton bloqué');
                btn.removeAttribute('disabled');
                btn.classList.remove('processing');
                
                // Restaurer le texte approprié
                if (btn.classList.contains('btn-vip')) {
                    const roleVal = btn.closest('tr').querySelector('[data-field-name="role"]')?.textContent;
                    btn.textContent = roleVal === 'vip' ? 'Retirer VIP' : 'Rendre VIP';
                } else {
                    const isStatusBanned = btn.closest('tr').querySelector('.statut')?.classList.contains('banni');
                    btn.textContent = isStatusBanned ? 'Débannir Utilisateur' : 'Bannir Utilisateur';
                }
            }
        });
    }, 5000);
    
    setupEditableFields();
    
    function setupEditableFields() {
        // Aussi utiliser la délégation d'événements pour les champs éditables
        document.addEventListener('click', function(e) {
            const field = e.target.closest('.editable');
            
            if (field && !field.classList.contains('editing')) {
                const currentValue = field.textContent.trim();
                const fieldType = field.dataset.fieldType;
                const userLogin = field.closest('tr').dataset.userLogin;
                const fieldName = field.dataset.fieldName;
                
                field.setAttribute('data-original-value', currentValue);
                
                let inputElement;
                
                if (fieldType === 'date') {
                    inputElement = document.createElement('input');
                    inputElement.type = 'date';
                    inputElement.value = currentValue;
                } else if (fieldType === 'select') {
                    inputElement = document.createElement('select');
                    const options = field.dataset.options.split(',');
                    options.forEach(option => {
                        const optElement = document.createElement('option');
                        optElement.value = option;
                        optElement.textContent = option;
                        if (option === currentValue) {
                            optElement.selected = true;
                        }
                        inputElement.appendChild(optElement);
                    });
                } else if (fieldType === 'tel') {
                    inputElement = document.createElement('input');
                    inputElement.type = 'tel';
                    inputElement.pattern = "[0-9]{10}";
                    inputElement.value = currentValue;
                } else if (fieldType === 'email') {
                    inputElement = document.createElement('input');
                    inputElement.type = 'email';
                    inputElement.value = currentValue;
                } else {
                    inputElement = document.createElement('input');
                    inputElement.type = 'text';
                    inputElement.value = currentValue;
                }
                
                inputElement.classList.add('editable-input');
                inputElement.dataset.userLogin = userLogin;
                inputElement.dataset.fieldName = fieldName;
                
                field.textContent = '';
                field.appendChild(inputElement);
                field.classList.add('editing');
                
                inputElement.focus();
                
                inputElement.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter') {
                        saveField(this);
                    } else if (e.key === 'Escape') {
                        cancelEdit(this.parentElement);
                    }
                });
                
                inputElement.addEventListener('blur', function() {
                    saveField(this);
                });
            }
        });
    }
    
    function saveField(inputElement) {
        const newValue = inputElement.value.trim();
        const originalValue = inputElement.parentElement.getAttribute('data-original-value');
        const userLogin = inputElement.dataset.userLogin;
        const fieldName = inputElement.dataset.fieldName;
        const parentField = inputElement.parentElement;
        
        if (newValue === originalValue) {
            cancelEdit(parentField);
            return;
        }
        
        parentField.textContent = '';
        const loadingIcon = document.createElement('i');
        loadingIcon.className = 'fas fa-spinner fa-spin loading-icon';
        parentField.appendChild(loadingIcon);
        parentField.classList.remove('editing');
        parentField.classList.add('loading');
        
        const data = {
            user_login: userLogin,
            field: fieldName,
            value: newValue
        };
        
        fetch('../php/api/update_admin_user.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            parentField.classList.remove('loading');
            
            if (data.success) {
                parentField.textContent = newValue;
                showNotification('Modification appliquée avec succès!');
                
                if (fieldName === 'email') {
                    const emailSpan = parentField.closest('tr').querySelector('.email-utilisateur');
                    if (emailSpan) {
                        emailSpan.textContent = newValue;
                    }
                }
                
                if (fieldName === 'nom' || fieldName === 'prenom') {
                    const userInfoDiv = parentField.closest('.info-utilisateur');
                    if (userInfoDiv) {
                        const nameDisplay = userInfoDiv.querySelector('div').childNodes[0];
                        if (nameDisplay) {
                            const row = parentField.closest('tr');
                            const firstName = row.querySelector('[data-field-name="prenom"]')?.textContent || data.updated_data.prenom;
                            const lastName = row.querySelector('[data-field-name="nom"]')?.textContent || data.updated_data.nom;
                            nameDisplay.textContent = firstName + ' ' + lastName;
                        }
                    }
                }
                
                // Si le rôle est modifié, mettre à jour le bouton VIP et l'affichage du statut
                if (fieldName === 'role') {
                    const row = parentField.closest('tr');
                    const vipButton = row.querySelector('.btn-vip');
                    const banButton = row.querySelector('.btn-bannir');
                    const statusSpan = row.querySelector('.statut');
                    
                    if (newValue === 'vip') {
                        if (vipButton) vipButton.textContent = 'Retirer VIP';
                        if (statusSpan) {
                            statusSpan.textContent = 'Actif';
                            statusSpan.classList.remove('banni');
                            statusSpan.classList.add('actif');
                        }
                    } else if (newValue === 'banned') {
                        if (vipButton) vipButton.textContent = 'Rendre VIP';
                        if (banButton) banButton.textContent = 'Débannir Utilisateur';
                        if (statusSpan) {
                            statusSpan.textContent = 'Banni';
                            statusSpan.classList.remove('actif');
                            statusSpan.classList.add('banni');
                        }
                    } else {
                        if (vipButton) vipButton.textContent = 'Rendre VIP';
                        if (banButton) banButton.textContent = 'Bannir Utilisateur';
                        if (statusSpan) {
                            statusSpan.textContent = 'Actif';
                            statusSpan.classList.remove('banni');
                            statusSpan.classList.add('actif');
                        }
                    }
                }
            } else {
                showNotification('Erreur: ' + data.message, 'error');
                parentField.textContent = originalValue;
            }
        })
        .catch(error => {
            parentField.classList.remove('loading');
            parentField.textContent = originalValue;
            showNotification('Erreur de connexion', 'error');
            console.error('Error:', error);
        });
    }
    
    function cancelEdit(parentField) {
        const originalValue = parentField.getAttribute('data-original-value');
        parentField.textContent = originalValue;
        parentField.classList.remove('editing');
    }
    
    function showNotification(message, type = 'success') {
        let notification = document.getElementById('admin-notification');
        if (!notification) {
            notification = document.createElement('div');
            notification.id = 'admin-notification';
            notification.className = 'notification';
            document.body.appendChild(notification);
        }
        
        notification.textContent = message;
        notification.className = 'notification ' + type;
        notification.classList.add('show');
        
        // Faire disparaître la notification après 3 secondes
        setTimeout(() => {
            notification.classList.remove('show');
        }, 3000);
    }
});