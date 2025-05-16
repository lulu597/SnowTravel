<?php
session_start();
sleep(2);
function utilisateur(){
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}

if(!utilisateur()){
    header('Location: ../../index.php');
    exit();
}

$utilisateur=$_SESSION['utilisateur'];
$headers=array_change_key_case(getallheaders(), CASE_LOWER);
$trouver = false;

if(!isset($headers['mail'])){
    http_response_code(400);
    echo json_encode(['error' => 'Mail introuvable']);
    exit();
}

$mail = $headers['mail'];
$bouton = $_GET['value'];

switch ($bouton) {
    case 'VIP':
        $action="VIP";
        break;
    case 'promouvoir':
        $action="administrateur";
        break;
    case 'ban':
        $action="ban";
        break;
    case 'retrograder':
    case 'deban':
        $action="utilisateur";
        break;
    case 'promotion':
        $action="promo";
        break;
    default:
        http_response_code(400);
        echo json_encode(['error' => 'Une erreur est survenue']);
        exit();
}

$fichier_utilisateurs = "fichier/utilisateurs.json";
if(file_exists($fichier_utilisateurs)){
    $liste_utilisateurs = json_decode(file_get_contents($fichier_utilisateurs), true);
    foreach ($liste_utilisateurs as &$utilisateurs) {
        if($utilisateurs['mail']==$mail){
            $trouver=true;
            if($action=="promo"){
                $utilisateurs['promotion']=100;
                if($utilisateur['mail']==$mail){
                    $_SESSION['utilisateur']['promotion']=$utilisateurs['promotion'];
                }
            }else{
                if($utilisateurs['grade']=="administrateur" && ($bouton == "retrograder" || $bouton=="ban")){
                    $utilisateurs['grade']=$action;
                }else if($utilisateurs['grade']!="administrateur"){
                    $utilisateurs['grade']=$action;
                }
                if($utilisateur['mail']==$mail){
                    $_SESSION['utilisateur']['grade']=$utilisateurs['grade'];
                }
            }
        }
    }

    if(!$trouver){
        http_response_code(400);
        echo json_encode(['error' => 'Utilisateur introuvable']);
        exit();
    }

    if(file_put_contents($fichier_utilisateurs, json_encode($liste_utilisateurs, JSON_PRETTY_PRINT)) === false){
        die("Erreur lors de l'enregistrement du fichier");
    }



    echo json_encode([]);
    exit();
}



