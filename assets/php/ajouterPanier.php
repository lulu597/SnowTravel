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

if($choix_voyage['reduction'] == 1){
    $choix_voyage['prix']=0;
}

$voyage=$_SESSION['voyage'];

$panier = 'fichier/panier/' . $utilisateur['fichier'];

if(!file_exists($panier)){
    file_put_contents($panier, json_encode([]));
}

$fichier_panier = json_decode(file_get_contents($panier), true);

$nDepart = new DateTime($choix_voyage['debut']);
$nArrive = new DateTime($choix_voyage['fin']);
$chevauchement = false;

foreach ($fichier_panier as $fichier){

    $depart = new DateTime($fichier['debut']);
    $arrive = new DateTime($fichier['fin']);


        if(($nDepart>$depart AND $nDepart<$arrive) OR
            ($nArrive>$depart AND $nArrive<$arrive) OR
            ($nDepart<$depart AND $nArrive>$arrive) OR
            ($nDepart==$depart AND $nArrive==$arrive)){
            $chevauchement=true;
        }
}

if($chevauchement){
    die("les dates du voyage que vous voulez ajouter au panier se chevauchent avec un voyage du panier");
}

$fichier_panier[] = $choix_voyage;

file_put_contents($panier, json_encode($fichier_panier, JSON_PRETTY_PRINT));

header('Location:../../panier.php');
exit();