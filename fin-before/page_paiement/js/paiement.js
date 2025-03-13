document.addEventListener('DOMContentLoaded', function() {
    // Auto-focus entre les champs de carte
    const cardInputs = document.querySelectorAll('.card-input');
    cardInputs.forEach((input, index) => {
        input.addEventListener('input', function() {
            if (this.value.length === 4 && index < cardInputs.length - 1) {
                cardInputs[index + 1].focus();
            }
        });
    });

    // Validation numérique
    document.querySelectorAll('input[type="text"]').forEach(input => {
        if (input.classList.contains('card-input') || input.name === 'cvv') {
            input.addEventListener('input', function() {
                this.value = this.value.replace(/\D/g, '');
            });
        }
    });

    // Chargement des détails du voyage
    loadVoyageDetails();
});

function loadVoyageDetails() {
    const urlParams = new URLSearchParams(window.location.search);
    const voyageId = urlParams.get('voyage_id');
    
    if (voyageId) {
        fetch(`../php/get_voyage_details.php?id=${voyageId}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('voyage-details').innerHTML = `
                    <p><strong>Titre:</strong> ${data.title}</p>
                    <p><strong>Date de début:</strong> ${data.start_date}</p>
                    <p><strong>Date de fin:</strong> ${data.end_date}</p>
                    <p><strong>Prix total:</strong> ${data.total_price}€</p>
                `;
            })
            .catch(error => console.error('Erreur:', error));
    }
}
