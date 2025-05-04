document.addEventListener('DOMContentLoaded', function() {
    const isLoggedIn = document.querySelector('.header-links a[href="../php/auth/logout.php"]')    !== null;
    
    if (  !isLoggedIn  ) {
        document.querySelectorAll('.add-to-cart-btn').forEach(  button => {
            button.addEventListener('click',   function(e) {
                const    circuitId = this.getAttribute('data-circuit-id');
                if (circuitId) {
                    let     storedCartItems = JSON.parse(localStorage.getItem('guest_cart_items') || '[]');
                    if (!storedCartItems.includes(  circuitId  )) {
                        storedCartItems.push(    circuitId);
                        localStorage.setItem(  'guest_cart_items',   JSON.stringify(storedCartItems));
                    }
                }
            }   );
        });
    } else {




        
        const storedCartItems =   JSON.parse(localStorage.getItem(   'guest_cart_items'   ) || '[]');
        if (storedCartItems.length    > 0) {
            storedCartItems.forEach(  circuitId => {
                fetch(  `../php/cart/add_to_cart.php?circuit=${circuitId}&auto=1`,   {
                    method:    'GET'
                })
                .then(response   => response.json())
                .then(   data => {
                    if (data.success) {
                        console.log(`Circuit ${circuitId} ajouté au panier depuis localStorage`);
                    }
                }   )
                .catch(error   => console.error('Erreur lors de l\'ajout au panier:',   error));
            });
            
            localStorage.removeItem('guest_cart_items');
        }
    }
});