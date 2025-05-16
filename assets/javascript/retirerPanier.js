document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".supprimer-voyage").forEach(button => {
        button.addEventListener("click", () => {
            const index = button.dataset.index;
            const id = button.dataset.id;
            const bloc = document.querySelector(`.bloc-region[data-id='${id}']`);
            if (bloc) bloc.remove();

            fetch("assets/php/retirerPanier.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ index: index })
            })
                .then(res => res.json())
                .then(data => {
                    if (!data.succes) {
                        alert("Erreur lors de la suppression côté serveur.");
                    }
                })
                .catch(() => alert("Erreur réseau."));
        });
    });
});


