document.addEventListener('DOMContentLoaded',    function() { // Attendre que le DOM soit complètement chargé
    const successMessage =     document.querySelector('.success-message'); // Recherche un message de succès existant dans la page
    
if (successMessage) { // Si un message de succès existe
        const notification = document.createElement(  'div'  ); // Crée un nouvel élément div pour la notification
        notification.className =    'notification'; // Applique la classe CSS notification pour le style
        notification.textContent = successMessage.textContent.trim( // Utilise le texte du message de succès, sans espaces superflus

        );
        
    document.body.appendChild(   notification   ); // Ajoute la notification à la page
        
        successMessage.style.display =      'none'; // Cache le message de succès original
        
        setTimeout(  function() { // Configure un délai pour supprimer la notification
            notification.remove( // Supprime la notification après 3 secondes

            );
        }, 
        
        3000); // Durée d'affichage de 3 secondes
    }
}   
); 