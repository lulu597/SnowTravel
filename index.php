<?php
session_start();

if(!isset($_SESSION['utilisateur'])){
    $utilisateur['photo']=0;
}else{
    $utilisateur=$_SESSION['utilisateur'];
}


?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Title</title>
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
            <?php
            if (isset($_SESSION['utilisateur'])){
                echo '<a href="assets/php/deconnexion.php" class="connexion-lien">
                            <button class="bouton">
                                Se déconnecter
                            </button>
                        </a>';
            }else{
                echo '<a href="connexion.php" class="connexion-lien">
                            <button class="bouton">
                                Se connecter
                            </button>
                        </a>';
            }
            ?>
        </div>
        <div class="bouton-contenneur">
            <?php
            if (isset($_SESSION['utilisateur'])){
                echo '<a href="panier.php" class="connexion-lien">
                            <img src="assets/img/panier.png" alt="icone utilisateur" height="30" width="30">
                      </a>';
            }
            ?>
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

<section class="bloc-principal">
    <div class="image-contenneur">
        <img src="assets/img/neige.png" alt="image enneigé" class="image-site">
    </div>
    <div class="description-contenneur">
        <p class="despription">
            Partez à la découverte des merveilles du Grand Nord, de la Suède à la Finlande en passant pas l'Islande, la Norvège, le Canda et l'Alaska
            où aurores boréales, paysage sauvage et aventures inoubliables vous attendent
        </p>
    </div>
</section>

<div class="bas-page">

</div>

</body>
</html>