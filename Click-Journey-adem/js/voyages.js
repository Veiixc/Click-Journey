document.addEventListener('DOMContentLoaded', function() {
    fetch('../php/voyages/get_featured.php')
        .then(response => response.json())
        .then(voyages => {
            const container = document.getElementById('voyages-recommandes');
            
            voyages.forEach(voyage => {
                const voyageElement = document.createElement('a');
                voyageElement.href = `circuits/circuit${voyage.id}.php`;
                voyageElement.className = 'circuit';
                
                voyageElement.innerHTML = `
                    <div class="circuit-badge ${voyage.note >= 4.7 ? 'best-rated' : ''}">${voyage.note} ⭐</div>
                    <h2>${voyage.titre}</h2>
                    <p>Durée : ${voyage.duree} jours</p>
                    <p>Prix : ${voyage.prix}€</p>
                    <p>Transport : ${voyage.transport}</p>
                    <p class="circuit-description">${voyage.description}</p>
                `;
                
                container.appendChild(voyageElement);
            });
        })
        .catch(error => console.error('Erreur:', error));
});
