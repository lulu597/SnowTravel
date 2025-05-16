document.addEventListener("DOMContentLoaded", function (){
    const bloc1 = document.getElementById("bloc-region-1");
    const bloc2 = document.getElementById("bloc-region-2");
    const bloc3 = document.getElementById("bloc-region-3");
    const nomBloc1 = document.getElementById("bloc-nom-1");
    const nomBloc2 = document.getElementById("bloc-nom-2");
    const nomBloc3 = document.getElementById("bloc-nom-3");
    const region1 = document.getElementById("region1");
    const region2 = document.getElementById("region2");
    const region3 = document.getElementById("region3");

    if (region1.checked) {
        nomBloc1.style.display = "";
        bloc1.style.display = "";
    }
    if (region2.checked) {
        nomBloc2.style.display = "";
        bloc2.style.display = "";
    }
    if (region3.checked) {
        nomBloc3.style.display = "";
        bloc3.style.display = "";
    }


    region1.addEventListener("change" , function (){
        if (!region1.checked){
            nomBloc1.style.display = "none";
            bloc1.style.display = "none";
        }else{
            nomBloc1.style.display = "";
            bloc1.style.display = "";
        }
    });
    region2.addEventListener("change" , function (){
        if (!region2.checked){
            nomBloc2.style.display = "none";
            bloc2.style.display = "none";
        }else{
            nomBloc2.style.display = "";
            bloc2.style.display = "";
        }
    });
    region3.addEventListener("change" , function (){
        if (!region3.checked){
            nomBloc3.style.display = "none";
            bloc3.style.display = "none";
        }else{
            nomBloc3.style.display = "";
            bloc3.style.display = "";
        }
    });

    const checkboxs = document.querySelectorAll(".select-formu");
    let totalPrice = 0;
    let nomOption ="";
    let voyageur = document.getElementById("nombre");
    let idVoyage = document.getElementById("ident").dataset.id;

    function calcul(fichier){
        totalPrice = 0;
        checkboxs.forEach(cb =>{
            if (cb.checked){
                nomOption = cb.dataset.nom
                if ((cb.name != "region_1") && (cb.name != "region_2") && (cb.name != "region_3")){
                    totalPrice += Number(fichier[nomOption]) * voyageur.value;
                }else{
                    totalPrice += Number(fichier[nomOption]);
                }
            }
        });
        const dateDepart = new Date(document.getElementById("depart")?.value);
        const dateArrivee = new Date(document.getElementById("arrivee")?.value);

        if (!isNaN(dateDepart) && !isNaN(dateArrivee) && dateArrivee > dateDepart) {
            const diffJours = (dateArrivee - dateDepart) / (1000 * 3600 * 24);


            const prixParJour = Number(document.getElementById("prix-minimum").textContent);
            totalPrice += diffJours * prixParJour;
        }



        const prixAffichage = document.getElementById("prix");
        prixAffichage.textContent = `${totalPrice}€`;
    }


    fetch(`assets/php/recolteurInfoVoyage.php?id=${idVoyage}`, { headers:{
        'X-Requested-With': 'XMLHttpRequest'
        }
    })
        .then(reception => {
            return reception.json();
        })
        .then(fichier =>{

            checkboxs.forEach(checkbox => checkbox.addEventListener("change", () => calcul(fichier)));
            document.getElementById("depart").addEventListener("change", () => calcul(fichier));
            document.getElementById("arrivee").addEventListener("change", () =>  calcul(fichier));
            voyageur.addEventListener("change", () =>  calcul(fichier));

            calcul(fichier);

        })
        .catch(erreur => {
            console.error('Erreur', erreur);
        })



});

