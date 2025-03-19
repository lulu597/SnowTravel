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
</head>

<body style="top: 0; left: 0; margin: 0; padding: 0; background: #B8CBD0">

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
      <a href="profil.php">
        <img src="assets/img/Photo_profil/<?= $utilisateur['photo']?>.png" alt="icone utilisateur" height="50" width="50">
      </a>
    </div>
  </div>
</div>

<section class="filtrage">
  <div style="text-align: center; margin: 15px">
    <p style="font-size: 20px;
     font-family: Arial, sans-serif;">Lieu :</p>
  </div>
  <div style="display: grid; place-content: center">
      <select class="filtre">
        <option value="tout">Tout</option>

        <option value="Campage">Campage</option>

        <option value="Ville">Ville</option>

        <option value="Banlieue">Banlieu</option>
      </select>
  </div>
  <div style="text-align: center; margin: 15px">
    <p style="font-size: 20px;
     font-family: Arial, sans-serif;">Continent :</p>
  </div>
  <div style="display: grid; place-content: center">
    <select class="filtre">
      <option value="tout">Tout</option>

      <option value="Campage">Europe</option>

      <option value="Ville">Amérique du Nord</option>
    </select>
  </div>

</section>

<section class="bloc-liste">
    <div class="image-destination">
      <a href="reservation.php">
        <img src="assets/img/destination1.png" width="600" height="400" style="border-radius: 30px">
        <div class="hover-text">Norvège</div>
      </a>
    </div>
    <div class="image-destination">
      <a href="reservation.php">
        <img src="assets/img/destination2.png" width="600" height="400" style="border-radius: 30px">
        <div class="hover-text">Canada</div>
      </a>
    </div>
    <div class="image-destination">
      <a href="reservation.php">
        <img src="assets/img/destination3.png" width="600" height="400" style="border-radius: 30px">
        <div class="hover-text">Alaska</div>
      </a>
    </div>
    <div class="image-destination">
      <a href="reservation.php">
        <img src="assets/img/destination4.png" width="600" height="400" style="border-radius: 30px">
        <div class="hover-text">Suède</div>
      </a>
    </div>
    <div class="image-destination">
      <a href="reservation.php">
        <img src="assets/img/destination5.png" width="600" height="400" style="border-radius: 30px">
        <div class="hover-text">Finlande</div>
      </a>
    </div>
    <div class="image-destination">
      <a href="reservation.php">
        <img src="assets/img/destination6.png" width="600" height="400" style="border-radius: 30px">
        <div class="hover-text">Islande</div>
      </a>
    </div>
</section>

<div class="bas-page">

</div>

</body>
</html>