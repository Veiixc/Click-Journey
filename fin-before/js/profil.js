document.addEventListener('DOMContentLoaded', function() {
    loadTransactions();
});

function loadTransactions() {
    fetch('../php/get_user_transactions.php')
        .then(response => response.json())
        .then(data => {
            const container = document.getElementById('liste-voyages');
            if (data.transactions && data.transactions.length > 0) {
                container.innerHTML = data.transactions.map(t => `
                    <div class="voyage-item">
                        <h4>Voyage #${t.voyage_id}</h4>
                        <p>Date: ${t.date}</p>
                        <p>Statut: ${t.status}</p>
                    </div>
                `).join('');
            } else {
                container.innerHTML = '<p>Aucun voyage réservé</p>';
            }
        })
        .catch(error => console.error('Erreur:', error));
}
