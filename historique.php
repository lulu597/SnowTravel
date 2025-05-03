<?php
session_start();

if(!isset($_SESSION['utilisateur'])){
    header('Location: connexion.php');
    exit();
}else{
    $utilisateur=$_SESSION['utilisateur'];
}

$voyage=$_SESSION['voyage'];
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Title</title>

    <link rel="stylesheet" href="assets/css/connexion.css">
    <link rel="stylesheet" href="assets/css/profil.css">
    <link rel="stylesheet" href="assets/css/reservation.css">
    <link id="lien-theme" rel="stylesheet" href="assets/css/style.css">
    <script src="assets/javascript/theme.js" defer></script>
</head>

<body class="corps">

<div class="entete">
    <div class="nom-contenneur">
        <a href="index.php" class="nom-site">
            SnowTravel
        </a>
    </div>
    <div class="entete-droite">
        <div class="bouton-contenneur">
            <input type="text" placeholder="Rechercher..." class="barre-recherche">
        </div>
        <div class="bouton-contenneur">
            <a href="liste.php" class="connexion-lien">
                <button class="bouton">
                    Réserver
                </button>
            </a>
        </div>
        <div class="bouton-contenneur">
            <a href="assets/php/deconnexion.php" class="connexion-lien">
                <button class="bouton">
                    Se déconnecter
                </button>
            </a>
        </div>
        <div class="bouton-contenneur">
            <a href="profil.php">
                <img src="assets/img/Photo_profil/<?= $utilisateur['photo']?>.png" alt="icone utilisateur" height="50" width="50">
            </a>
        </div>
        <div class="bouton-contenneur">
            <button class="bouton" id="changer-theme">Changer de thème</button>
        </div>
    </div>
</div>

<section class="bloc-principal-centre">
    <div class="profil-div">
        <div>
            <div style="display: flex; align-content: center;">
                <h2 style="font-family: Arial, sans-serif; font-size: 25px; place-self: center">
                    Mes Voyages
                </h2>
            </div>

            <?php

            $fichier_voyage = "assets/php/fichier/reservations/" . $_SESSION['utilisateur']["fichier"];
            $fichier_liste = json_decode(file_get_contents($fichier_voyage), true);
            $fichier_liste_voyage = "assets/php/fichier/liste_voyage.json";
            $voyage_liste = json_decode(file_get_contents($fichier_liste_voyage), true);

            if($fichier_liste == null || $fichier_liste == []){
                header('Location: profil.php?id=12');
                exit();
            }

            foreach($fichier_liste as $fichier){
                foreach ($voyage_liste as $voya){
                    if($voya["identifiant"] == $fichier["identifiant"]){
                        echo '<div class="sous-partie-profil">
                                <a href="affichage.php?id=' . $fichier["debut"] . '" style="text-decoration: none;" class="lien">
                                    <p  id="nom" class="input-formu" style="text-align: left; place-content: center; padding: 10px;">
                                        '.$voya["nom"].' <br>
                                        départ : '. $fichier["debut"] .' 
                                    </p>
                                </a>
                                
                            </div>';
                    }
                }
            }
            ?>



        </div>
    </div>
</section>

<div class="bas-page">

</div>

</body>
</html>

