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

$utilisateur = $_SESSION['utilisateur'];
$choix_voyage = $_SESSION['choix_voyage'];
$voyage = $_SESSION['voyage'];
$cle = 'zzzz';
$groupe ='MI-3_D';
$cle = getapikey($groupe);
$numero_transaction=substr(bin2hex(random_bytes(12)), 0, 12);
$prix_transaction = $_SESSION['choix_voyage']['prix'];
$lien_retour="http://localhost:2112/achat.php";

$code_controle = md5($cle . "#" . $numero_transaction . "#" . $prix_transaction . "#" . $groupe . "#" . $lien_retour . "#");

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link id="lien-theme" rel="stylesheet" href="assets/css/style.css">
    <script src="assets/javascript/theme.js" defer></script>
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
            <div class="sous-partie">
                <label  for="depart" class="formu-lab">
                    Date de départ
                </label>
                <input name="debut" type="date" id="depart" required class="input-formu" placeholder="jj/mm/aa" value="<?= $choix_voyage['debut'] ?>" readonly>
            </div>
            <div class="sous-partie">
                <label for="arrivee" class="formu-lab">
                    Date de retour
                </label>
                <input name="fin" type="date" id="arrivee" required class="input-formu" placeholder="jj/mm/aa" value="<?= $choix_voyage['fin'] ?>" readonly>
            </div>
            <div class="sous-partie">
                <label for="nombre" class="formu-lab">
                    Nombres de voyageurs
                </label>
                <input name="personne" type="number" id="nombre" required class="input-formu" value="<?= $choix_voyage['personne'] ?>" readonly>
            </div>
            <div class="sous-partie-1">

                <?php

                if ($choix_voyage['region_1'] == 1){
                    echo ' <div class="bloc-region">
                    <div>
                        <label for="vild" class="formu-lab">
                            Région 1
                        </label>
                    </div>
                    <div class="bloc-option-valid">
                        <label style="text-align: left">' . $voyage["region_1"] .' - </label>
                        <label style="text-align: right">'. $voyage["region_1_prix"] .'€</label>
                    </div>
                    <div>
                        <label for="a1" class="formu-lab">
                            Activité de la Région 1
                        </label>
                    </div>
                    <div class="bloc-sous-region">';
                    
                    if( $choix_voyage['activite_1'] == 1 ){
                        echo '<div class="bloc-option-valid">
                                    <label style="text-align: left">' . $voyage["activite_1"] .' - </label>
                                    <label style="text-align: right">'. $voyage["activite_1_prix"] .'€</label>
                                </div>';
                    }

                    if( $choix_voyage['activite_2'] == 1 ){
                        echo '<div class="bloc-option-valid">
                                    <label style="text-align: left">' . $voyage["activite_2"] .' - </label>
                                    <label style="text-align: right">'. $voyage["activite_2_prix"] .'€</label>
                                </div>';
                    }

                    if( $choix_voyage['activite_3'] == 1 ){
                        echo '<div class="bloc-option-valid">
                                    <label style="text-align: left">' . $voyage["activite_3"] .' - </label>
                                    <label style="text-align: right">'. $voyage["activite_3_prix"] .'€</label>
                                </div>';
                    }

                    if( $choix_voyage['activite_4'] == 1 ){
                        echo '<div class="bloc-option-valid">
                                    <label style="text-align: left">' . $voyage["activite_4"] .' - </label>
                                    <label style="text-align: right">'. $voyage["activite_4_prix"] .'€</label>
                                </div>';
                    }
                        
                echo    '</div>
                </div>';
                }
                if ($choix_voyage['region_2'] == 1){
                    echo ' <div class="bloc-region">
                    <div>
                        <label for="vild" class="formu-lab">
                            Région 1
                        </label>
                    </div>
                    <div class="bloc-option-valid">
                        <label style="text-align: left">' . $voyage["region_2"] .' - </label>
                        <label style="text-align: right">'. $voyage["region_2_prix"] .'€</label>
                    </div>
                    <div>
                        <label for="a1" class="formu-lab">
                            Activité de la Région 1
                        </label>
                    </div>
                    <div class="bloc-sous-region">';

                    if( $choix_voyage['activite_5'] == 1 ){
                        echo '<div class="bloc-option-valid">
                                    <label style="text-align: left">' . $voyage["activite_5"] .' - </label>
                                    <label style="text-align: right">'. $voyage["activite_5_prix"] .'€</label>
                                </div>';
                    }

                    if( $choix_voyage['activite_6'] == 1 ){
                        echo '<div class="bloc-option-valid">
                                    <label style="text-align: left">' . $voyage["activite_6"] .' - </label>
                                    <label style="text-align: right">'. $voyage["activite_6_prix"] .'€</label>
                                </div>';
                    }

                    if( $choix_voyage['activite_7'] == 1 ){
                        echo '<div class="bloc-option-valid">
                                    <label style="text-align: left">' . $voyage["activite_7"] .' - </label>
                                    <label style="text-align: right">'. $voyage["activite_7_prix"] .'€</label>
                                </div>';
                    }

                    if( $choix_voyage['activite_8'] == 1 ){
                        echo '<div class="bloc-option-valid">
                                    <label style="text-align: left">' . $voyage["activite_8"] .' - </label>
                                    <label style="text-align: right">'. $voyage["activite_8_prix"] .'€</label>
                                </div>';
                    }

                    echo    '</div>
                </div>';
                }
                if ($choix_voyage['region_3'] == 1){
                    echo ' <div class="bloc-region">
                    <div>
                        <label for="vild" class="formu-lab">
                            Région 1
                        </label>
                    </div>
                    <div class="bloc-option-valid">
                        <label style="text-align: left">' . $voyage["region_3"] .' - </label>
                        <label style="text-align: right">'. $voyage["region_3_prix"] .'€</label>
                    </div>
                    <div>
                        <label for="a1" class="formu-lab">
                            Activité de la Région 1
                        </label>
                    </div>
                    <div class="bloc-sous-region">';

                    if( $choix_voyage['activite_9'] == 1 ){
                        echo '<div class="bloc-option-valid">
                                    <label style="text-align: left">' . $voyage["activite_9"] .' - </label>
                                    <label style="text-align: right">'. $voyage["activite_9_prix"] .'€</label>
                                </div>';
                    }

                    if( $choix_voyage['activite_10'] == 1 ){
                        echo '<div class="bloc-option-valid">
                                    <label style="text-align: left">' . $voyage["activite_10"] .' - </label>
                                    <label style="text-align: right">'. $voyage["activite_10_prix"] .'€</label>
                                </div>';
                    }

                    if( $choix_voyage['activite_11'] == 1 ){
                        echo '<div class="bloc-option-valid">
                                    <label style="text-align: left">' . $voyage["activite_11"] .' - </label>
                                    <label style="text-align: right">'. $voyage["activite_11_prix"] .'€</label>
                                </div>';
                    }

                    if( $choix_voyage['activite_12'] == 1 ){
                        echo '<div class="bloc-option-valid">
                                    <label style="text-align: left">' . $voyage["activite_12"] .' - </label>
                                    <label style="text-align: right">'. $voyage["activite_12_prix"] .'€</label>
                                </div>';
                    }

                    echo    '</div>
                </div>';
                }

                ?>
                </div>
                <div class="bloc-region">
                    <label for="a1" class="formu-lab">
                        Durée
                    </label>
                    <div class="bloc-option-valid">
                        <label style="text-align: right"><?= $choix_voyage['duree'] ?> jours</label>
                    </div>
                </div>
                <div class="bloc-region">
                    <label for="a1" class="formu-lab">
                        Montant total
                    </label>
                    <div class="bloc-option-valid">
                        <label style="text-align: right">  Prix des services à la journée : <?= $voyage['prix_minimum'] * $choix_voyage['duree'] ?> €</label><br><br>
                        <?php
                        if($choix_voyage['activite_1'] == 1){
                            echo' <label style="text-align: right">  Prix de '. $voyage['activite_1'] .' : '. $voyage['activite_1_prix'] .' €</label><br>';
                        }
                        if($choix_voyage['activite_2'] == 1){
                            echo' <label style="text-align: right">  Prix de '. $voyage['activite_2'] .' : '. $voyage['activite_2_prix'] .' €</label><br>';
                        }
                        if($choix_voyage['activite_3'] == 1){
                            echo' <label style="text-align: right">  Prix de '. $voyage['activite_3'] .' : '. $voyage['activite_3_prix'] .' €</label><br>';
                        }
                        if($choix_voyage['activite_4'] == 1){
                            echo' <label style="text-align: right">  Prix de '. $voyage['activite_4'] .' : '. $voyage['activite_4_prix'] .' €</label><br>';
                        }
                        if($choix_voyage['activite_5'] == 1){
                            echo' <label style="text-align: right">  Prix de '. $voyage['activite_5'] .' : '. $voyage['activite_5_prix'] .' €</label><br>';
                        }
                        if($choix_voyage['activite_6'] == 1){
                            echo' <label style="text-align: right">  Prix de '. $voyage['activite_6'] .' : '. $voyage['activite_6_prix'] .' €</label><br>';
                        }
                        if($choix_voyage['activite_7'] == 1){
                            echo' <label style="text-align: right">  Prix de '. $voyage['activite_7'] .' : '. $voyage['activite_7_prix'] .' €</label><br>';
                        }
                        if($choix_voyage['activite_8'] == 1){
                            echo' <label style="text-align: right">  Prix de '. $voyage['activite_8'] .' : '. $voyage['activite_8_prix'] .' €</label><br>';
                        }
                        if($choix_voyage['activite_9'] == 1){
                            echo' <label style="text-align: right">  Prix de '. $voyage['activite_9'] .' : '. $voyage['activite_9_prix'] .' €</label><br>';
                        }
                        if($choix_voyage['activite_10'] == 1){
                            echo' <label style="text-align: right">  Prix de '. $voyage['activite_10'] .' : '. $voyage['activite_10_prix'] .' €</label><br>';
                        }
                        if($choix_voyage['activite_11'] == 1){
                            echo' <label style="text-align: right">  Prix de '. $voyage['activite_11'] .' : '. $voyage['activite_11_prix'] .' €</label><br>';
                        }
                        if($choix_voyage['activite_12'] == 1){
                            echo' <label style="text-align: right">  Prix de '. $voyage['activite_12'] .' : '. $voyage['activite_12_prix'] .' €</label><br>';
                        }
                        if($choix_voyage['region_1'] == 1){
                            echo' <label style="text-align: right">  Prix de la region ('. $voyage['region_1'] .') : '. $voyage['region_1_prix'] .' €</label><br>';
                        }
                        if($choix_voyage['region_2'] == 1){
                            echo' <label style="text-align: right">  Prix de la region ('. $voyage['region_2'] .') : '. $voyage['region_2_prix'] .' €</label><br>';
                        }
                        if($choix_voyage['region_3'] == 1){
                            echo' <label style="text-align: right">  Prix de la region ('. $voyage['region_3'] .') : '. $voyage['region_3_prix'] .' €</label><br>';
                        }
                        ?>

                        <?php

                        $reduction=1;
                        if ($choix_voyage['reduction'] == 1) {
                            echo '<label style="text-align: right">Prix avant réduction : '. $choix_voyage['prix'] .' €</label>';
                            echo '<br>';
                            $reduction = 1 -($utilisateur['promotion']/100);
                        }
                        $choix_voyage['prix']*=$reduction;
                        ?>
                        <br>
                        <label style="text-align: right">Montant Total : <?= $choix_voyage['prix'] ?> €</label>
                    </div>
                </div>

            </div>



            <div style="margin-top: 30px; display: flex; gap 25px; width: 600px; justify-content: space-evenly; place-self: center">
                <form method="post" action="https://www.plateforme-smc.fr/cybank/index.php">

                    <input type="hidden" name="transaction" value="<?= $numero_transaction ?>">

                    <input type="hidden" name="montant" value="<?= $prix_transaction ?>">

                    <input type="hidden" name="vendeur" value="<?= $groupe ?>">

                    <input type="hidden" name="retour" value="<?= $lien_retour ?>">

                    <input type="hidden" name="control" value="<?= $code_controle ?>">

                    <button type="submit" class="bouton-form" style="max-width: 150px; place-self: center">
                        Valider l'achat et payer
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