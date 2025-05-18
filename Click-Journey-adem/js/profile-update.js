/**
 * Gestion des mises à jour asynchrones du profil utilisateur
 * Ce script permet de mettre à jour les informations du profil sans rechargement de page
 */

document.addEventListener('DOMContentLoaded', function() {
    // Sélectionner tous les boutons de confirmation
    const confirmButtons = document.querySelectorAll('.btn-confirm');
    
    // Ajouter un écouteur d'événement à chaque bouton de confirmation
    confirmButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            
            // Récupérer le champ parent
            const fieldContainer = this.closest('.champ-profil');
            if (!fieldContainer) return;
            
            // Récupérer l'input et son identifiant
            const input = fieldContainer.querySelector('.input-edition');
            if (!input) return;
            
            const fieldName = input.getAttribute('name');
            const fieldValue = input.value;
            
            // Vérifier si la valeur a été modifiée
            if (!input.classList.contains('modified')) {
                // Si aucune modification, simplement désactiver l'édition
                toggleEditMode(fieldContainer, false);
                return;
            }
            
            // Préparer les données pour l'envoi
            const data = {};
            data[fieldName] = fieldValue;
            
            // Sauvegarder l'ancienne valeur pour restauration en cas d'erreur
            const oldValue = input.getAttribute('data-original-value');
            
            // Afficher un indicateur de chargement
            const statusIndicator = fieldContainer.querySelector('.status-indicator') || createStatusIndicator(fieldContainer);
            statusIndicator.textContent = '⏳';
            statusIndicator.title = 'Mise à jour en cours...';
            
            // Envoyer la requête AJAX
            updateProfile(data, fieldContainer, input, oldValue, statusIndicator);
        });
    });
    
    // Ajouter des écouteurs pour les boutons d'édition
    const editButtons = document.querySelectorAll('.btn-edit');
    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const fieldContainer = this.closest('.champ-profil');
            if (fieldContainer) {
                toggleEditMode(fieldContainer, true);
            }
        });
    });
    
    // Ajouter des écouteurs pour les boutons d'annulation
    const cancelButtons = document.querySelectorAll('.btn-cancel');
    cancelButtons.forEach(button => {
        button.addEventListener('click', function() {
            const fieldContainer = this.closest('.champ-profil');
            if (fieldContainer) {
                const input = fieldContainer.querySelector('.input-edition');
                if (input) {
                    // Restaurer la valeur originale
                    input.value = input.getAttribute('data-original-value') || '';
                    input.classList.remove('modified');
                }
                toggleEditMode(fieldContainer, false);
            }
        });
    });
    
    // Ajouter des écouteurs pour détecter les modifications dans les champs
    const editableInputs = document.querySelectorAll('.input-edition');
    editableInputs.forEach(input => {
        // Stocker la valeur originale
        input.setAttribute('data-original-value', input.value);
        
        input.addEventListener('input', function() {
            // Marquer comme modifié si la valeur est différente de l'originale
            if (this.value !== this.getAttribute('data-original-value')) {
                this.classList.add('modified');
            } else {
                this.classList.remove('modified');
            }
        });
    });
});

/**
 * Fonction pour basculer le mode d'édition d'un champ
 * @param {HTMLElement} container - Le conteneur du champ
 * @param {boolean} editable - Indique si le champ doit être éditable
 */
function toggleEditMode(container, editable) {
    const input = container.querySelector('.input-edition');
    const editBtn = container.querySelector('.btn-edit');
    const confirmBtn = container.querySelector('.btn-confirm');
    const cancelBtn = container.querySelector('.btn-cancel');
    
    if (input) {
        input.disabled = !editable;
        if (editable) {
            input.focus();
        }
    }
    
    if (editBtn) editBtn.style.display = editable ? 'none' : 'inline';
    if (confirmBtn) confirmBtn.style.display = editable ? 'inline' : 'none';
    if (cancelBtn) cancelBtn.style.display = editable ? 'inline' : 'none';
}

/**
 * Fonction pour créer un indicateur de statut
 * @param {HTMLElement} container - Le conteneur où ajouter l'indicateur
 * @returns {HTMLElement} - L'élément indicateur créé
 */
function createStatusIndicator(container) {
    const indicator = document.createElement('span');
    indicator.className = 'status-indicator';
    indicator.style.marginLeft = '5px';
    container.appendChild(indicator);
    return indicator;
}

/**
 * Fonction pour mettre à jour le profil via une requête AJAX
 * @param {Object} data - Les données à mettre à jour
 * @param {HTMLElement} container - Le conteneur du champ
 * @param {HTMLElement} input - L'élément input modifié
 * @param {string} oldValue - L'ancienne valeur pour restauration en cas d'erreur
 * @param {HTMLElement} statusIndicator - L'indicateur de statut
 */
function updateProfile(data, container, input, oldValue, statusIndicator) {
    fetch('/Click-Journey-adem/API/update_profile.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            // Mise à jour réussie
            statusIndicator.textContent = '✅';
            statusIndicator.title = 'Mise à jour réussie';
            
            // Mettre à jour la valeur originale
            input.setAttribute('data-original-value', input.value);
            input.classList.remove('modified');
            
            // Désactiver le mode édition
            toggleEditMode(container, false);
            
            // Faire disparaître l'indicateur après 3 secondes
            setTimeout(() => {
                statusIndicator.textContent = '';
            }, 3000);
        } else {
            // Erreur lors de la mise à jour
            statusIndicator.textContent = '❌';
            statusIndicator.title = result.message || 'Erreur lors de la mise à jour';
            
            // Restaurer l'ancienne valeur
            input.value = oldValue;
            input.classList.remove('modified');
            
            // Afficher les erreurs spécifiques s'il y en a
            if (result.errors && result.errors[input.getAttribute('name')]) {
                alert(result.errors[input.getAttribute('name')]);
            } else if (result.message) {
                alert(result.message);
            }
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        statusIndicator.textContent = '❌';
        statusIndicator.title = 'Erreur de connexion';
        
        // Restaurer l'ancienne valeur
        input.value = oldValue;
        input.classList.remove('modified');
        
        alert('Erreur de connexion au serveur. Veuillez réessayer plus tard.');
    });
}