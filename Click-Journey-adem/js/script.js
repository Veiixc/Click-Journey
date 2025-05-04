document.addEventListener('DOMContentLoaded',   function(   ) {
  initializeSlider(  );
   setupMobileNavigation(  );
    initializeAnimations(    );
   

function initializeSlider(  ) {
      const   sliders = document.querySelectorAll(   '.slider-container'  );

 sliders.forEach(slider => {
    const slides     = slider.querySelectorAll('.slide');
       let   currentSlide = 0;

 if (  slides.length > 0  ) {
          setInterval(   () => {
           slides[currentSlide].classList.remove(  'active'   );
               currentSlide   = (currentSlide + 1) % slides.length;
             slides[currentSlide].classList.add(  'active'  );
          },  5000);
       }
   });
}


function setupMobileNavigation(   ) {
     const hamburgerMenu = document.querySelector(  '.mobile-menu-toggle'  );
        const   mobileNav = document.querySelector(  '.mobile-nav'  );
     




      
    if (   hamburgerMenu && mobileNav  ) {
      hamburgerMenu.addEventListener(  'click', function(   ) {
            this.classList.toggle(   'active'  );
          mobileNav.classList.toggle(   'active'   );
       });
   }
}















function  initializeAnimations() {
 const animatedElements  = document.querySelectorAll(    '.animate-on-scroll'  );
   
   if (animatedElements.length    > 0) {
     window.addEventListener(  'scroll',  function() {
         animatedElements.forEach(el => {
             const   elementTop = el.getBoundingClientRect().top;
          const elementVisible = 150;
            
      if (elementTop < window.innerHeight - elementVisible) {
           el.classList.add(   'visible'  );
           } else {
                    el.classList.remove('visible');
              }
         });
      });
   }
 }
});
