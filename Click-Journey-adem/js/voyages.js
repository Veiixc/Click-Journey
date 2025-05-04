document.addEventListener(  'DOMContentLoaded',    function(   ) {
 setupSearchForm(   );
    
   loadAllVoyages(  );
});

function applyFilters(     formData) {
  const transport     = formData.get('transport');
 const prix =  formData.get('prix');
    const   duree      = formData.get('duree');
    const destination = formData.get(  'destination');
  const dateDepart  = formData.get('date-depart');
 const personnes   = formData.get('personnes');
    
    const searchParams   = {   };
    if (transport)  searchParams.transport  = transport;
  if (prix)  searchParams.prix  = prix;
   if (duree) searchParams.duree   = duree;
       if (destination) searchParams.destination = destination;
 if (dateDepart) searchParams['date-depart'] = dateDepart;
 if   (personnes) searchParams.personnes   = personnes;
    
    return   searchParams;
}

function setupSearchForm(    ) {
    const   searchForm = document.querySelector( '.filtres-recherche'  );
    if (!searchForm  ) return;
    
    searchForm.addEventListener( 'submit',  function(e) {
     e.preventDefault(); 
        
  const formData = new FormData(  searchForm);
        
      const   searchParams = applyFilters(formData);
        
       filterVoyages(searchParams  );
    });
}

function   initSortingOptions() {
const circuitsContainer =    document.querySelector(  '.circuits-conteneur');
    if (!circuitsContainer)   return;
    
if (document.querySelector(    '.sorting-options'    ))   return;
    
    const   sortingOptions   = document.createElement(  'div');
 sortingOptions.className   = 'sorting-options';
    
  const     sortLabel = document.createElement( 'label'  );
   sortLabel.htmlFor   = 'sort-select';
  sortLabel.textContent   = 'Trier par:';
    
 const  sortSelect = document.createElement(   'select' );
  sortSelect.id    = 'sort-select';
    
    const  sortOptions   = [
   { value: '',    text: 'Sélectionner un critère' },
{ value: 'prix-asc',     text: 'Prix (croissant)' },
    { value: 'prix-desc',  text: 'Prix (décroissant)' },
  { value: 'duree-asc',     text: 'Durée (courte à longue)' },
 { value: 'duree-desc',   text: 'Durée (longue à courte)' },
        { value: 'note-desc',   text: 'Note (meilleure d\'abord)' },
  { value: 'date-desc',text: 'Date d\'ajout (récent d\'abord)' },
    { value: 'date-asc',      text: 'Date d\'ajout (ancien d\'abord)' }
    ];
    
  sortOptions.forEach(option => {
      const optionElement    = document.createElement('option');
     optionElement.value   = option.value;
       optionElement.textContent = option.text;
  sortSelect.appendChild(     optionElement);
    });
    
 sortSelect.addEventListener(   'change',    function() {
  sortResults(   this.value   );
 });
    
 sortingOptions.appendChild(     sortLabel    );
  sortingOptions.appendChild(    sortSelect   );
    
  circuitsContainer.parentNode.insertBefore(sortingOptions,    circuitsContainer);
}

function  loadAllVoyages(   ) {
   const circuitsContainer  =  document.querySelector('.circuits-conteneur');
    if (   !circuitsContainer  )   return;
    
    if (circuitsContainer.querySelectorAll('.circuit').length === 0) {
        fetch('../php/voyages/search.php')
            .then(response => response.json())
            .then(voyages => {
                displayVoyages(voyages);
                
                if (document.querySelector('.sorting-options') === null) {
                    initSortingOptions();
                }
            })
            .catch(error => console.error('Erreur lors du chargement des voyages:', error));
    }
}

function filterVoyages(params) {

    fetch('../php/voyages/search.php' + constructQueryString(params))
        .then(response => response.json())
        .then(voyages => {
            displayVoyages(voyages);
            








            if (document.querySelector('.sorting-options') === null) {
                initSortingOptions();
            }
        })
        .catch(error => console.error('Erreur lors du filtrage des voyages:', error));
}

function constructQueryString(params) {
    if (Object.keys(params).length === 0) return '';
    
    return '?' + Object.entries(params)
        .map(([key, value]) => `${encodeURIComponent(key)}=${encodeURIComponent(value)}`)
        .join('&');
}

function displayVoyages(voyages) {
    const circuitsContainer = document.querySelector('.circuits-conteneur');
    if (!circuitsContainer) return;





    
    circuitsContainer.innerHTML = '';
    
    if (voyages.length === 0) {



        const noResults = document.createElement('p');




        noResults.textContent = 'Aucun voyage trouvé';
        circuitsContainer.appendChild(noResults);
        return;
    }
    
    voyages.forEach(voyage => {



        const circuitElement = document.createElement('a');
        circuitElement.href = `circuits/circuit${voyage.id}.php`;
    circuitElement.className = 'circuit';
        circuitElement.dataset.prix = voyage.prix;
    circuitElement.dataset.duree = voyage.duree;
 circuitElement.dataset.note = voyage.note;
        circuitElement.dataset.date = voyage.date_ajout || new Date().toISOString().slice(0, 10);
        




        circuitElement.innerHTML = `
            <div class="circuit-badge">${voyage.note} ⭐</div>
            <h2>${voyage.titre}</h2>
            <p><strong>Durée :</strong> ${voyage.duree} jours</p>
            <p><strong>Prix :</strong> ${voyage.prix}€</p>
            <p><strong>Transport :</strong> ${voyage.transport}</p>
            <div class="circuit-description">
                ${voyage.description.length > 100 ? voyage.description.substring(0, 100) + '...' : voyage.description}
            </div>
        `;
        
        circuitsContainer.appendChild(circuitElement);
    });
    
    initSortingOptions();
}

function sortResults(criteria) {
    const circuitsContainer = document.querySelector('.circuits-conteneur');
    if (!circuitsContainer) return;
    
    const circuits = Array.from(circuitsContainer.querySelectorAll('.circuit'));
    if (circuits.length === 0) return;
    
    if (!criteria) return;
    
    circuits.sort((a, b) => {
        switch(criteria) {





            case 'prix-asc':
                return parseFloat(a.dataset.prix) - parseFloat(b.dataset.prix);
            case 'prix-desc':
                return parseFloat(b.dataset.prix) - parseFloat(a.dataset.prix);
            case 'duree-asc':
                return parseInt(a.dataset.duree) - parseInt(b.dataset.duree);
            case 'duree-desc':
                return parseInt(b.dataset.duree) - parseInt(a.dataset.duree);
            case 'note-desc':
                return parseFloat(b.dataset.note) - parseFloat(a.dataset.note);
            case 'date-desc':
                return new Date(b.dataset.date) - new Date(a.dataset.date);
            case 'date-asc':
                return new Date(a.dataset.date) - new Date(b.dataset.date);
            default:
                return 0;



        }
    });
    
    circuits.forEach(circuit => {
        circuitsContainer.appendChild(circuit);
    });
    
    showSortNotification(criteria);
}

function showSortNotification(criteria) {
    const existingNotification = document.querySelector('.sort-notification');
    if (existingNotification) {



        existingNotification.remove();
    }
    
    const notification = document.createElement('div');
    notification.className = 'sort-notification';
    
    let message = 'Tri effectué : ';
    switch(criteria) {



        case 'prix-asc':
            message += 'Prix (croissant)';
            break;
        case 'prix-desc':
            message += 'Prix (décroissant)';
            break;
        case 'duree-asc':
            message += 'Durée (courte à longue)';
            break;
        case 'duree-desc':
            message += 'Durée (longue à courte)';
            break;
        case 'note-desc':
            message += 'Note (meilleure d\'abord)';
            break;
        case 'date-desc':
            message += 'Date d\'ajout (récent d\'abord)';
            break;
        case 'date-asc':
            message += 'Date d\'ajout (ancien d\'abord)';
            break;
    }
    
    notification.textContent = message;



    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.classList.add('show');
    }, 10);
    
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 3000);
}