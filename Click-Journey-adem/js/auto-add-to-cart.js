document.addEventListener('DOMContentLoaded', function() {
    // Variables principales pour gérer l'état du panier
    let addedToCart = false; // Indique si le circuit est déjà dans le panier
    let circuitId = document.querySelector('input[name="circuit_id"]')?.value; // Récupère l'ID du circuit depuis le formulaire
    let modificationTimeout; // Pour éviter trop de requêtes (debounce)
    let currentCartItemId; // ID de l'élément du panier actuel
    
    // Si on n'a pas de circuit_id, on arrête tout (page incorrecte)
    if (!circuitId) return;
    
    // Récupère tous les champs du formulaire pour les écouter plus tard
    const formElements = document.querySelectorAll('input, select');
    
    /**
     * Vérifie si le circuit est déjà dans le panier
     */
    function checkIfInCart() {
        // Si on a déjà l'ID du panier (par exemple quand on édite depuis le panier)
        if (typeof currentCartItemId !== 'undefined' && currentCartItemId) {
            addedToCart = true;
            updateCartState(true); // Mise à jour immédiate des données
            return;
        }
        
        // Sinon on vérifie avec le serveur si ce circuit est déjà dans le panier
        fetch(`../php/cart/check_in_cart.php?circuit_id=${circuitId}`)
            .then(response => response.json())
            .then(data => {
                if (data.in_cart) {
                    addedToCart = true;
                    if (data.cart_item_id) {
                        currentCartItemId = data.cart_item_id;
                    }
                    // On met à jour tout de suite pour charger les options sauvegardées
                    updateCartState(true);
                }
            })
            .catch(error => console.error('Erreur de vérification du panier:', error));
    }
    
    // Au chargement de la page, on vérifie si le circuit est déjà dans le panier
    checkIfInCart();
    
    /**
     * Affiche une notification que le circuit est ajouté au panier
     */
    function showCartNotification() {
        // Évite les notifications multiples
        if (document.getElementById('cart-notification')) return;
        
        // Crée et affiche une jolie notification
        const notification = document.createElement('div');
        notification.id = 'cart-notification';
        notification.className = 'notification';
        notification.innerHTML = 'Circuit ajouté à votre panier.<br><small>Vos modifications sont automatiquement sauvegardées.</small>';
        document.body.appendChild(notification);
        
        // La notification disparaît après 5 secondes
        setTimeout(() => {
            notification.classList.add('fade-out');
            setTimeout(() => notification.remove(), 500);
        }, 5000);
    }
    
    /**
     * Ajoute le circuit au panier si nécessaire et montre la notification
     */
    function addToCartIfNeeded(immediate = false) {
        if (addedToCart) {
            // Si déjà ajouté, on met juste à jour les données
            updateCartState(immediate);
        } else {
            // Sinon on ajoute d'abord au panier
            fetch(`../php/cart/add_to_cart.php?circuit_id=${circuitId}&auto=1`)
                .then(response => {
                    if (response.ok) {
                        addedToCart = true;
                        showCartNotification();
                        updateCartState(immediate);
                    }
                })
                .catch(error => console.error('Erreur ajout au panier:', error));
        }
    }
    
    /**
     * Met à jour l'état du panier avec les données du formulaire
     */
    function updateCartState(skipTimeout = false) {
        // Annule le timeout précédent s'il existe
        if (modificationTimeout) {
            clearTimeout(modificationTimeout);
        }
        
        const updateFunction = function() {
            // Récupère le formulaire
            const form = document.querySelector('form');
            if (!form) return;
            
            // Prépare les données à envoyer
            const formData = new FormData(form);
            
            // Ajoute l'ID du panier s'il est connu
            if (typeof currentCartItemId !== 'undefined' && currentCartItemId) {
                formData.set('cart_item_id', currentCartItemId);
            }
            
            // S'assure que toutes les données importantes sont incluses
            collectAndAddFormData(formData);
            
            // Envoie les données au serveur pour sauvegarder
            fetch('../php/cart/auto_save_cart.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Met à jour l'ID du panier si le serveur nous en donne un nouveau
                    updateCartItemIdField(data.cart_item_id);
                    
                    // Si c'est la première sauvegarde, on affiche la notification
                    if (!addedToCart) {
                        addedToCart = true;
                        showCartNotification();
                    }
                    
                    // Montre une petite confirmation visuelle
                    showSaveConfirmation();
                }
            })
            .catch(error => {
                console.error('Erreur sauvegarde automatique:', error);
            });
        };
        
        // Applique immédiatement ou après un délai (pour éviter trop de requêtes)
        if (skipTimeout) {
            updateFunction();
        } else {
            modificationTimeout = setTimeout(updateFunction, 1000); // Délai d'1 seconde
        }
    }
    
    /**
     * Collecte et ajoute toutes les données du formulaire
     */
    function collectAndAddFormData(formData) {
        // 1. Vérifie le nombre de personnes
        const nbPersonnes = document.getElementById('nb_personnes');
        if (nbPersonnes) formData.set('nb_personnes', nbPersonnes.value);
        
        // 2. S'assure que les dates sont incluses
        const dateDebut = document.getElementById('date_debut');
        const dateFin = document.getElementById('date_fin');
        if (dateDebut) formData.set('date_debut', dateDebut.value);
        if (dateFin) formData.set('date_fin', dateFin.value);
        
        // 3. Récupère toutes les sélections dans les listes déroulantes
        document.querySelectorAll('select').forEach(select => {
            if (select.name) formData.set(select.name, select.value);
        });
        
        // 4. Récupère les cases cochées
        document.querySelectorAll('input[type="checkbox"]:checked').forEach(checkbox => {
            if (checkbox.name) formData.append(checkbox.name, checkbox.value);
        });
    }
    
    /**
     * Met à jour l'ID de l'élément du panier dans le formulaire
     */
    function updateCartItemIdField(cartItemId) {
        if (!cartItemId) return;
        
        currentCartItemId = cartItemId;
        
        // Met à jour le champ caché ou le crée s'il n'existe pas
        let cartItemIdInput = document.querySelector('input[name="cart_item_id"]');
        if (!cartItemIdInput) {
            cartItemIdInput = document.createElement('input');
            cartItemIdInput.type = 'hidden';
            cartItemIdInput.name = 'cart_item_id';
            document.querySelector('form')?.appendChild(cartItemIdInput);
        }
        cartItemIdInput.value = currentCartItemId;
    }
    
    /**
     * Affiche une confirmation temporaire de sauvegarde
     */
    function showSaveConfirmation() {
        // Trouve l'indicateur existant ou en crée un
        const saveIndicator = document.querySelector('.auto-save-indicator') || document.createElement('div');
        saveIndicator.className = 'auto-save-indicator';
        saveIndicator.textContent = 'Modifications sauvegardées';
        
        // Ajoute au DOM s'il n'existe pas déjà
        if (!document.querySelector('.auto-save-indicator')) {
            document.body.appendChild(saveIndicator);
        }
        
        // Affiche puis masque après 2 secondes
        saveIndicator.style.display = 'block';
        setTimeout(() => {
            saveIndicator.style.display = 'none';
        }, 2000);
    }
    
    // Configuration des écouteurs d'événements
    
    // 1. Pour le nombre de personnes (mise à jour immédiate)
    const nbPersonnesSelect = document.getElementById('nb_personnes');
    if (nbPersonnesSelect) {
        nbPersonnesSelect.addEventListener('change', () => addToCartIfNeeded(true));
    }
    
    // 2. Pour les dates (mise à jour immédiate)
    document.querySelectorAll('input[type="date"]').forEach(dateInput => {
        dateInput.addEventListener('change', () => addToCartIfNeeded(true));
    });
    
    // 3. Pour tous les autres champs du formulaire
    formElements.forEach(element => {
        if (element.id !== 'nb_personnes' && element.type !== 'date') {
            element.addEventListener('change', () => addToCartIfNeeded());
            
            // Pour les inputs (tapés au clavier), on utilise aussi l'événement input
            if (element.tagName === 'INPUT' && element.type !== 'hidden') {
                element.addEventListener('input', () => addToCartIfNeeded());
            }
        }
    });
    
    // Observer pour détecter les nouveaux éléments ajoutés dynamiquement
    const observer = new MutationObserver(mutations => {
        mutations.forEach(mutation => {
            if (mutation.type === 'childList' && mutation.addedNodes.length > 0) {
                mutation.addedNodes.forEach(node => {
                    if (node.nodeType === 1) { // ELEMENT_NODE (élément HTML)
                        // Ajoute des écouteurs sur les nouveaux selects ajoutés dynamiquement
                        node.querySelectorAll('select').forEach(select => {
                            if (select.name) {
                                select.addEventListener('change', () => updateCartState(true));
                            }
                        });
                        
                        // Ajoute des écouteurs sur les nouvelles checkboxes ajoutées dynamiquement
                        node.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
                            if (checkbox.name) {
                                checkbox.addEventListener('change', () => updateCartState(true));
                            }
                        });
                    }
                });
            }
        });
    });
    
    // Observe les changements dans le conteneur des étapes du voyage
    const stagesContainer = document.querySelector('.journey-stages');
    if (stagesContainer) {
        observer.observe(stagesContainer, { childList: true, subtree: true });
    }
});