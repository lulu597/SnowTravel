document.addEventListener("DOMContentLoaded", function () {
    const filtreType = document.getElementById('filtre-type');
    const filtreContinent = document.getElementById('continent-filtre');
    const searchInput = document.querySelector('.filtre[type="text"], .input-trip');
    const sortPrice = document.getElementById('sort-price');
    const trips = Array.from(document.querySelectorAll('.image-destination'));
    const container = document.querySelector('.bloc-liste');

    // Charger les valeurs précédemment sauvegardées dans le localStorage
    const savedType = localStorage.getItem('filtre-type');
    const savedContinent = localStorage.getItem('filtre-continent');
    const savedSearchTerm = localStorage.getItem('search-term');
    const savedSortPrice = localStorage.getItem('sort-price');

    if (savedType) filtreType.value = savedType;
    if (savedContinent) filtreContinent.value = savedContinent;
    if (savedSearchTerm) searchInput.value = savedSearchTerm;
    if (savedSortPrice) sortPrice.value = savedSortPrice;

    // Fonction pour appliquer les filtres
    function filtre() {
        const selectedType = filtreType.value;
        const selectedContinent = filtreContinent.value;
        const searchTerm = searchInput.value.trim().toLowerCase();
        const sortOrder = sortPrice.value;

        let filtrer = trips.slice();

        // Sauvegarder l'état actuel dans le localStorage
        localStorage.setItem('filtre-type', selectedType);
        localStorage.setItem('filtre-continent', selectedContinent);
        localStorage.setItem('search-term', searchTerm);
        localStorage.setItem('sort-price', sortOrder);

        // Filtrage par type
        if (selectedType) {
            filtrer = filtrer.filter(trip => trip.dataset.type === selectedType);
        }

        // Filtrage par continent
        if (selectedContinent) {
            filtrer = filtrer.filter(trip => trip.dataset.continent === selectedContinent);
        }

        // Recherche par nom
        if (searchTerm) {
            filtrer = filtrer.filter(trip => {
                const name = trip.querySelector('.hover-text')?.textContent.toLowerCase();
                return name && name.includes(searchTerm);
            });
        }

        // Tri par prix
        if (sortOrder) {
            filtrer.sort((a, b) => {
                const priceA = parseFloat(a.dataset.price);
                const priceB = parseFloat(b.dataset.price);
                return sortOrder === 'asc' ? priceA - priceB : priceB - priceA;
            });
        }

        // Mise à jour de la liste affichée
        container.innerHTML = "";
        if (filtrer.length === 0) {
            const noResultsMessage = document.createElement('p');
            noResultsMessage.textContent = "Aucun voyage trouvé.";
            container.appendChild(noResultsMessage);
        } else {
            filtrer.forEach(trip => container.appendChild(trip));
        }
    }

    // Écouteurs d'événements pour appliquer les filtres
    filtreType.addEventListener('change', filtre);
    filtreContinent.addEventListener('change', filtre);
    searchInput.addEventListener('input', filtre);
    sortPrice.addEventListener('change', filtre);

    // Appliquer les filtres dès le chargement de la page
    filtre();
});