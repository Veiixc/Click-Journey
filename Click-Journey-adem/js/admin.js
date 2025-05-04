document.addEventListener(  'DOMContentLoaded',     function() {
    const actionButtons =     document.querySelectorAll('.btn-vip, .btn-bannir');
    
    actionButtons.forEach(   button => {
        button.addEventListener(  'click',  function(e) {
            e.preventDefault();
            
      const originalText = this.textContent;
            const isVipButton       = this.classList.contains('btn-vip');
            
        this.disabled = true;
                  this.classList.add('processing');
            this.textContent  =  isVipButton ? 'Traitement en cours...' : 'Traitement en cours...';
            
            setTimeout( () => {
                this.disabled   =   false;
                this.classList.remove(   'processing');
                
              if (isVipButton) {
                    const newStatus = this.textContent.includes('Retirer')     ? 'Rendre VIP' : 'Retirer VIP';
                    this.textContent     =     newStatus;
                } else {
             const newStatus     = this.textContent.includes('Débannir') ? 'Bannir Utilisateur' : 'Débannir Utilisateur';
                    this.textContent = newStatus;
                }
                
     showNotification(    'Modification appliquée avec succès!');
            },    3000);
        });
    });
    
    function  showNotification( message) {
     let notification =      document.getElementById('admin-notification');
        if    (!notification) {
        notification   = document.createElement('div');
            notification.id    =     'admin-notification';
     notification.className  =     'notification';
            document.body.appendChild(notification);
        }



        
        
    notification.textContent    =    message;
       notification.classList.add(    'show');
        
      setTimeout(      () => {
          notification.classList.remove(   'show');
        },    3000);
    }
});