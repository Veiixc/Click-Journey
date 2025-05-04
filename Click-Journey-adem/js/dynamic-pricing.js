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
    
    
    
    updatePrice();
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
        
        
        nbPersonnes.addEventListener('change', updatePrice);
    }
    
    
    const lodgingSelects = document.querySelectorAll('select[id^="lodging-"]');
    
    
    lodgingSelects.forEach(select => {


        select.addEventListener(
            
            'change', 
            
            updatePrice
            
            );
    });
    
    
    const mealsSelects = document.querySelectorAll('select[id^="meals-"]');
    
    
    mealsSelects.forEach(select => {
        
        
        select.addEventListener(
            
            'change', 
            
            updatePrice
            
            );
    });
    
    
    const activitiesSelects = document.querySelectorAll('select[id^="activities-"]');
    
    
    activitiesSelects.forEach(select => {
        
        
        select.addEventListener(
            
            'change', 
            
            updatePrice
            
            );
    });
    
    
    const transportSelects = document.querySelectorAll('select[id^="transport-"]');
    
    
    transportSelects.forEach(select => {


        select.addEventListener(
            
            'change', 
            
            updatePrice
            
            );
    });
}



function updatePrice() {
    
    
    let basePrice = getBasePrice();
    
    
    let totalPrice = basePrice;
    
    
    const nbPersonnes = document.getElementById('nb_personnes');
    
    
    const personnesCount = nbPersonnes ? parseInt(nbPersonnes.value) : 1;
    


    const stages = document.querySelectorAll('.stage-card');
    
    
    let stageExtras = 0;
    
    
    stages.forEach((stage, index) => {
        
        
        const lodgingSelect = document.getElementById(`lodging-${index}`);
        
        
        if (lodgingSelect) {
            
            const lodgingValue = parseInt(lodgingSelect.value);
            
            
            
            switch (lodgingValue) {
                
                
                case 1: 
                    
                    break; 
                
                
                case 2: 
                    
                    stageExtras += 50 * personnesCount; 
                    
                    break;
                
                
                case 3: 
                    
                    stageExtras += 120 * personnesCount; 
                    
                    break;
                
                
                case 4: 
                    
                    stageExtras += 200 * personnesCount; 
                    
                    break;
            }
        }
        
        
        
        const mealsSelect = document.getElementById(`meals-${index}`);
        
        
        if (mealsSelect) {
            
            
            const mealsValue = parseInt(mealsSelect.value);
            
            
            
            switch (mealsValue) {
                
                
                case 1: 
                    
                    break; 
                
                
                case 2: 
                    
                    stageExtras += 25 * personnesCount; 
                    
                    break;
                
                
                case 3: 
                    
                    stageExtras += 50 * personnesCount; 
                    
                    break;
                
                
                case 4: 
                    
                    stageExtras += 80 * personnesCount; 
                    
                    break;
            }
        }
        
        
        
        const activitiesSelect = document.getElementById(`activities-${index}`);
        
        
        if (activitiesSelect) {
            
            
            const activitiesValue = parseInt(activitiesSelect.value);
            
            
            
            switch (activitiesValue) {
                
                
                case 1: 
                    
                    break; 
                
                
                case 2: 
                    
                    stageExtras += 40 * personnesCount; 
                    
                    break;
                
                
                case 3: 
                    
                    stageExtras += 80 * personnesCount; 
                    
                    break;
                
                
                case 4: 
                    
                    stageExtras += 150 * personnesCount; 
                    
                    break;
            }
        }
        
        
        
        const transportSelect = document.getElementById(`transport-${index}`);
        
        
        if (transportSelect) {
            
            
            const transportValue = parseInt(transportSelect.value);
            
            
            
            switch (transportValue) {
                
                
                case 1: 
                    
                    break; 
                
                
                case 2: 
                    
                    stageExtras += 25 * personnesCount; 
                    
                    break;
                
                
                case 3: 
                    
                    stageExtras += 60 * personnesCount; 
                    
                    break;
                
                
                case 4: 
                    
                    stageExtras += 100 * personnesCount; 
                    
                    break;
            }
        }
    });
    
    
    
    totalPrice = basePrice + stageExtras;
    
    
    
    if (personnesCount > 1) {
        
        
        totalPrice = basePrice * personnesCount * 0.9 + stageExtras;
    }
    
    
    
    updatePriceDisplay(totalPrice);
    
    
    
    return totalPrice;
}



function updatePriceDisplay(price) {
    
    
    const priceDisplay = document.querySelector('.price-display');
    
    
    
    if (priceDisplay) {
        
        
        priceDisplay.innerHTML = `
            <span class="price">${price.toLocaleString('fr-FR')} €</span>
            <span class="price-per-person">soit ${Math.round(price / (document.getElementById('nb_personnes') ? parseInt(document.getElementById('nb_personnes').value) : 1)).toLocaleString('fr-FR')} € par personne</span>
        `;
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
    
    
    
    summaryHTML += `
        <div class="summary-price">
            <p>Prix total: <strong>${updatePrice().toLocaleString('fr-FR')} €</strong></p>
        </div>
    `;
    
    
    
    summaryDiv.innerHTML = summaryHTML;
    
    
    
    return summaryDiv;
}