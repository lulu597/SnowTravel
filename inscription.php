<?php
session_start();

if(!isset($_SESSION['utilisateur'])){
    $utilisateur['photo']=0;
}else{
    $utilisateur=$_SESSION['utilisateur'];
}

$nom='';
$prenom='';
$mail='';
$mdp='';
$grade='utilisateur';
$promotion=0;
$photo=0;

if($_SERVER['REQUEST_METHOD']=='POST'){
    $nom=$_POST['nom'];
    $prenom=$_POST['prenom'];
    $mail=$_POST['mail'];
    $mdp=password_hash($_POST['mdp'], PASSWORD_DEFAULT);

    $fichier_utilisateur = "assets/php/fichier/utilisateurs.json";
    $liste_utilisateurs = json_decode(file_get_contents($fichier_utilisateur), true);
    $duplication=false;

    foreach ($liste_utilisateurs as $utilisateur) {
        if ($utilisateur['mail']==$mail) {
            $duplication=true;
        }
    }

    if (!$duplication) {
        $fichier_reservation = base64_encode($mail) . ".json";
        $nouvel_utilisateur=["nom"=>$nom,"prenom"=>$prenom,"mail"=>$mail,"mdp"=>$mdp,"grade"=>$grade, "promotion"=>$promotion,"photo"=>$photo, "fichier"=>$fichier_reservation ];
        $liste_utilisateurs[]=$nouvel_utilisateur;

        if(file_put_contents($fichier_utilisateur, json_encode($liste_utilisateurs, JSON_PRETTY_PRINT)) === false){
            die("Erreur lors de l'enregistrement du fichier");
        }

        header('Location:connexion.php');
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="assets/css/connexion.css">
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

<section class="bloc-principal-centre">
    <div class="formulaire-contenneur">
        <form action="inscription.php" method="post">

            <div class="sous-partie">
                <label for="nom" class="formu-lab">
                    Nom
                </label>
                <input type="text" name="nom" id="nom" required class="input-formu" placeholder="Nom...">
            </div>
            <div class="sous-partie">
                <label for="prenom" class="formu-lab">
                    Prénom
                </label>
                <input type="text" name="prenom" id="prenom" required class="input-formu" placeholder="Prénom...">
            </div>
            <div class="sous-partie">
                <label for="mail" class="formu-lab">
                    E-Mail
                </label>
                <input type="email" name="mail" id="mail" required class="input-formu" placeholder="E-mail...">
            </div>
            <div class="sous-partie">
                <label for="mdp" class="formu-lab">
                    Mot de passe
                </label>
                <input type="password" name="mdp" id="mdp" required class="input-formu" placeholder="Mot de passe...">
            </div>
            <div class="sous-partie">
                <button type="submit" class="bouton-form" style="max-width: 150px; place-self: center">
                    S'inscrire
                </button>
            </div>
            <div class="sous-partie">
                <p style="font-family: Arial, sans-serif; font-size: 15px; text-align: center; margin-top: 50px">
                    Vous avez un compte?
                </p>
            </div>
        </form>
        <a href="connexion.php">
            <button class="bouton-form">
                Se connecter
            </button>
        </a>

    </div>

</section>

<div class="bas-page">

</div>

</body>
</html>
