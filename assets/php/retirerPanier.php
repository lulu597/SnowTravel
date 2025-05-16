<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['utilisateur'])) {
    echo json_encode(['succes' => false, 'message' => 'Utilisateur non connecté.']);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);
$index = $data['index'];

$fichier_panier = "fichier/panier/" . $_SESSION['utilisateur']['fichier'];

if (!file_exists($fichier_panier)) {
    echo json_encode(['succes' => false, 'message' => 'Fichier panier introuvable.']);
    exit();
}

$panier = json_decode(file_get_contents($fichier_panier), true);

if (isset($panier[$index])) {
    unset($panier[$index]);
    $panier = array_values($panier);
    file_put_contents($fichier_panier, json_encode($panier, JSON_PRETTY_PRINT));
    echo json_encode(['succes' => true]);
} else {
    echo json_encode(['succes' => false, 'message' => 'Index invalide.']);
}

