<?php
session_start();

if(!isset($_SESSION['utilisateur'])){
    $utilisateur['photo']=0;
}else{
    $utilisateur=$_SESSION['utilisateur'];
}

$statut=$_GET['status'];

$choix_voyage=$_SESSION['choix_voyage'];

if($statut=="accepted"){
    if($choix_voyage['reduction'] == 1){
        $utilisateur['promotion']=0;
    }
    $fichier_voyage = "assets/php/fichier/reservations/" . $_SESSION['utilisateur']['fichier'];
    $fichier = json_decode(file_get_contents($fichier_voyage), true);

    if ($fichier == null) {
        $fichier = [];
    }

    $doublon = false;

    if($fichier!=[]){
        foreach ($fichier as $fich) {
            if($fich['debut'] == $_SESSION['choix_voyage']['debut']){
                $doublon = true;
            }
        }
    }

    if(!$doublon){
        $fichier[]=$choix_voyage;
        if (file_put_contents($fichier_voyage, json_encode($fichier, JSON_PRETTY_PRINT)) === false) {
            die("Erreur de sauvegarde.");
        }
    }
}



?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/connexion.css">
    <link rel="stylesheet" href="assets/css/liste.css">
    <link rel="stylesheet" href="assets/css/reservation.css">
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
<br><br><br><br>
<section class="bloc-principal-centre">
    <div class="formulaire-contenneur">
        <form action="connexion.php" method="post">

            <?php
                if($statut=="accepted"){
                    echo '
                        <div class="input-formu" style="place-content: center; text-align: center;">
                            Paiement accepté
                        </div>
                    ';
                }else{
                    echo '
                        <div class="input-formu" style="place-content: center">
                            Paiement refusé
                        </div>
                    ';
                }
            ?>

            <div class="bloc-option-valid" style="place-content: center; text-align: center; margin-bottom: 15px">
                Résumé: <br><br>
                Montant : <?= $_GET['montant'] ?> € <br>
                Numéro de transaction : <?= $_GET['transaction'] ?> <br>
                Acheteur : <?= $_SESSION['utilisateur']['nom'] . ' ' . $_SESSION['utilisateur']['prenom'] ?> <br>
                Numéro Client : <?= pathinfo($_SESSION['utilisateur']['fichier'], PATHINFO_FILENAME); ?>
            </div>

        </form>
        <a href="profil.php">
            <button class="bouton-form">
                Retourner à vôtre profil
            </button>
        </a>

    </div>


</section>
<br><br><br>
<div class="bas-page">

</div>

</body>
</html>