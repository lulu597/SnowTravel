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
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/liste.css">
    <link id="lien-theme" rel="stylesheet" href="assets/css/style.css">
    <script src="assets/javascript/theme.js" defer></script>
    <script src="assets/javascript/filtre.js" defer></script>
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
            <input type="text" placeholder="Rechercher..." class="barre-recherche" type="text">
        </div>
        <div class="bouton-contenneur">
            <a href="liste.php" class="connexion-lien">
                <button class="bouton">Réserver</button>
            </a>
        </div>
        <div class="bouton-contenneur">
            <?php
            if (isset($_SESSION['utilisateur'])){
                echo '<a href="assets/php/deconnexion.php" class="connexion-lien">
                            <button class="bouton">Se déconnecter</button>
                        </a>';
            }else{
                echo '<a href="connexion.php" class="connexion-lien">
                            <button class="bouton">Se connecter</button>
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

<section class="filtrage">

    <input type="text" placeholder="Rechercher..." class="filtre" id="recherche">
    <div style="text-align: center; margin: 15px">
        <p style="font-size: 20px; font-family: Arial, sans-serif;">Type de voyage :</p>
    </div>
    <div id="region-filtre" style="display: grid; place-content: center">
        <select id="filtre-type" class="filtre">
            <option value="">Tout</option>
            <option value="nature">Nature / Aventure</option>
            <option value="culture">Culturel / Historique</option>
            <option value="mixte">Mixte</option>
            <option value="eco">Écotourisme</option>
            <option value="ville">City trip</option>
        </select>
    </div>
    <div style="text-align: center; margin: 15px">
        <p style="font-size: 20px; font-family: Arial, sans-serif;">Continent :</p>
    </div>
    <div style="display: grid; place-content: center">
        <select id="continent-filtre" class="filtre">
            <option value="">Tout</option>
            <option value="europe">Europe</option>
            <option value="amerique">Amérique du Nord</option>
        </select>
    </div>
    <div style="text-align: center; margin: 15px">
        <p style="font-size: 20px; font-family: Arial, sans-serif;">Trier par prix :</p>
    </div>
    <div style="display: grid; place-content: center">
        <select id="sort-price" class="filtre">
            <option value="">défaut</option>
            <option value="asc">Prix: Plus bas → Plus haut</option>
            <option value="desc">Prix: Plus haut → Plus bas</option>
        </select>
    </div>
</section>

<section class="bloc-liste">
    <div class="image-destination" data-type="nature" data-continent="europe" data-price="150">
        <a href="reservation.php?id=1">
            <img src="assets/img/destination1.png" width="600" height="400" style="border-radius: 30px">
            <div class="hover-text">Norvège</div>
        </a>
    </div>
    <div class="image-destination" data-type="nature" data-continent="amerique" data-price="155">
        <a href="reservation.php?id=2">
            <img src="assets/img/destination2.png" width="600" height="400" style="border-radius: 30px">
            <div class="hover-text">Canada</div>
        </a>
    </div>
    <div class="image-destination" data-type="nature" data-continent="amerique" data-price="160">
        <a href="reservation.php?id=3">
            <img src="assets/img/destination3.png" width="600" height="400" style="border-radius: 30px">
            <div class="hover-text">Alaska</div>
        </a>
    </div>
    <div class="image-destination" data-type="mixte" data-continent="europe" data-price="145">
        <a href="reservation.php?id=4">
            <img src="assets/img/destination4.png" width="600" height="400" style="border-radius: 30px">
            <div class="hover-text">Suède</div>
        </a>
    </div>
    <div class="image-destination" data-type="nature" data-continent="europe" data-price="160">
        <a href="reservation.php?id=5">
            <img src="assets/img/destination5.png" width="600" height="400" style="border-radius: 30px">
            <div class="hover-text">Finlande</div>
        </a>
    </div>
    <div class="image-destination" data-type="nature" data-continent="europe" data-price="170">
        <a href="reservation.php?id=6">
            <img src="assets/img/destination6.png" width="600" height="400" style="border-radius: 30px">
            <div class="hover-text">Islande</div>
        </a>
    </div>
    <div class="image-destination" data-type="mixte" data-continent="europe" data-price="160">
        <a href="reservation.php?id=7">
            <img src="assets/img/destination7.png" width="600" height="400" style="border-radius: 30px">
            <div class="hover-text">Danemark</div>
        </a>
    </div>
    <div class="image-destination" data-type="nature" data-continent="europe" data-price="190">
        <a href="reservation.php?id=8">
            <img src="assets/img/destination8.png" width="600" height="400" style="border-radius: 30px">
            <div class="hover-text">Iles Féroé</div>
        </a>
    </div>
    <div class="image-destination" data-type="eco" data-continent="amerique" data-price="250">
        <a href="reservation.php?id=9">
            <img src="assets/img/destination9.png" width="600" height="400" style="border-radius: 30px">
            <div class="hover-text">Groenland</div>
        </a>
    </div>
    <div class="image-destination" data-type="culture" data-continent="europe" data-price="150">
        <a href="reservation.php?id=10">
            <img src="assets/img/destination10.png" width="600" height="400" style="border-radius: 30px">
            <div class="hover-text">Estonie</div>
        </a>
    </div>
    <div class="image-destination" data-type="culture" data-continent="europe" data-price="140">
        <a href="reservation.php?id=11">
            <img src="assets/img/destination11.png" width="600" height="400" style="border-radius: 30px">
            <div class="hover-text">Lettonie</div>
        </a>
    </div>
    <div class="image-destination" data-type="culture" data-continent="europe" data-price="130">
        <a href="reservation.php?id=12">
            <img src="assets/img/destination12.png" width="600" height="400" style="border-radius: 30px">
            <div class="hover-text">Lituanie</div>
        </a>
    </div>
    <div class="image-destination" data-type="nature" data-continent="europe" data-price="180">
        <a href="reservation.php?id=13">
            <img src="assets/img/destination13.png" width="600" height="400" style="border-radius: 30px">
            <div class="hover-text">Ecosse</div>
        </a>
    </div>
    <div class="image-destination" data-type="mixte" data-continent="europe" data-price="120">
        <a href="reservation.php?id=14">
            <img src="assets/img/destination14.png" width="600" height="400" style="border-radius: 30px">
            <div class="hover-text">Pologne</div>
        </a>
    </div>
    <div class="image-destination" data-type="mixte" data-continent="europe" data-price="100">
        <a href="reservation.php?id=15">
            <img src="assets/img/destination15.png" width="600" height="400" style="border-radius: 30px">
            <div class="hover-text">Irlande</div>
        </a>
    </div>
</section>

<div class="bas-page"></div>

</body>
</html>