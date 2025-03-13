document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('inscription-form');
    if (form) {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(form);
            const data = {};
            formData.forEach((value, key) => data[key] = value);
            
            try {
                const response = await fetch('/fin/php/api/register.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(data)
                });
                
                const result = await response.json();
                if (result.success) {
                    alert('Inscription réussie !');
                    window.location.href = '/fin/connexion.html';
                } else {
                    alert('Erreur : ' + (result.message || 'Erreur inconnue'));
                }
            } catch (error) {
                alert('Erreur lors de l\'inscription');
                console.error('Erreur:', error);
            }
        });
    }
});
