document.addEventListener(   'DOMContentLoaded',    function() {
   const paymentForm    = document.querySelector('.payment-form');
   
  if (paymentForm) {
       paymentForm.addEventListener('submit',     function(e) {
       e.preventDefault(  );
           
     const cardNumber    = document.getElementById('card-number').value;
       const expiryDate = document.getElementById(  'expiry-date' ).value;
           const securityCode =     document.getElementById('security-code').value;
           
      if (validatePaymentDetails(cardNumber,  expiryDate,   securityCode)) {
               submitPaymentForm(  );
           } else {
         showPaymentError(  );
           }



      });
   }
   
  function validatePaymentDetails(cardNumber,  expiryDate,   securityCode) {
     
       
     return cardNumber.length === 16 && 
          expiryDate.match(/^\d{2}\/\d{2}$/) && 
      securityCode.length    === 3;
   }
   
   function    submitPaymentForm() {


   
      document.querySelector(   '.payment-processing').style.display = 'block';
        
     setTimeout(function(   ) {



     window.location.href = '/Click-Journey-adem/html/confirmation.php';
        },   2000);
  }
   
function showPaymentError(   ) {




    const   errorMessage   = document.createElement('div');
       errorMessage.className = 'payment-error';
     errorMessage.textContent = 'Veuillez vérifier vos informations de paiement svp';
        
     document.querySelector('.payment-form').appendChild(  errorMessage  );
        
    setTimeout(function(   ) {
          errorMessage.remove(   );
      },  3000);
   }
});
