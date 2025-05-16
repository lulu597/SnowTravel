<?php
session_start();

if(!isset($_SESSION['utilisateur'])){
    $utilisateur['photo']=0;
}else{
    $utilisateur=$_SESSION['utilisateur'];
}

if($utilisateur['grade']!='administrateur'){
    header('Location:index.php');
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <title>Title</title>

  <link rel="stylesheet" href="assets/css/connexion.css">
  <link rel="stylesheet" href="assets/css/profil.css">
    <link id="lien-theme" rel="stylesheet" href="assets/css/style.css">
    <script src="assets/javascript/theme.js" defer></script>
    <script src="assets/javascript/adminAsync.js" defer></script>
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

<section class="bloc-principal-centre" style="max-width: 800px">
  <div class="profil-div">
    <div>
      <div style="display: flex; align-content: center;">
          <ul style="padding: 0 40px; font-family: 'Arial', sans-serif">
            <li class="list-item" >
              <h1>
                Panneau administrateur
              </h1>
            </li>
            <li class="list-reservation" style="width: ">
              <p style="font-family: 'Arial', sans-serif; font-size: 30px; color: white">Changer le statut d'un utilisateur</p>

                <input id="emailcode" name="mail" type="email" required placeholder="Mail du compte..." class="input-formu">
                <ul class="ul-button-2">
                  <li>
                    <button name="bouton" class="bouton-form" type="submit" value="VIP">
                      Ajouter le statut VIP
                    </button>
                  </li>
                  <li>
                    <button name="bouton" class="bouton-form" type="submit" value="ban">
                      Bannir le compte
                    </button>
                  </li>
                  <li>
                    <button name="bouton" class="bouton-form" type="submit" value="deban">
                      Débannir le compte
                    </button>
                  </li>
                  <li>
                    <button name="bouton" class="bouton-form" type="submit" value="promotion">
                      Offrir un voyage
                    </button>
                  </li>
                  <li>
                    <button name="bouton" class="bouton-form" type="submit" value="promouvoir">
                      Ajouter le rang administrateur
                    </button>
                  </li>
                  <li>
                    <button name="bouton" class="bouton-form" type="submit" value="retrograder">
                      Retirer le rang administrateur
                    </button>
                  </li>
                </ul>

            </li>
          </ul>
        </div>
      </div>
      <div class="sous-partie-profil" style="margin-top: 50px">

          <img id="loader" src="assets/img/gif/chargement.gif" alt="Chargement..." style="display:none; width: 40px; height: 40px; place-self: center">

      </div>
      <div class="sous-partie-profil" style="margin-top: 50px">

          <button class="bouton-form-17" style="max-width: 150px; place-self: center">
              <a href="profil.php" style="text-decoration: none; color: #1E2A30">
                    Profil
              </a>
          </button>


      </div>
    </div>
</section>

<section class="bloc-principal-centre" style="max-width: 800px">
  <div class="profil-div" style="width: auto">
    <div>
      <div style="display: flex; align-content: center;">
        <ul style="padding: 0 40px; font-family: 'Arial', sans-serif; list-style: none">
          <li class="list-item" >
            <h1>
              Listes des comptes
            </h1>
          </li>
          <li class="list-reservation">
            <ul class="list-utilisateur">
                <?php
                    $fichier_utilisateurs = "assets/php/fichier/utilisateurs.json";
                    $liste_utilisateurs = json_decode(file_get_contents($fichier_utilisateurs), true);
                    foreach ($liste_utilisateurs as $utilisateurs) {
                        echo '<li class="bloc-liste-uti">
                                  <p class="info-uti">
                                      '. $utilisateurs['nom'] .'
                                  </p>
                                  <p class="info-uti-alt">
                                      '. $utilisateurs['prenom'] .'
                                  </p>
                                  <p class="info-uti">
                                      '. $utilisateurs['mail'] .'
                                  </p>
                                  <p class="info-uti-alt">
                                      '. $utilisateurs['grade'] .'
                                  </p>
                             </li>';
                    }
                ?>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </div>
</section>


<div class="bas-page">

</div>

</body>
</html>