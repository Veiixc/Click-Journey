document.addEventListener('DOMContentLoaded', function() {
    let currentPage = 1;
    
    function loadUsers(page) {
        fetch(`php/get_users.php?page=${page}`)
            .then(response => response.json())
            .then(data => {
                const tbody = document.querySelector('.table-utilisateurs tbody');
                tbody.innerHTML = '';
                
                data.users.forEach(user => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>
                            <div class="info-utilisateur">
                                <img src="https://placehold.co/40x40" alt="Avatar utilisateur" class="avatar-utilisateur">
                                <div>
                                    ${user[3]}<br>
                                    <span class="email-utilisateur">${user[0]}</span>
                                </div>
                            </div>
                        </td>
                        <td><span class="statut ${user[2] === 'admin' ? 'vip' : 'actif'}">${user[2]}</span></td>
                        <td>${user[7]}</td>
                        <td>
                            <button class="btn btn-vip">${user[2] === 'admin' ? 'Retirer Admin' : 'Rendre Admin'}</button>
                            <button class="btn btn-bannir">Bannir Utilisateur</button>
                        </td>
                    `;
                    tbody.appendChild(tr);
                });

                // Mettre à jour la pagination
                updatePagination(data.pagination);
            })
            .catch(error => console.error('Erreur:', error));
    }

    function updatePagination(pagination) {
        const paginationDiv = document.querySelector('.pagination');
        if (paginationDiv) {
            let html = '';
            for (let i = 1; i <= pagination.totalPages; i++) {
                html += `<button class="page-btn ${i === pagination.currentPage ? 'active' : ''}" 
                        data-page="${i}">${i}</button>`;
            }
            paginationDiv.innerHTML = html;

            // Ajouter les événements de clic
            document.querySelectorAll('.page-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    currentPage = parseInt(this.dataset.page);
                    loadUsers(currentPage);
                });
            });
        }
    }

    // Charger la première page au chargement
    loadUsers(1);
});
