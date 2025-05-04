document.addEventListener("DOMContentLoaded", function () {
    const formulaire = document.getElementById("formulaire");
    const total = document.getElementById("prix");

    function extrairePrix(label) {
        const texte = label.textContent || "";
        const match = texte.match(/(\d+)\s*€/); // extrait "123 €"
        return match ? parseInt(match[1]) : 0;
    }

    function calculerPrix() {
        let somme = 0;

        // 1. Récupérer le nombre de voyageurs
        const inputVoyageurs = document.getElementById("nombre");
        const nbVoyageurs = inputVoyageurs ? parseInt(inputVoyageurs.value) || 1 : 1;

        // 2. Calculer la durée en jours
        const dateDepart = new Date(document.getElementById("depart")?.value);
        const dateArrivee = new Date(document.getElementById("arrivee")?.value);

        if (!isNaN(dateDepart) && !isNaN(dateArrivee) && dateArrivee > dateDepart) {
            const diffJours = (dateArrivee - dateDepart) / (1000 * 3600 * 24);

            // 3. Ajouter prix minimum par jour * nombre de jours
            const prixParJour = document.getElementById("prix-minimum").textContent; // <- à adapter si besoin
            somme += diffJours * prixParJour;
        }

        // 4. Calculer les prix des options sélectionnées
        const labels = formulaire.querySelectorAll("label");
        labels.forEach((label) => {
            const forId = label.getAttribute("for");
            const input = document.getElementById(forId);

            if (input && input.checked) {
                const prix = extrairePrix(label);

                // Si c’est une activité, on multiplie par le nombre de voyageurs
                if (input.name.startsWith("activite_")) {
                    somme += prix * nbVoyageurs;
                } else {
                    somme += prix; // Région, option simple
                }
            }
        });

        total.textContent = somme + " €";
    }

    formulaire.addEventListener("change", calculerPrix);
    formulaire.addEventListener("input", calculerPrix); // Pour que le changement de dates ou nombre de voyageurs soit pris en compte
    calculerPrix(); // Mise à jour initiale
});