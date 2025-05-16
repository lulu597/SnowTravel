<?php
session_start();

if(!isset($_SESSION['utilisateur'])){
    $utilisateur['photo']=0;
}else{
    $utilisateur=$_SESSION['utilisateur'];
}

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $mail = $_POST['mail'];
    $mdp = $_POST['mdp'];

    $fichier_utilisateur = "assets/php/fichier/utilisateurs.json";

    if(file_exists($fichier_utilisateur)){
        $liste_utilisateurs = json_decode(file_get_contents($fichier_utilisateur), true);
        foreach($liste_utilisateurs as $utilisateur){

            if($utilisateur['mail'] == $mail && password_verify($mdp, $utilisateur['mdp'])){
                $_SESSION['utilisateur'] = [
                        'mail' => $utilisateur['mail'],
                        'mdp' => $utilisateur['mdp'],
                        'nom' => $utilisateur['nom'],
                        'prenom' => $utilisateur['prenom'],
                        'grade' => $utilisateur['grade'],
                        'promotion' => $utilisateur['promotion'],
                        'photo' => $utilisateur['photo'],
                        'fichier' => $utilisateur['fichier'],
                ];

                if($utilisateur['grade'] == "ban"){
                    die("ce compte est banni, fallait pas déconner");
                }
            }

        }
    }else{
        die("le fichier n'existe pas");
    }

    if (!isset($_SESSION['utilisateur'])) {
        die("erreur de connexion");
    }

    header("location:profil.php");
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
    <script src="assets/javascript/formulaire.js" defer></script>
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
        <form action="connexion.php" method="post">

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
                    <div style="display: flex; text-align: center; justify-content: center; align-items: center; font-family: Arial, sans-serif">
                        <input type="password" name="mdp" id="mdp" required class="input-formu" placeholder="Mot de passe..." maxlength="50">
                    </div>
                </div>
                <div class="sous-partie">
                    <button type="submit" class="bouton-form" style="max-width: 150px; place-self: center">
                        Se connecter
                    </button>
                </div>
                <div class="sous-partie">
                    <p style="font-family: Arial, sans-serif; font-size: 15px; text-align: center; margin-top: 50px">
                        Vous n'avez pas de compte?
                    </p>
                </div>
        </form>
        <a href="inscription.php">
            <button class="bouton-form">
                S'inscrire
            </button>
        </a>

    </div>

</section>

<div class="bas-page">

</div>

</body>
</html>