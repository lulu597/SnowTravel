<?php
    session_start();

    if(!isset($_SESSION['utilisateur'])){
        header('Location: connexion.php');
        exit();
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
    <link rel="stylesheet" href="assets/css/connexion.css">
    <link rel="stylesheet" href="assets/css/profil.css">
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
    </div>
</div>

<section class="bloc-principal-centre">
    <div class="profil-div">
        <div>
            <div style="display: flex; align-content: center;">
                <h2 style="font-family: Arial, sans-serif; font-size: 25px; place-self: center">
                    Mon Compte
                </h2>
                <a href="modifier_profil.php">
                    <img src="assets/img/modif.png" width="30" height="30" style="margin: 25px;">
                </a>

            </div>
            <div class="sous-partie-profil">
                <label for="nom" class="profil-lab">
                    Nom:
                </label>
                <input type="text" id="nom" required class="input-formu" value="<?= $utilisateur['nom'] ?>" readonly>
            </div>
            <div class="sous-partie-profil">
                <label for="prenom" class="profil-lab">
                    Prénom:
                </label>
                <input type="text" id="prenom" required class="input-formu" value="<?= $utilisateur['prenom'] ?>" readonly>
            </div>
            <div class="sous-partie-profil">
                <label for="mail" class="profil-lab">
                    E-Mail:
                </label>
                <input type="email" id="mail" required class="input-formu" value="<?= $utilisateur['mail'] ?>" readonly>
            </div>
            <div class="sous-partie-profil">
                <label for="mdp" class="profil-lab">
                    Mot de passe:
                </label>
                <input type="password" id="mdp" required class="input-formu" value="touveukoi">
            </div>
            <div class="sous-partie-statut">
                <div>
                    <p class="profil-lab">
                        statut:
                    </p>
                </div>
                <div style="display: flex">
                    <p class="statut-1">
                        <?= $utilisateur['grade'] ?>
                    </p>
                </div>
            </div>
            <br>
            <div class="sous-partie-statut">
                <div style="display: flex">
                    <a href="historique.php">
                        <button class="bouton-form" style="max-width: 150px; place-self: center">
                            Liste des réservations
                        </button>
                    </a>
                </div>
                <?php


                if(isset($_GET['id'])){
                        $verif = $_GET['id'];
                        if($verif==12){
                            echo "<p style='font-family: Arial, sans-serif; color: red; opacity: 50%'>Vous n'avez aucun voyage dans l'historique</p>";
                        }
                }

                ?>
            </div>
            <?php
                if($utilisateur['grade'] == "administrateur"){
                    echo '<div class="sous-partie-profil" style="margin-top: 50px">
                                <a href="admin.php">
                                    <button class="bouton-form" style="max-width: 150px; place-self: center">
                                        Panneau administrateur
                                    </button>
                                </a>
                           </div>';
                }
            ?>
        </div>
    </div>
</section>

<div class="bas-page">

</div>

</body>
</html>
