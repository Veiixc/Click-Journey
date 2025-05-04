document.addEventListener('DOMContentLoaded',    function() {
    const successMessage =     document.querySelector('.success-message');
    
if (successMessage) {
        const notification = document.createElement(  'div'  );
        notification.className =    'notification';
        notification.textContent = successMessage.textContent.trim(

        );
        
    document.body.appendChild(   notification   );
        
        successMessage.style.display =      'none';
        
        setTimeout(  function() {
            notification.remove(

            );
        }, 
        
        3000);
    }
}   
); 