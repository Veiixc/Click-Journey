document.addEventListener('DOMContentLoaded',     function() {
    
    addDarkModeStylesheet();
    addFontAwesome();
    
    createThemeToggleButtons();
    
    


    
    applyThemeFromCookie();


});



function createThemeToggleButtons() {

    const lightToggle = document.createElement('button');
    
    lightToggle.className = 'theme-toggle light-toggle';
    
    
    lightToggle.innerHTML = '<i class="fas fa-sun"></i> Mode clair';
    
    lightToggle.setAttribute('aria-label', 'Activer le mode clair');
    
    
    lightToggle.addEventListener('click', activateLightMode);
    
    



    const darkToggle = document.createElement('button');
    darkToggle.className = 'theme-toggle dark-toggle';
    
    darkToggle.innerHTML = '<i class="fas fa-moon"></i> Mode sombre';
    
    
    darkToggle.setAttribute('aria-label', 'Activer le mode sombre');
    darkToggle.addEventListener('click',     activateDarkMode);
    
    
    const accessibilityToggle = document.createElement('button');
    
    
    accessibilityToggle.className = 'accessibility-toggle';
    accessibilityToggle.innerHTML = '<i class="fas fa-universal-access"></i> Mode accessibilité';
    
    
    accessibilityToggle.setAttribute('aria-label', 'Activer le mode accessibilité');
    accessibilityToggle.addEventListener('click',    activateAccessibilityMode);
    
    
    
    const headerLinks = document.querySelector('.header-links');


    if (headerLinks) {




        headerLinks.appendChild(lightToggle);
        
        
        headerLinks.appendChild(darkToggle);
        
        
        headerLinks.appendChild(accessibilityToggle);
    }

}


function activateLightMode() {
    
    const body = document.body;
    
    
    body.classList.remove('dark-mode');
    
    
    body.classList.remove('accessibility-mode');
    
    
    updateButtonsHighlight('light');
    
    
    setThemeCookie('light');

}


function activateDarkMode() {
    
    
    const body = document.body;
    
    
    
    body.classList.remove('accessibility-mode');
    
    
    
    body.classList.add('dark-mode');
    
    
    
    updateButtonsHighlight('dark');
    
    setThemeCookie('dark');

}


function activateAccessibilityMode() {
    
    
    const body = document.body;
    
    
    
    body.classList.remove('dark-mode');
    
    
    
    body.classList.add('accessibility-mode');
    
    
    
    updateButtonsHighlight('accessibility');
    
    setThemeCookie('accessibility');

}



function updateButtonsHighlight(activeMode) {
    
    
    const lightToggle = document.querySelector('.light-toggle');
    
    const darkToggle = document.querySelector('.dark-toggle');





    
    const accessibilityToggle = document.querySelector('.accessibility-toggle');
    
    
    
    if (lightToggle) lightToggle.classList.remove('active');
    
    if (darkToggle) darkToggle.classList.remove('active');
    
    if (accessibilityToggle) accessibilityToggle.classList.remove('active');
    
    
    
    if (activeMode === 'light' && lightToggle) {
        
        lightToggle.classList.add('active');
        
    } else if (activeMode === 'dark' && darkToggle) {
        
        darkToggle.classList.add('active');
        
    } else if (activeMode === 'accessibility' && accessibilityToggle) {
        
        accessibilityToggle.classList.add('active');
        
    }

}


function setThemeCookie(theme) {
    
    





    const expiryDate = new Date();
    
    
expiryDate.setDate(expiryDate.getDate() + 30);
    
    
    
    document.cookie = `theme=${theme}; expires=${expiryDate.toUTCString()}; path=/; SameSite=Lax`;

}


function getThemeCookie() {
    
    
    const cookies = document.cookie.split(';');
    
    
    
    for (let cookie of cookies) {
        
        const [name, value] = cookie.trim().split('=');
        
        
        
        if (name === 'theme') {
            
            return value;
            
        }
        
    }
    
    return null;

}


function applyThemeFromCookie() {
    
    
    const theme = getThemeCookie() || 'light';
    
    
    
    if (theme === 'dark') {
        
        document.body.classList.add('dark-mode');
        
        updateButtonsHighlight('dark');
        
    } else if (theme === 'accessibility') {
        
        document.body.classList.add('accessibility-mode');
        
        updateButtonsHighlight('accessibility');
        
    } else {
        
        
        
        updateButtonsHighlight('light');
        
    }

}


function addDarkModeStylesheet() {
    // Vérifier si la feuille de style n'est pas déjà chargée
    if (!document.getElementById('dark-mode-stylesheet')) {
        const darkModeLink = document.createElement('link');
        darkModeLink.rel = 'stylesheet';
        
        // Détecter le niveau du répertoire
        const path = window.location.pathname;


        let cssPath = '../css/dark-mode.css';
        
        // Si nous sommes dans un sous-dossier comme circuits ou admin
        if (path.includes('/circuits/') || path.includes('/admin/')) {
            cssPath = '../../css/dark-mode.css';
        }
        // Si nous sommes à la racine du site
        else if (path.endsWith('/') || path.endsWith('.php') && !path.includes('/html/')) {
            cssPath = 'css/dark-mode.css';
        }
        
        darkModeLink.href = cssPath;
        darkModeLink.id = 'dark-mode-stylesheet';
        
        document.head.appendChild(darkModeLink);
    }
}

function addFontAwesome() {
    // Vérifier si Font Awesome n'est pas déjà chargé
    const fontAwesomeExists = Array.from(document.querySelectorAll('link')).some(
        link => link.href && link.href.includes('font-awesome')
    );
    
    if (!fontAwesomeExists) {




        const fontAwesomeLink = document.createElement('link');
        fontAwesomeLink.rel = 'stylesheet';
        fontAwesomeLink.href = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css';
        
        document.head.appendChild(fontAwesomeLink);
    }
}