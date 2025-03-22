<?php
session_start();

if(!isset($_SESSION['utilisateur'])){
    $utilisateur['photo']=0;
}else{
    $utilisateur=$_SESSION['utilisateur'];
}

$identifiant=$_GET["id"];
unset($_SESSION['voyage']);

$fichier_voyage = "assets/php/fichier/liste_voyage.json";
$liste_voyage=json_decode(file_get_contents($fichier_voyage), true);
foreach($liste_voyage as $voyages){
    if($voyages['identifiant']==$identifiant){
        $_SESSION['voyage']=$voyages;
    }
}
if(!isset($_SESSION['voyage'])){
    die("erreur chargement des voyages");
}
$voyage=$_SESSION['voyage'];

if($_SERVER['REQUEST_METHOD']=='POST'){
    $choix_voyage=[
            "identifiant"=>$voyage['identifiant'],
            "activite_1"=>$_POST["activite_1"],
            "activite_2"=>$_POST["activite_2"],
            "activite_3"=>$_POST["activite_3"],
            "activite_4"=>$_POST["activite_4"],
            "activite_5"=>$_POST["activite_5"],
            "activite_6"=>$_POST["activite_6"],
            "activite_7"=>$_POST["activite_7"],
            "activite_8"=>$_POST["activite_8"],
            "activite_9"=>$_POST["activite_9"],
            "activite_10"=>$_POST["activite_10"],
            "activite_11"=>$_POST["activite_11"],
            "activite_12"=>$_POST["activite_12"],
            "region_1"=>$_POST["region_1"],
            "region_2"=>$_POST["region_2"],
            "region_3"=>$_POST["region_3"],
            "debut"=>$_POST["debut"],
            "fin"=>$_POST["fin"],
            "personne"=>$_POST['personne'],
            "duree"=>'',
            "prix"=>'',
            "reduction"=>$_POST["reduction"]
            ];

    if($choix_voyage['personne'] <=0){
        die('choississez un nombre minimal de un voyageur');
    }

    $debut = new DateTime($choix_voyage['debut']);
    $fin = new DateTime($choix_voyage['fin']);

    if($debut > $fin){
        die("erreur de date");
    }

    $difference = $debut->diff($fin);
    $choix_voyage['duree']=$difference->days;


    if($choix_voyage['region_1'] == 0 && $choix_voyage['region_2'] == 0 && $choix_voyage['region_3'] == 0){
        die('choisir au moins une region');
    }

    if(($choix_voyage['region_1'] == 0 &&
        ($choix_voyage['activite_1'] == 1 || $choix_voyage['activite_2'] == 1 || $choix_voyage['region_3'] == 1 || $choix_voyage['activite_4'])) ||
        ($choix_voyage['region_2'] == 0 &&
        ($choix_voyage['activite_5'] == 1 || $choix_voyage['activite_6'] == 1 || $choix_voyage['region_7'] == 1 || $choix_voyage['activite_8'])) ||
        ($choix_voyage['region_3'] == 0 &&
        ($choix_voyage['activite_9'] == 1 || $choix_voyage['activite_10'] == 1 || $choix_voyage['region_11'] == 1 || $choix_voyage['activite_12']))
    ){
        die("vous avez choisi une activité sans choisir la région dans laquelle elle est incluse");
    }

    $date_fausse=false;

    $fichier_reservation = "assets/php/fichier/reservations/" . $_SESSION['utilisateur']['fichier'];
    $liste_reservation = json_decode(file_get_contents($fichier_reservation), true);
    if(!$liste_reservation==null){
        foreach ($liste_reservation as $reservation){
            if(($choix_voyage['debut']>$reservation['debut'] AND $choix_voyage['debut']<$reservation['fin']) OR
                ($choix_voyage['fin']>$reservation['debut'] AND $choix_voyage['fin']<$reservation['fin']) OR
                ($choix_voyage['debut']<$reservation['debut']  AND $choix_voyage['fin']>$reservation['fin']) OR
                ($choix_voyage['debut']==$reservation['debut'] AND $choix_voyage['fin']==$reservation['fin'])){
                $date_fausse=true;
            }
        }
    }

    if($date_fausse){
        die('problème de planning (date qui se chevauche avec un autre voyage existant)');
    }

    $montant_total = 0;

    $montant_total=$choix_voyage['duree']*$voyage['prix_minimum'];

    if($choix_voyage['activite_1']==1){
        $montant_total+=$voyage['activite_1_prix'];
    }
    if($choix_voyage['activite_2']==1){
        $montant_total+=$voyage['activite_2_prix'];
    }
    if($choix_voyage['activite_3']==1){
        $montant_total+=$voyage['activite_3_prix'];
    }
    if($choix_voyage['activite_4']==1){
        $montant_total+=$voyage['activite_4_prix'];
    }
    if($choix_voyage['activite_5']==1){
        $montant_total+=$voyage['activite_5_prix'];
    }
    if($choix_voyage['activite_6']==1){
        $montant_total+=$voyage['activite_6_prix'];
    }
    if($choix_voyage['activite_7']==1){
        $montant_total+=$voyage['activite_7_prix'];
    }
    if($choix_voyage['activite_8']==1){
        $montant_total+=$voyage['activite_8_prix'];
    }
    if($choix_voyage['activite_9']==1){
        $montant_total+=$voyage['activite_9_prix'];
    }
    if($choix_voyage['activite_10']==1){
        $montant_total+=$voyage['activite_10_prix'];
    }
    if($choix_voyage['activite_11']==1){
        $montant_total+=$voyage['activite_11_prix'];
    }
    if($choix_voyage['activite_12']==1){
        $montant_total+=$voyage['activite_12_prix'];
    }
    if($choix_voyage['region_1']==1){
        $montant_total+=$voyage['region_1_prix'];
    }
    if($choix_voyage['region_2']==1){
        $montant_total+=$voyage['region_2_prix'];
    }
    if($choix_voyage['region_3']==1){
        $montant_total+=$voyage['region_3_prix'];
    }

    $montant_total*=$choix_voyage['personne'];

    $choix_voyage['prix']=$montant_total;

    $_SESSION["choix_voyage"]=$choix_voyage;

    header('Location: validation.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <title>Title</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/liste.css">
  <link rel="stylesheet" href="assets/css/connexion.css">
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

<section class="reservation-bloc">
  <div class="bloc-description-2">
    <div>
      <h2 class="Nom-pays"><?= $voyage["pays"] ?></h2>
    </div>
    <div>
      <details class="details-voayge">
        <summary><?= $voyage["region_1"] ?></summary>
          <p>
            <?= $voyage["resume_1"] ?> <br>
          </p>
          <p>
              <?= $voyage["resume_2"] ?> <br>
          </p>
          <p>
              <?= $voyage["resume_3"] ?> <br>
          </p>
          <p>
              <?= $voyage["resume_4"] ?><br>
          </p>
      </details>
    </div>
    <div>
      <details class="details-voayge">
        <summary><?= $voyage["region_2"] ?></summary>
          <p>
              <?= $voyage["resume_5"] ?> <br>
          </p>
          <p>
              <?= $voyage["resume_6"] ?> <br>
          </p>
          <p>
              <?= $voyage["resume_7"] ?> <br>
          </p>
          <p>
              <?= $voyage["resume_8"] ?> <br>
          </p>
      </details>
    </div>
    <div>
      <details class="details-voayge">
        <summary><?= $voyage["region_3"] ?></summary>
          <p>
              <?= $voyage["resume_9"] ?> <br>
          </p>
          <p>
              <?= $voyage["resume_10"] ?> <br>
          </p>
          <p>
              <?= $voyage["resume_11"] ?> <br>
          </p>
          <p>
              <?= $voyage["resume_12"] ?> <br>
          </p>
      </details>
    </div>

  </div>
  <div class="bloc-description">
    <form action="reservation.php" method="post">
      <div class="sous-partie">
        <label  for="depart" class="formu-lab">
          Date de départ
        </label>
        <input name="debut" type="date" id="depart" required class="input-formu" placeholder="jj/mm/aa">
      </div>
      <div class="sous-partie">
        <label for="arrivee" class="formu-lab">
          Date de retour
        </label>
        <input name="fin" type="date" id="arrivee" required class="input-formu" placeholder="jj/mm/aa">
      </div>
      <div class="sous-partie">
        <label for="nombre" class="formu-lab">
          Nombres de voyageurs
        </label>
        <input name="personne" type="number" id="nombre" required class="input-formu" placeholder="Nombre..." value="1">
      </div>

        <input name="reduction" type="hidden" required class="input-formu" placeholder="Nombre..." value="0">

        <?php
        if($_SESSION['utilisateur']['promotion']!=0){
            echo '<div class="sous-partie">
                        <label for="mange" class="formu-lab">
                            Utiliser une réduction
                        </label>
                        <input name="reduction" type="checkbox" id="mange" required class="input-formu" placeholder="Nombre..." value="1">
                  </div>';
        }
        ?>

      <div class="sous-partie-1">
          <div class="bloc-region">
              <div>
                  <label for="vild" class="formu-lab">
                      Région 1
                  </label>
              </div>
              <div class="bloc-option">
                  <input class="select-formu" type="hidden" name="region_1" value="0">
                  <label style="text-align: left"><?= $voyage["region_1"] ?></label>
                  <input class="select-formu" type="checkbox" name="region_1" value="1">
                  <label style="text-align: right"><?= $voyage["region_1_prix"] ?>€</label>
              </div>
              <div>
                  <label for="a1" class="formu-lab">
                      Activité de la Région 1
                  </label>
              </div>
              <div class="bloc-sous-region">
                  <div class="bloc-option">
                      <input class="select-formu" type="hidden" name="activite_1" value="0">
                      <label style="text-align: left"><?= $voyage["activite_1"] ?></label>
                      <input class="select-formu" type="checkbox" name="activite_1" value="1">
                      <label style="text-align: right"><?= $voyage["activite_1_prix"] ?>€</label>
                  </div>
                  <div class="bloc-option">
                      <input class="select-formu" type="hidden" name="activite_2" value="0">
                      <label style="text-align: left"><?= $voyage["activite_2"] ?></label>
                      <input class="select-formu" type="checkbox" name="activite_2" value="1">
                      <label style="text-align: right"><?= $voyage["activite_2_prix"] ?>€</label>
                  </div>
                  <div class="bloc-option">
                      <input class="select-formu" type="hidden" name="activite_3" value="0">
                      <label style="text-align: left"><?= $voyage["activite_3"] ?></label>
                      <input class="select-formu" type="checkbox" name="activite_3" value="1">
                      <label style="text-align: right"><?= $voyage["activite_3_prix"] ?>€</label>
                  </div>
                  <div class="bloc-option">
                      <input class="select-formu" type="hidden" name="activite_4" value="0">
                      <label style="text-align: left"><?= $voyage["activite_4"] ?></label>
                      <input class="select-formu" type="checkbox" name="activite_4" value="1">
                      <label style="text-align: right"><?= $voyage["activite_4_prix"] ?>€</label>
                  </div>
              </div>
          </div>

          <div class="bloc-region">
              <div>
                  <label for="vild" class="formu-lab">
                      Région 2
                  </label>
              </div>
              <div class="bloc-option">
                  <input class="select-formu" type="hidden" name="region_2" value="0">
                  <label style="text-align: left"><?= $voyage["region_2"] ?></label>
                  <input class="select-formu" type="checkbox" name="region_2" value="1">
                  <label style="text-align: right"><?= $voyage["region_2_prix"] ?>€</label>
              </div>
              <div>
                  <label for="a1" class="formu-lab">
                      Activité de la Région 2
                  </label>
              </div>
              <div class="bloc-sous-region">
                  <div class="bloc-option">
                      <input class="select-formu" type="hidden" name="activite_5" value="0">
                      <label style="text-align: left"><?= $voyage["activite_5"] ?></label>
                      <input class="select-formu" type="checkbox" name="activite_5" value="1">
                      <label style="text-align: right"><?= $voyage["activite_5_prix"] ?>€</label>
                  </div>
                  <div class="bloc-option">
                      <input class="select-formu" type="hidden" name="activite_6" value="0">
                      <label style="text-align: left"><?= $voyage["activite_6"] ?></label>
                      <input class="select-formu" type="checkbox" name="activite_6" value="1">
                      <label style="text-align: right"><?= $voyage["activite_6_prix"] ?>€</label>
                  </div>
                  <div class="bloc-option">
                      <input class="select-formu" type="hidden" name="activite_7" value="0">
                      <label style="text-align: left"><?= $voyage["activite_7"] ?></label>
                      <input class="select-formu" type="checkbox" name="activite_7" value="1">
                      <label style="text-align: right"><?= $voyage["activite_7_prix"] ?>€</label>
                  </div>
                  <div class="bloc-option">
                      <input class="select-formu" type="hidden" name="activite_8" value="0">
                      <label style="text-align: left"><?= $voyage["activite_8"] ?></label>
                      <input class="select-formu" type="checkbox" name="activite_8" value="1">
                      <label style="text-align: right"><?= $voyage["activite_8_prix"] ?>€</label>
                  </div>
              </div>
          </div>

          <div class="bloc-region">
              <div>
                  <label for="vild" class="formu-lab">
                      Région 3
                  </label>
              </div>
              <div class="bloc-option">
                  <input class="select-formu" type="hidden" name="region_3" value="0">
                  <label style="text-align: left"><?= $voyage["region_3"] ?></label>
                  <input class="select-formu" type="checkbox" name="region_3" value="1">
                  <label style="text-align: right"><?= $voyage["region_3_prix"] ?>€</label>
              </div>
              <div>
                  <label for="a1" class="formu-lab">
                      Activité de la Région 3
                  </label>
              </div>
              <div class="bloc-sous-region">
                  <div class="bloc-option">
                      <input class="select-formu" type="hidden" name="activite_9" value="0">
                      <label style="text-align: left"><?= $voyage["activite_9"] ?></label>
                      <input class="select-formu" type="checkbox" name="activite_9" value="1">
                      <label style="text-align: right"><?= $voyage["activite_9_prix"] ?>€</label>
                  </div>
                  <div class="bloc-option">
                      <input class="select-formu" type="hidden" name="activite_10" value="0">
                      <label style="text-align: left"><?= $voyage["activite_10"] ?></label>
                      <input class="select-formu" type="checkbox" name="activite_10" value="1">
                      <label style="text-align: right"><?= $voyage["activite_10_prix"] ?>€</label>
                  </div>
                  <div class="bloc-option">
                      <input class="select-formu" type="hidden" name="activite_11" value="0">
                      <label style="text-align: left"><?= $voyage["activite_11"] ?></label>
                      <input class="select-formu" type="checkbox" name="activite_11" value="1">
                      <label style="text-align: right"><?= $voyage["activite_11_prix"] ?>€</label>
                  </div>
                  <div class="bloc-option">
                      <input class="select-formu" type="hidden" name="activite_12" value="0">
                      <label style="text-align: left"><?= $voyage["activite_12"] ?></label>
                      <input class="select-formu" type="checkbox" name="activite_12" value="1">
                      <label style="text-align: right"><?= $voyage["activite_12_prix"] ?>€</label>
                  </div>
              </div>
          </div>
      </div>

      <div class="sous-partie" style="margin-top: 30px">
        <button type="submit" class="bouton-form" style="max-width: 150px; place-self: center">
          Valider les options
        </button>
      </div>
    </form>
  </div>
</section>

<div class="bas-page">

</div>

</body>
</html>
