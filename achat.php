<?php
session_start();

if(!isset($_SESSION['utilisateur'])){
    $utilisateur['photo']=0;
}else{
    $utilisateur=$_SESSION['utilisateur'];
}

$statut=$_GET['status'];

$choix_voyage=$_SESSION['choix_voyage'];

$panier = 'assets/php/fichier/panier/' . $utilisateur['fichier'];

if(!file_exists($panier)){
    file_put_contents($panier, json_encode([]));
}

$fichier_panier = json_decode(file_get_contents($panier), true);

if($statut=="accepted"){
    $reductionnn = 0;

    foreach ($fichier_panier as $fichier){
        if ($fichier['reduction']=="1"){
            $reductionnn = 1;
        }
    }

    if($reductionnn == 1){
        $utilisateur['promotion']=0;
    }

    $fichier_voyage = "assets/php/fichier/reservations/" . $_SESSION['utilisateur']['fichier'];
    $fichier = json_decode(file_get_contents($fichier_voyage), true);

    if ($fichier == null) {
        $fichier = [];
    }

    $fichier = array_merge($fichier, $fichier_panier);

    file_put_contents($fichier_voyage, json_encode($fichier, JSON_PRETTY_PRINT));

    file_put_contents($panier, json_encode([]));


}



?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="assets/css/connexion.css">
    <link rel="stylesheet" href="assets/css/liste.css">
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
        <div class="bouton-contenneur">
            <button class="bouton" id="changer-theme">Changer de thème</button>
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