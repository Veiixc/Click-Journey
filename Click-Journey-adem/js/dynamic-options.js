document.addEventListener('DOMContentLoaded', () => loadStageOptions());


function loadStageOptions() {
    const urlParams = new URLSearchParams(window.location.search);
    const circuitId = urlParams.get('circuit');
    
    if (!circuitId) return;
    
    // Afficher l'indicateur de chargement
    const journeyStagesContainer = document.querySelector('.journey-stages');
    const loadingIndicator = journeyStagesContainer?.querySelector('.loading-indicator');
    if (loadingIndicator) loadingIndicator.style.display = 'block';
    
    // Variable pour suivre si les étapes ont été chargées
    window.stagesLoaded = false;
    
    fetch(`../php/api/get_circuit_options.php?circuit_id=${circuitId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                createStagesUI(data.stages);
                
                // Marquer les étapes comme chargées
                window.stagesLoaded = true;
                
                // Charger les options sauvegardées après avoir créé l'interface
                loadSavedOptions(circuitId);
            } else {
                showErrorMessage(journeyStagesContainer, 
                    `Erreur lors du chargement des options du circuit ${circuitId}`, 
                    data.message || 'Veuillez réessayer plus tard');
            }
        })
        .catch(error => {
            showErrorMessage(journeyStagesContainer, 
                'Une erreur est survenue lors du chargement des options',
                'Veuillez réessayer plus tard');
        });
}



function showErrorMessage(container, title, message) {
    if (!container) return;
    container.innerHTML = `
        <div class="error-message">
            <p>${title}</p>
            <p>${message}</p>
        </div>
    `;
}

/**
 * Charge les options sauvegardées dans le panier
 */
function loadSavedOptions(circuitId) {
    let url = `../php/cart/get_saved_options.php?circuit_id=${circuitId}`;
    
    // Ajouter l'ID de l'élément du panier si disponible
    if (typeof currentCartItemId !== 'undefined' && currentCartItemId) {
        url += `&cart_item_id=${currentCartItemId}`;
    }
    
    // Récupérer les données sauvegardées
    fetch(url)
        .then(response => response.json())
        .then(data => {
            if (data.success && data.cart_item) {
                updateCartItemId(data.cart_item_id);
                
                // Stocker les données pour les appliquer une fois que les étapes sont chargées
                const savedData = data.cart_item.journey_data;
                
                // Fonction pour vérifier si les étapes sont chargées et appliquer les options
                const checkAndApplyOptions = () => {
                    if (window.stagesLoaded) {
                        applySavedOptions(savedData);
                    } else {
                        setTimeout(checkAndApplyOptions, 500);
                    }
                };
                
                // Commencer à vérifier si les étapes sont chargées
                checkAndApplyOptions();
            }
        })
        .catch(error => {});
}

/**
 * Met à jour l'ID de l'élément du panier
 */
function updateCartItemId(cartItemId) {
    if (!cartItemId) return;
    
    // Mettre à jour la variable globale
    if (typeof currentCartItemId !== 'undefined') {
        currentCartItemId = cartItemId;
    }
    
    // Mettre à jour ou créer le champ caché
    let cartItemIdInput = document.querySelector('input[name="cart_item_id"]');
    if (!cartItemIdInput) {
        cartItemIdInput = document.createElement('input');
        cartItemIdInput.type = 'hidden';
        cartItemIdInput.name = 'cart_item_id';
        document.querySelector('form')?.appendChild(cartItemIdInput);
    }
    cartItemIdInput.value = cartItemId;
}

/**
 * Applique les options sauvegardées au formulaire
 */
function applySavedOptions(journeyData) {
    if (!journeyData) return;
    
    // Appliquer les valeurs générales
    setElementValue('date_debut', journeyData.date_debut);
    setElementValue('date_fin', journeyData.date_fin);
    setElementValue('nb_personnes', journeyData.nb_personnes);
    
    // Créer/mettre à jour le champ pour le prix total
    let prixTotalInput = document.querySelector('input[name="prix_total"]');
    if (!prixTotalInput) {
        prixTotalInput = document.createElement('input');
        prixTotalInput.type = 'hidden';
        prixTotalInput.name = 'prix_total';
        document.querySelector('form')?.appendChild(prixTotalInput);
    }
    
    if (journeyData.prix_total) {
        prixTotalInput.value = journeyData.prix_total;
    }
    
    // Attendre le chargement complet du DOM pour appliquer les options d'étape
    setTimeout(() => {
        // S'assurer que les étapes sont bien chargées avant d'appliquer les options
        if (journeyData.journey_stages && journeyData.journey_stages.length > 0) {
            applyStagesOptions(journeyData.journey_stages);
        }
        
        // Mettre à jour l'affichage du prix
        if (typeof updatePriceAsync === 'function') {
            updatePriceAsync();
        }
    }, 1000); // Augmenter le délai pour s'assurer que le DOM est complètement chargé
}

/**
 * Définit la valeur d'un élément par ID s'il existe
 */
function setElementValue(id, value) {
    if (!value) return;
    const element = document.getElementById(id);
    if (element) element.value = value;
}

/**
 * Applique les options aux étapes du voyage
 */
function applyStagesOptions(stages) {
    if (!stages || !stages.length) return;
    
    stages.forEach((stage, index) => {
        if (!stage.raw_data) {
            return;
        }
        
        // Hébergement
        const lodgingElement = document.getElementById(`lodging-${index}`);
        if (lodgingElement) {
            setElementValue(`lodging-${index}`, stage.raw_data.lodging);
        }
        
        // Repas
        const mealsElement = document.getElementById(`meals-${index}`);
        if (mealsElement) {
            setElementValue(`meals-${index}`, stage.raw_data.meals);
        }
        
        // Transport
        const transportElement = document.getElementById(`transport-${index}`);
        if (transportElement) {
            setElementValue(`transport-${index}`, stage.raw_data.transport);
        }
        
        // Activités (multi-select)
        const activitiesSelect = document.getElementById(`activities-${index}`);
        if (activitiesSelect && stage.raw_data.activities) {
            const activities = Array.isArray(stage.raw_data.activities) 
                ? stage.raw_data.activities 
                : [stage.raw_data.activities];
            
            // Désélectionner toutes les options d'abord
            Array.from(activitiesSelect.options).forEach(option => option.selected = false);
            
            // Sélectionner les activités sauvegardées
            activities.forEach(activityId => {
                Array.from(activitiesSelect.options).forEach(option => {
                    if (option.value === activityId) {
                        option.selected = true;
                    }
                });
            });
        }
    });
}

/**
 * Crée l'interface utilisateur pour les étapes
 */
function createStagesUI(stages) {
    const journeyStagesContainer = document.querySelector('.journey-stages');
    
    if (!journeyStagesContainer) return;
    
    // Vider le conteneur existant
    journeyStagesContainer.innerHTML = '';
    
    if (!stages.length) {
        journeyStagesContainer.innerHTML = '<p>Aucune étape disponible pour ce circuit</p>';
        return;
    }
    
    // Créer et ajouter chaque étape
    stages.forEach((stage, index) => {
        const stageCard = document.createElement('div');
        stageCard.className = 'stage-card';
        
        // En-tête de l'étape
        const stageHeader = document.createElement('div');
        stageHeader.className = 'stage-header';
        stageHeader.innerHTML = `
            <h3 class="stage-title">Étape ${index + 1}: ${stage.title}</h3>
            <span class="stage-duration">${stage.duration} jours</span>
        `;
        
        // Options de l'étape
        const stageOptions = document.createElement('div');
        stageOptions.className = 'stage-options';
        stageOptions.innerHTML = createStageOptionsHTML(index);
        
        // Assembler et ajouter la carte d'étape
        stageCard.appendChild(stageHeader);
        stageCard.appendChild(stageOptions);
        journeyStagesContainer.appendChild(stageCard);
        
        // Remplir les options de sélection
        populateSelectOptions(document.getElementById(`lodging-${index}`), stage.lodging_options);
        populateSelectOptions(document.getElementById(`activities-${index}`), stage.activities);
        populateSelectOptions(document.getElementById(`transport-${index}`), stage.transport_options);
    });
    
    // Ajouter les écouteurs de prix si disponibles
    if (typeof addPriceChangeListeners === 'function') {
        addPriceChangeListeners();
    }
}

/**
 * Crée le HTML pour les options d'une étape
 */
function createStageOptionsHTML(index) {
    return `
        <div class="option-group">
            <label for="lodging-${index}">Hébergement</label>
            <select id="lodging-${index}" name="stages[${index}][lodging]" required>
                <option value="">Choisissez un hébergement</option>
            </select>
        </div>
        
        <div class="option-group">
            <label for="meals-${index}">Restauration</label>
            <select id="meals-${index}" name="stages[${index}][meals]">
                <option value="none">Sans repas</option>
                <option value="breakfast">Petit déjeuner</option>
                <option value="half">Demi-pension</option>
                <option value="full">Pension complète</option>
            </select>
        </div>
        
        <div class="option-group">
            <label for="activities-${index}">Activités</label>
            <select id="activities-${index}" name="stages[${index}][activities]" multiple>
            </select>
        </div>
        
        <div class="option-group">
            <label for="transport-${index}">Transport vers prochaine étape</label>
            <select id="transport-${index}" name="stages[${index}][transport]">
            </select>
        </div>
    `;
}

/**
 * Remplit un élément select avec des options
 */
function populateSelectOptions(selectElement, options) {
    if (!selectElement || !options) return;
    
    // S'il s'agit d'un select multiple, on ne met pas d'option par défaut
    if (!selectElement.multiple) {
        // Conserver la première option (option par défaut)
        const defaultOption = selectElement.options[0];
        selectElement.innerHTML = '';
        if (defaultOption) selectElement.appendChild(defaultOption);
    } else {
        selectElement.innerHTML = '';
    }
    
    // Ajouter chaque option
    options.forEach(option => {
        const optElement = document.createElement('option');
        optElement.value = option.id;
        optElement.textContent = option.name;
        selectElement.appendChild(optElement);
    });
}