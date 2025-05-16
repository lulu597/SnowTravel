<?php
session_start();

if(!isset($_SESSION['utilisateur'])){
    header('Location:connexion.php');
    exit();
}else{
    $utilisateur=$_SESSION['utilisateur'];
}

$fichier_voyage = "assets/php/fichier/liste_voyage.json";

$choix_voyage=$_SESSION['choix_voyage'];

$voyage=$_SESSION['voyage'];

require 'assets/php/getapikey.php';

$panier = 'assets/php/fichier/panier/' . $utilisateur['fichier'];

if(!file_exists($panier)){
    file_put_contents($panier, json_encode([]));
}

$fichier_panier = json_decode(file_get_contents($panier), true);

$utilisateur = $_SESSION['utilisateur'];
$choix_voyage = $_SESSION['choix_voyage'];
$voyage = $_SESSION['voyage'];
$cle = 'zzzz';
$groupe ='MI-3_D';
$cle = getapikey($groupe);
$numero_transaction=substr(bin2hex(random_bytes(12)), 0, 12);
$prix_transaction = $_SESSION['choix_voyage']['prix'];
$lien_retour="http://localhost:2112/achat.php";

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link id="lien-theme" rel="stylesheet" href="assets/css/style.css">
    <script src="assets/javascript/theme.js" defer></script>
    <script src="assets/javascript/retirerPanier.js" defer></script>
    <link rel="stylesheet" href="assets/css/liste.css">
    <link rel="stylesheet" href="assets/css/connexion.css">
    <link rel="stylesheet" href="assets/css/reservation.css">
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

<section class="reservation-bloc">
    <div class="bloc-description">

        <?php
        $compteur = 1;
        $prix_total=0;

        foreach ($fichier_panier as $index => $recap) {
            $id_unique = md5($recap['debut'] . $recap['fin'] . $recap['prix']);
            echo '
        <div class="bloc-region" data-id="' . $id_unique . '">
            <label style="text-align: center; font-family: Arial, sans-serif; font-size: 30px">Voyage du panier numéro ' . $compteur . '</label>
            <div class="panier-bloc">
                Départ: <input class="input-formu" value="' . $recap['debut'] . '" readonly>
            </div>
            <div class="panier-bloc">
                Retour: <input class="input-formu" value="' . $recap['fin'] . '" readonly>
            </div>
            <div class="panier-bloc">
                Durée: <input class="input-formu" value="' . $recap['duree'] . '" readonly>
            </div>
            <div class="panier-bloc">
                Nombre de voyageurs: <input class="input-formu" value="' . $recap['personne'] . '" readonly>
            </div>
            <div class="panier-bloc">
                Prix: <input class="input-formu" value="' . $recap['prix'] . '€" readonly>
            </div>
            <button class="supprimer-voyage bouton-form" data-index="' . $index . '" data-id="' . $id_unique . '">Supprimer</button>
        </div>
            ';
            $prix_total += $recap['prix'];
            $compteur++;
        }

        $code_controle = md5($cle . "#" . $numero_transaction . "#" . $prix_total . "#" . $groupe . "#" . $lien_retour . "#");

        ?>

        <div class="bloc-region">
            <label for="a1" class="formu-lab">
                Montant total
            </label>
            <div class="bloc-option-valid">
                <label style="text-align: right; font-family: Arial, sans-serif">Montant Total : <?= $prix_total ?> €</label>
            </div>
        </div>


            <div style="margin-top: 30px; display: flex; gap 25px; width: 600px; justify-content: space-evenly; place-self: center">
                <form method="post" action="https://www.plateforme-smc.fr/cybank/index.php">

                    <input type="hidden" name="transaction" value="<?= $numero_transaction ?>">

                    <input type="hidden" name="montant" value="<?= $prix_total ?>">

                    <input type="hidden" name="vendeur" value="<?= $groupe ?>">

                    <input type="hidden" name="retour" value="<?= $lien_retour ?>">

                    <input type="hidden" name="control" value="<?= $code_controle ?>">

                    <button type="submit" class="bouton-form" style="max-width: 150px; place-self: center">
                        Valider le panier et payer
                    </button>
                </form>
                <a href="reservation.php?id=<?= $voyage['identifiant'] ?>">
                    <button type="submit" class="bouton-form" style="max-width: 150px; place-self: center">
                        Modifier les options
                    </button>
                </a>
            </div>
    </section>


<div class="bas-page">

</div>

</body>
</html>