document.addEventListener(

    'DOMContentLoaded', 
    
    function() {


    if (
        
        document.querySelector('.reservation-form')
        
        ) {
        
        
        initDynamicPricing();
    }
});



function initDynamicPricing() {
    
    
    const pricingContainer = document.createElement(
        
        'div'
        
        );
    
    
    pricingContainer.className = 'pricing-container';
    
    
    pricingContainer.innerHTML = `
        <h3>Prix estimé</h3>
        <p class="price-display">Calculé en fonction de vos choix</p>
    `;
    
    
    const submitButton = document.querySelector('.summary-button');


    if (
        
        submitButton && submitButton.parentNode
        
        ) {
        
        
        
        submitButton.parentNode.insertBefore(pricingContainer, submitButton);
    }
    
    
    let basePrice = getBasePrice();
    
    
    addPriceChangeListeners();
    
    
    
    updatePriceAsync();
}



function getBasePrice() {
    
    
    const urlParams = new URLSearchParams(window.location.search);
    
    
    const circuitId = urlParams.get('circuit');
    
    
    let basePrice = 1000;
    
    
    
    const circuitPrices = {
        
        '1': 4789,  
        
        '2': 5989,  


        '3': 2289,  
        
        '4': 1800,  
        
        '5': 3999,  
        
        '6': 2999,  


        '7': 4299,  
        
        '8': 3499,  
        
        '9': 4599,  
        
        '10': 1999, 

        
        '11': 2599, 
        
        '12': 4999, 
        
        '13': 5499, 
        
        '14': 5999, 
        
        
        '15': 4899, 
        
        '16': 3999, 
        
        '17': 3799  
    };
    
    
    if (
        
        circuitId && circuitPrices[circuitId]
        
        ) {


        basePrice = circuitPrices[circuitId];
    }
    
    
    return basePrice;
}



function addPriceChangeListeners() {
    
    
    const nbPersonnes = document.getElementById('nb_personnes');


    if (
        
        nbPersonnes
        
        ) {
        
        
        nbPersonnes.addEventListener('change', updatePriceAsync);
    }
    
    
    const lodgingSelects = document.querySelectorAll('select[id^="lodging-"]');
    
    
    lodgingSelects.forEach(select => {


        select.addEventListener(
            
            'change', 
            
            updatePriceAsync
            
            );
    });
    
    
    const mealsSelects = document.querySelectorAll('select[id^="meals-"]');
    
    
    mealsSelects.forEach(select => {
        
        
        select.addEventListener(
            
            'change', 
            
            updatePriceAsync
            
            );
    });
    
    
    const activitiesSelects = document.querySelectorAll('select[id^="activities-"]');
    
    
    activitiesSelects.forEach(select => {
        
        
        select.addEventListener(
            
            'change', 
            
            updatePriceAsync
            
            );
    });
    
    
    const transportSelects = document.querySelectorAll('select[id^="transport-"]');
    
    
    transportSelects.forEach(select => {


        select.addEventListener(
            
            'change', 
            
            updatePriceAsync
            
            );
    });
}


// Fonction asynchrone pour mettre à jour le prix
function updatePriceAsync() {
    
    // Afficher un indicateur de chargement
    const priceDisplay = document.querySelector('.price-display');
    if (priceDisplay) {
        priceDisplay.innerHTML = '<span class="loading">Calcul en cours...</span>';
    }
    
    // Collecter toutes les données nécessaires au calcul
    const optionsData = collectOptionsData();
    
    // Simuler une requête asynchrone avec un délai de 2 secondes pour montrer l'indicateur de chargement
    setTimeout(() => {
        calculatePriceAsync(optionsData)
            .then(totalPrice => {
                updatePriceDisplay(totalPrice);
                
                // CORRECTION: Ajouter un champ caché pour le prix total ou mettre à jour s'il existe déjà
                let prixTotalInput = document.querySelector('input[name="prix_total"]');
                if (!prixTotalInput) {
                    prixTotalInput = document.createElement('input');
                    prixTotalInput.type = 'hidden';
                    prixTotalInput.name = 'prix_total';
                    document.querySelector('form').appendChild(prixTotalInput);
                }
                
                // Mettre à jour la valeur du prix total
                prixTotalInput.value = totalPrice;
                console.log("Prix total mis à jour:", totalPrice);
                
                // Déclencher un événement de changement pour que le système de sauvegarde automatique soit notifié
                const changeEvent = new Event('change');
                prixTotalInput.dispatchEvent(changeEvent);
                
                // Si le système de sauvegarde automatique est présent, l'appeler directement
                if (typeof updateCartState === 'function') {
                    console.log("Appel de la fonction de sauvegarde automatique");
                    updateCartState(true); // Appel immédiat sans délai
                }
            })
            .catch(error => {
                console.error('Erreur lors du calcul du prix:', error);
                if (priceDisplay) {
                    priceDisplay.innerHTML = 'Erreur lors du calcul du prix';
                }
            });
    }, 2000);
}

// Collecte toutes les options choisies par l'utilisateur
function collectOptionsData() {
    const urlParams = new URLSearchParams(window.location.search);
    const circuitId = urlParams.get('circuit');
    const nbPersonnes = document.getElementById('nb_personnes');
    const personnesCount = nbPersonnes ? parseInt(nbPersonnes.value) : 1;
    
    console.log("Collecte des données d'options pour le calcul du prix");
    console.log("Circuit ID:", circuitId);
    console.log("Nombre de personnes:", personnesCount);
    
    // Trouver toutes les étapes et leurs options
    const stages = document.querySelectorAll('.stage-card');
    console.log(`Nombre d'étapes trouvées: ${stages.length}`);
    
    const options = [];
    
    // Parcourir toutes les étapes pour collecter leurs options
    stages.forEach((stage, index) => {
        console.log(`Analyse de l'étape ${index + 1}`);
        const stageOptions = {
            lodging: 1,    // Valeur par défaut
            meals: 1,      // Valeur par défaut
            activities: 1, // Valeur par défaut
            transport: 1   // Valeur par défaut
        };
        
        // Récupérer les valeurs des selects pour cette étape
        // Hébergement
        const lodgingSelect = document.getElementById(`lodging-${index}`);
        if (lodgingSelect) {
            // Convertir en entier ou utiliser la valeur par défaut 1
            const lodgingValue = lodgingSelect.value ? parseInt(lodgingSelect.value) : null;
            if (!isNaN(lodgingValue) && lodgingValue > 0) {
                stageOptions.lodging = lodgingValue;
                console.log(`  Hébergement: ${lodgingValue}`);
            } else {
                console.log(`  Hébergement: valeur par défaut (${stageOptions.lodging})`);
            }
        }
        
        // Repas
        const mealsSelect = document.getElementById(`meals-${index}`);
        if (mealsSelect) {
            // Pour les repas nous avons des valeurs textuelles qu'il faut convertir en valeurs numériques
            const mealsValue = mealsSelect.value;
            let mealsNumeric = 1; // Sans repas (valeur par défaut)
            
            if (mealsValue === 'breakfast') mealsNumeric = 2;
            else if (mealsValue === 'half') mealsNumeric = 3;
            else if (mealsValue === 'full') mealsNumeric = 4;
            
            stageOptions.meals = mealsNumeric;
            console.log(`  Repas: ${mealsValue} (valeur numérique: ${mealsNumeric})`);
        }
        
        // Activités - multi-sélect, mais ici on prend la valeur la plus élevée pour la tarification
        const activitiesSelects = stage.querySelectorAll('select[name^="stages[' + index + '][activities]"]');
        if (activitiesSelects.length > 0) {
            let activitiesValue = 1; // Valeur par défaut
            
            activitiesSelects.forEach((select) => {
                const selectedOptions = Array.from(select.selectedOptions);
                if (selectedOptions.length > 0) {
                    // Utiliser la moyenne des activités sélectionnées comme indicateur de prix
                    const totalValue = selectedOptions.length * 2; // Plus d'activités = supplément plus élevé
                    activitiesValue = Math.min(4, Math.max(1, totalValue)); // Limiter entre 1 et 4
                    console.log(`  Activités: ${selectedOptions.length} sélectionnées (valeur: ${activitiesValue})`);
                }
            });
            
            stageOptions.activities = activitiesValue;
        }
        
        // Transport
        const transportSelect = document.getElementById(`transport-${index}`);
        if (transportSelect) {
            const transportValue = transportSelect.value ? parseInt(transportSelect.value) : null;
            if (!isNaN(transportValue) && transportValue > 0) {
                stageOptions.transport = transportValue;
                console.log(`  Transport: ${transportValue}`);
            } else {
                console.log(`  Transport: valeur par défaut (${stageOptions.transport})`);
            }
        }
        
        options.push(stageOptions);
    });
    
    console.log("Données collectées:", {
        circuitId,
        personnesCount,
        options
    });
    
    return {
        circuitId: circuitId,
        personnesCount: personnesCount,
        options: options
    };
}

// Fonction qui simule une requête asynchrone pour calculer le prix
function calculatePriceAsync(optionsData) {
    return new Promise((resolve, reject) => {
        try {
            console.log("Début du calcul du prix");
            const basePrice = getBasePrice();
            console.log("Prix de base:", basePrice);
            
            let totalPrice = basePrice;
            let stageExtras = 0;
            
            // Calculer les suppléments pour chaque étape
            optionsData.options.forEach((stageOptions, index) => {
                console.log(`Calcul des suppléments pour l'étape ${index + 1}`);
                let stageExtra = 0;
                
                // Hébergement
                switch (stageOptions.lodging) {
                    case 1: break; // Standard (pas de supplément)
                    case 2: stageExtra += 50 * optionsData.personnesCount; break;
                    case 3: stageExtra += 120 * optionsData.personnesCount; break;
                    case 4: stageExtra += 200 * optionsData.personnesCount; break;
                }
                
                // Repas
                switch (stageOptions.meals) {
                    case 1: break; // Standard (pas de supplément)
                    case 2: stageExtra += 25 * optionsData.personnesCount; break;
                    case 3: stageExtra += 50 * optionsData.personnesCount; break;
                    case 4: stageExtra += 80 * optionsData.personnesCount; break;
                }
                
                // Activités
                switch (stageOptions.activities) {
                    case 1: break; // Standard (pas de supplément)
                    case 2: stageExtra += 40 * optionsData.personnesCount; break;
                    case 3: stageExtra += 80 * optionsData.personnesCount; break;
                    case 4: stageExtra += 150 * optionsData.personnesCount; break;
                }
                
                // Transport
                switch (stageOptions.transport) {
                    case 1: break; // Standard (pas de supplément)
                    case 2: stageExtra += 25 * optionsData.personnesCount; break;
                    case 3: stageExtra += 60 * optionsData.personnesCount; break;
                    case 4: stageExtra += 100 * optionsData.personnesCount; break;
                }
                
                console.log(`Supplément pour l'étape ${index + 1}: ${stageExtra}€`);
                stageExtras += stageExtra;
            });
            
            console.log("Total des suppléments:", stageExtras);
            
            // Calculer le prix total
            // Prix de base par personne avec réduction de 10% pour les groupes
            const basePricePerPerson = basePrice * (optionsData.personnesCount > 1 ? 0.9 : 1);
            const basePriceTotal = basePricePerPerson * optionsData.personnesCount;
            
            totalPrice = Math.round(basePriceTotal + stageExtras);
            
            console.log("Prix de base par personne:", basePricePerPerson);
            console.log("Prix de base total:", basePriceTotal);
            console.log("Prix total final:", totalPrice);
            
            resolve(totalPrice);
        } catch (error) {
            console.error("Erreur lors du calcul du prix:", error);
            reject(error);
        }
    });
}


function updatePriceDisplay(price) {
    console.log("Mise à jour de l'affichage du prix :", price);
    
    const priceDisplay = document.querySelector('.price-display');
    const nbPersonnes = document.getElementById('nb_personnes');
    const personnesCount = nbPersonnes ? parseInt(nbPersonnes.value) : 1;
    
    if (priceDisplay) {
        const pricePerPerson = Math.round(price / personnesCount);
        
        priceDisplay.innerHTML = `
            <span class="price">${price.toLocaleString('fr-FR')} €</span>
            <span class="price-per-person">soit ${pricePerPerson.toLocaleString('fr-FR')} € par personne</span>
            <span class="price-info">Le prix est calculé en fonction de vos options sélectionnées.</span>
        `;
        
        // Ajouter une classe pour indiquer que le prix a été mis à jour
        priceDisplay.classList.add('price-updated');
        
        console.log(`Prix affiché: ${price}€ total, ${pricePerPerson}€ par personne`);
    } else {
        console.warn("Élément d'affichage du prix non trouvé");
    }
}



function getDateDifference(startDate, endDate) {
    
    
    const start = new Date(startDate);
    
    
    const end = new Date(endDate);
    
    
    
    const diffTime = Math.abs(end - start);
    
    
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
    
    
    
    return diffDays;
}



function createSummaryUI() {
    
    
    const stageCards = document.querySelectorAll('.stage-card');
    
    
    
    const summaryDiv = document.createElement('div');
    
    
    summaryDiv.className = 'reservation-summary';
    
    
    
    let summaryHTML = '<h3>Récapitulatif de votre réservation</h3>';
    
    
    
    stageCards.forEach((card, index) => {
        
        
        const stageTitle = card.querySelector('h3').innerText;
        
        
        const lodgingSelect = document.getElementById(`lodging-${index}`);
        
        
        const mealsSelect = document.getElementById(`meals-${index}`);
        
        
        const activitiesSelect = document.getElementById(`activities-${index}`);
        
        
        const transportSelect = document.getElementById(`transport-${index}`);
        
        
        
        summaryHTML += `
            <div class="summary-stage">
                <h4>${stageTitle}</h4>
                <ul>
                    <li>Hébergement: ${lodgingSelect ? lodgingSelect.options[lodgingSelect.selectedIndex].text : 'Standard'}</li>
                    <li>Repas: ${mealsSelect ? mealsSelect.options[mealsSelect.selectedIndex].text : 'Standard'}</li>
                    <li>Activités: ${activitiesSelect ? activitiesSelect.options[activitiesSelect.selectedIndex].text : 'Standard'}</li>
                    <li>Transport: ${transportSelect ? transportSelect.options[transportSelect.selectedIndex].text : 'Standard'}</li>
                </ul>
            </div>
        `;
    });
    
    // Ajouter un conteneur pour le prix qui sera mis à jour de façon asynchrone
    summaryHTML += `
        <div class="summary-price">
            <p>Prix total: <strong id="summary-total-price">Calcul en cours...</strong></p>
        </div>
    `;
    
    summaryDiv.innerHTML = summaryHTML;
    
    // Calculer le prix de façon asynchrone
    const optionsData = collectOptionsData();
    
    // Ajouter un délai de 2 secondes pour le calcul
    setTimeout(() => {
        calculatePriceAsync(optionsData)
            .then(totalPrice => {
                const totalPriceElement = summaryDiv.querySelector('#summary-total-price');
                if (totalPriceElement) {
                    totalPriceElement.textContent = `${totalPrice.toLocaleString('fr-FR')} €`;
                }
            })
            .catch(error => {
                console.error('Erreur lors du calcul du prix pour le récapitulatif:', error);
                const totalPriceElement = summaryDiv.querySelector('#summary-total-price');
                if (totalPriceElement) {
                    totalPriceElement.textContent = 'Erreur lors du calcul';
                }
            });
    }, 2000);
    
    return summaryDiv;
}