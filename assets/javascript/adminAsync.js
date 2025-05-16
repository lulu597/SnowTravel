document.addEventListener("DOMContentLoaded",  function (){
    const boutons = document.querySelectorAll(".bouton-form");
    const mail = document.getElementById("emailcode");
    const loader = document.getElementById("loader");
    let valeur ="";

    boutons.forEach(bouton => {
        bouton.addEventListener("click", () => {

            if (!mail.checkValidity()){
                alert("email de l'utilisateur invalide ");
                return;
            }

            valeur = bouton.value;

            loader.style.display = "inline-block";

            fetch(`assets/php/adminAsync.php?value=${valeur}`, { headers:{
                    'X-Requested-With': 'XMLHttpRequest',
                    'Mail': mail.value
                }
            })
                .then(reception => {
                    if (!reception.ok) {
                        return reception.json().then(err => {
                            throw new Error(err.error || "Erreur inconnue");
                        });
                    }
                    return reception.json();
                })
                .then(succes => {
                    alert("succès de l'opération")
                })
                .catch(erreur => {
                    alert("Échec : " + erreur.message);
                    console.error('Erreur', erreur);
                })
                .finally(() => {
                    loader.style.display = "none";
                });
        });
    });
});