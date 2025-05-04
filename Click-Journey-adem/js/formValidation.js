document.addEventListener(

    'DOMContentLoaded', 

    () => {
    
    const constraints = {
        
        
        login: {


            minLength: 3,
            
            
            maxLength: 50,
            
            
            pattern: /^[a-zA-Z0-9_-]+$/,
            
            
            message: 'Veuillez saisir un login valide (lettres, chiffres, - et _)'
        },
        
        
        password: {
            
            
    minLength: 8,
            
            
      maxLength: 50,
            
            
     pattern: /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d@$!%*#?&]{8,}$/,
            
            
          message: 'Veuillez saisir un mot de passe valide (8 caractères minimum avec lettres et chiffres)'
        },
        
        
        email: {
            
            
            maxLength: 100,
            
            
            pattern: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
            
            
            message: 'Veuillez saisir une adresse email valide'
        },


        telephone: {
            
            
         pattern: /^[0-9]{10}$/,
            
            
            message: 'Veuillez saisir un numéro de téléphone valide (10 chiffres)'
        },
        
        
        nom: {
            
            
        minLength: 2,
           
          
            maxLength: 100,
            
            
        pattern: /^[a-zA-ZÀ-ÿ\s-]+$/,
            
            
            message: 'Veuillez saisir un nom valide'
        },
        
        
        prenom: {


            minLength: 2,
            
            
            maxLength: 100,
            
            
            pattern: /^[a-zA-ZÀ-ÿ\s-]+$/,
            
            
            message: 'Veuillez saisir un prénom valide'
        }
    };
    
    
    
    const addCharCounter = (input) => {
        
        
        if (!input) return;
        
        
        
        const existingCounter = input.parentNode.querySelector('.char-counter');
        
        
        if (existingCounter) {
            
            
            existingCounter.remove();
        }
        
        
        const counter = document.createElement('div');
        
        
   counter.className = 'char-counter';
        
        
     input.parentNode.insertBefore(counter, input.nextSibling);
        
        
        const updateCounter = () => {
            
            
            counter.textContent = `${input.value.length}/${input.maxLength} caractères`;
        };
        
        
       input.addEventListener('input', updateCounter);



        updateCounter();
    };


    
    const addPasswordToggle = (input) => {
        
        
        if (!input || input.type !== 'password') return;
        


        
    const existingToggle = input.parentNode.querySelector('.toggle-password');
        
        
        if (existingToggle) {
            
            
            existingToggle.remove();
        }
        
        
        const toggleBtn = document.createElement('button');
        
        
        toggleBtn.type = 'button';
        
        
     toggleBtn.className = 'toggle-password';
        
        
        toggleBtn.innerHTML = '👁️';
        
        
        input.parentNode.appendChild(toggleBtn);
        
        
        toggleBtn.addEventListener('click', (e) => {


            e.preventDefault();
            
            
            const type = input.type === 'password' ? 'text' : 'password';
            
            
            input.type = type;
            
            
            toggleBtn.innerHTML = type === 'password' ? '👁️' : '👁️‍🗨️';
        });
    };


    

    const validateField = (input) => {
        
        
        const constraint = constraints[input.id];
        
        
        if (!constraint) return true;

        
        
        let isValid = true;
        
        
        let errorMessage = '';


        
        if (input.required && !input.value.trim()) {
            
            
            isValid = false;
            
            
            errorMessage = 'Veuillez remplir ce champ....';
        }
        
        else if (constraint.minLength && input.value.length < constraint.minLength) {
            
            
            
            isValid = false;
            
            
            errorMessage = `Minimum ${constraint.minLength} caractères requis...`;
        }
        
        else if (constraint.pattern && !constraint.pattern.test(input.value) && input.value.trim()) {
            
            
            isValid = false;
            
            
            
            errorMessage = constraint.message || 'Format invalide';
        }
        
        
        
        
        if (input.id === 'confirm_password') {
            
            
            const passwordInput = document.getElementById('password');
            
            
            if (passwordInput && input.value !== passwordInput.value) {
                
                
                isValid = false;
                
                
                errorMessage = 'Les mots de passe ne correspondent pas';
            }
        }
        
        
        
        updateFieldValidationUI(input, isValid, errorMessage);
        
        
        return isValid;
    };
    
    
    

    const updateFieldValidationUI = (input, isValid, errorMessage) => {
        
        
        
        const fieldWrapper = input.parentNode;
        
        
        
        let errorElement = fieldWrapper.querySelector('.error-message');
        
        
        
        if (!errorElement && !isValid) {
            
            
            errorElement = document.createElement('div');
            
            
            errorElement.className = 'error-message';
            
            
            fieldWrapper.appendChild(errorElement);
        }
        
        
        
        
        if (errorElement) {
            
            
            if (isValid) {
                
                
                errorElement.remove();
            } else {
                
                
                errorElement.textContent = errorMessage;
            }
        }
        
        
        
        
        
        input.classList.toggle('is-invalid', !isValid);
        
        
        input.classList.toggle('is-valid', isValid && input.value.trim() !== '');
    };
    
    
    
    

    const validateForm = (form) => {
        
        
        const inputs = form.querySelectorAll('input, select, textarea');
        
        
        
        let formIsValid = true;
        
        
        
        inputs.forEach(input => {
            
            
            const fieldIsValid = validateField(input);
            
            
            if (!fieldIsValid) {
                
                
                formIsValid = false;
            }
        });
        
        
        
        if (!formIsValid) {
            
            
            const firstInvalidField = form.querySelector('.is-invalid');
            
            
            if (firstInvalidField) {
                
                
                firstInvalidField.focus();
            }
        }
        
        
        

        return formIsValid;
    };
    
    
    
    
    const initFormField = (input) => {
        
        
        
        
        if (input.getAttribute('maxlength')) {
            
            
            addCharCounter(input);
        }
        
        
        
        if (input.type === 'password') {
            
            
            addPasswordToggle(input);
        }
        
        
        
        
        
        input.addEventListener('blur', () => validateField(input));
        
        
        
        input.addEventListener('input', () => {
            
            
            
            if (input.classList.contains('is-invalid')) {
                
                
                validateField(input);
            }
        });
    };
    
    
    
    
    
    
    const showFormSubmitStatus = (form, isSuccess, message) => {
        
        
        
        let statusElement = form.parentNode.querySelector('.form-status');
        
        
        
        if (!statusElement) {
            
            
            statusElement = document.createElement('div');
            
            
            statusElement.className = 'form-status';
            
            
            form.parentNode.insertBefore(statusElement, form.nextSibling);
        }
        
        
        
        statusElement.textContent = message;
        
        
        statusElement.className = `form-status ${isSuccess ? 'success' : 'error'}`;
        
        
        
        
        setTimeout(() => {
            
            
            statusElement.classList.add('form-status-visible');
        }, 10);
        
        
        
        setTimeout(() => {
            
            
            statusElement.classList.remove('form-status-visible');
            
            
            
            setTimeout(() => {
                
                
                if (isSuccess) {
                    
                    
                    statusElement.remove();
                }
            }, 400);
        }, 5000);
    };
    
    
    
    
    
    const initForms = () => {
        
        
        document.querySelectorAll('form').forEach(form => {
            
            
            
            form.querySelectorAll('input, select, textarea').forEach(input => {
                
                
                initFormField(input);
            });
            
            
            
            
            form.addEventListener('submit', function (e) {
                
                
                if (!validateForm(form)) {
                    
                    
                    e.preventDefault();
                    
                    
                    return false;
                }
                
                
                
                if (form.id === 'registration-form' || form.id === 'contact-form') {
                    
                    
                    e.preventDefault();
                    
                    
                    
                    const formData = new FormData(form);
                    
                    
                    
                    const actionUrl = form.getAttribute('action');
                    
                    
                    const submitBtn = form.querySelector('button[type="submit"]');
                    
                    
                    
                    submitBtn.disabled = true;
                    
                    
                    submitBtn.innerHTML = '<span class="spinner"></span> Traitement...';
                    
                    
                    
                    fetch(actionUrl, {
                        
                        
                        method: 'POST',
                        
                        
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        
                        
                        submitBtn.disabled = false;
                        
                        
                        submitBtn.innerHTML = 'Envoyer';
                        
                        
                        
                        if (data.success) {
                            
                            
                            showFormSubmitStatus(form, true, data.message || 'Opération réussie!');
                            
                            
                form.reset();
                            
                            
                            
           if (form.id === 'registration-form') {
                                
                                
                                
         setTimeout(() => {
                                    
                                    
              window.location.href = 'login.php';
                                }, 2000);
                            }
                        } else {
                            
                            
                            showFormSubmitStatus(form, false, data.message || 'Une erreur est survenue');
                        }
                    })
                    .catch(error => {
                        
                        
                        console.error('Erreur:', error);
                        
                        
                        submitBtn.disabled = false;
                        
                        
                        submitBtn.innerHTML = 'Envoyer';
                        
                        
                        
                        showFormSubmitStatus(form, false, 'Une erreur est survenue avec le serveur');
                    });
                }
            });
        });
    };
    
    
    
    
    
    initForms();
});