document.addEventListener('DOMContentLoaded', function() {
    // Auto-focus entre les champs de la carte bancaire
    const cardInputs = document.querySelectorAll('.card-number-inputs input');
    
    cardInputs.forEach((input, index) => {
        input.addEventListener('input', function() {
            if (this.value.length === 4 && index < cardInputs.length - 1) {
                cardInputs[index + 1].focus();
            }
        });

        // Permettre uniquement les chiffres
        input.addEventListener('keypress', function(e) {
            if (!/\d/.test(e.key)) {
                e.preventDefault();
            }
        });
    });

    // Formatage du CVV
    const cvvInput = document.getElementById('cvv');
    cvvInput.addEventListener('keypress', function(e) {
        if (!/\d/.test(e.key)) {
            e.preventDefault();
        }
    });
});
