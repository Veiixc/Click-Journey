document.addEventListener(  'DOMContentLoaded',   function(  ) {
 let addedToCart       = false;
    let  circuitId  = document.querySelector(  'input[name="circuit_id"]'    ).value;
    let      modificationTimeout;
    
    const     formElements  = document.querySelectorAll (  'input, select'    );
    
    function      showCartNotification(      ) {
   if   (    !document.getElementById('cart-notification')   ) {
       const   notification = document.createElement(  'div'  );
         notification.id       = 'cart-notification';
            notification.className    = 'notification';




     notification.innerHTML  =   'Circuit ajouté à votre panier.<br><small>Vos modifications sont automatiquement sauvegardées.</small>';
  document.body.appendChild(  notification  );
            









      setTimeout(   function(   ) {
               notification.classList.add(  'fade-out'  );
                setTimeout(  function( ) {
                    notification.remove(  );
                 }, 500  );
            }, 5000    );
        }
    }
    
   function    updateCartState(  ) {
        if   ( modificationTimeout   ) {
            clearTimeout(    modificationTimeout   );
        }
        
        modificationTimeout  =   setTimeout(  function(  ) {
       const      formData    = new FormData(  document.querySelector( 'form'   ));
            
        fetch(  '../php/cart/auto_save_cart.php'  , {
               method:    'POST',
             body:    formData
            }  )
            .then(  response  =>   response.json()   )
            .then(   data  => {
                if (  data.success   &&  !addedToCart    ) {
                    addedToCart   =   true;
                   showCartNotification(    );
                }
            }  )
            .catch(  error   =>  console.error(  'Erreur lors de la sauvegarde automatique:',    error  ));
        },    1000   );
    }
    
  formElements.forEach(   element    => {
      element.addEventListener( 'change'  ,   function(   ) {
            if (    !addedToCart   ) {
                const    xhr = new XMLHttpRequest(     );
               xhr.open(   'GET',  `../php/cart/add_to_cart.php?circuit_id=${circuitId}&auto=1`,   true   );
               xhr.onload  =  function(  ) {




                
                  if   (   xhr.status  ===    200  ) {
                        addedToCart    =    true;
                       showCartNotification(   );
                    }
              };
                xhr.send(  );
            } else   {
               updateCartState(   );
            }
        }  );






        
        if (   element.tagName   ===  'INPUT'   &&    element.type  !==  'hidden'  ) {
           element.addEventListener(   'input',    updateCartState   );
        }
    }  );
});