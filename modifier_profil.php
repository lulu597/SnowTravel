<?php
session_start();

if (!isset($_SESSION['utilisateur'])) {
    header('Location: connexion.php');
    exit();
}else{
    $utilisateur=$_SESSION['utilisateur'];
}

$nom='';
$prenom='';
$mail='';
$mdp='';
$photo=0;

if($_SERVER['REQUEST_METHOD']=='POST'){
    $nom=$_POST['nom'];
    $prenom=$_POST['prenom'];
    $mail=$_POST['mail'];
    $photo=$_POST['photo'];
    $mdp=$_POST['mdp'];

    if (!($mdp==$utilisateur["mdp"])) {
        $mdp=password_hash($mdp, PASSWORD_DEFAULT);
    }

    $fichier_utilisateur = "assets/php/fichier/utilisateurs.json";
    $liste_utilisateurs = json_decode(file_get_contents($fichier_utilisateur), true);

    foreach ($liste_utilisateurs as &$nouvelle_utilisateur) {
        if($nouvelle_utilisateur['mail']==$utilisateur["mail"]) {
            $nouvelle_utilisateur=["nom"=>$nom,"prenom"=>$prenom,"mail"=>$mail,"mdp"=>$mdp,"grade"=>$utilisateur['grade'], "promotion"=>$utilisateur['promotion'], "photo"=>$photo, "fichier"=>$utilisateur['fichier'] ];
            $_SESSION['utilisateur']=$nouvelle_utilisateur;
        }
    }

    if(file_put_contents($fichier_utilisateur, json_encode($liste_utilisateurs, JSON_PRETTY_PRINT)) === false){
        die("Erreur lors de l'enregistrement du fichier");
    }


    header('Location:profil.php');
    exit();
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
            <a href="assets/php/deconnexion.php" class="connexion-lien">
                <button class="bouton">
                    Se déconnecter
                </button>
            </a>
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

<section class="bloc-principal-centre">
    <div class="formulaire-contenneur">
        <form action="modifier_profil.php" method="post">

            <div class="sous-partie">
                <label for="nom" class="formu-lab">
                    Nom
                </label>
                <input type="text" name="nom" id="nom" required class="input-formu" placeholder="Nom..." value="<?= $utilisateur['nom'] ?>">
            </div>
            <div class="sous-partie">
                <label for="prenom" class="formu-lab">
                    Prénom
                </label>
                <input type="text" name="prenom" id="prenom" required class="input-formu" placeholder="Prénom..." value="<?= $utilisateur['prenom'] ?>">
            </div>
            <div class="sous-partie">
                <label for="photo" class="formu-lab">Choix photo de profil:</label>
                <select id="photo" class="input-formu" name="photo" required>
                    <option value="0">aucune</option>
                    <option value="1">Robot</option>
                    <option value="2">Pikachu</option>
                    <option value="3">Pringles</option>
                    <option value="4">Heidi</option>
                    <option value="5">Ferrox</option>
                    <option value="6">Abeille</option>
                    <option value="7">Luffy</option>
                    <option value="8">Raiponce</option>
                    <option value="9">Lilo et Stitch</option>
                    <option value="10">Bohnomme de neige</option>

                </select>
            </div>
            <div class="sous-partie">
                <label for="mail" class="formu-lab">
                    E-Mail
                </label>
                <input type="email" name="mail" id="mail" required class="input-formu" placeholder="E-mail..." value="<?= $utilisateur['mail'] ?>">
            </div>

            <div class="sous-partie">
                <label for="mdp" class="formu-lab">
                    Mot de passe
                </label>
                <input type="password" name="mdp" id="mdp" required class="input-formu" placeholder="Mot de passe..." value="<?= $utilisateur['mdp'] ?>">
            </div>
            <div class="sous-partie">
                <button type="submit" class="bouton-form" style="max-width: 150px; place-self: center">
                    Modifier
                </button>
            </div>

        </form>
        <br>
        <a href="profil.php">
            <button class="bouton-form">
                Retour
            </button>
        </a>

    </div>

</section>

<div class="bas-page">

</div>

</body>
</html>