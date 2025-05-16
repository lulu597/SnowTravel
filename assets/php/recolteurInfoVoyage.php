<?php

function utilisateur(){
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}

if(!utilisateur()){
    header('Location: ../../index.php');
    exit();
}

if (!isset($_GET['id'])) {
    http_response_code(400);
    echo json_encode(["error" => "id non valide"]);
    exit();
}

$identifiant = $_GET['id'];
$voyages = json_decode(file_get_contents("fichier/liste_voyage.json"), true);

foreach ($voyages as $voyage) {
    if ($voyage['identifiant'] == $identifiant) {
        header('Content-type: application/json');
        echo json_encode($voyage);
        exit();
    }
}

http_response_code(404);
echo json_encode(["error" => "voyage non trouvé dans le fichier (id incohérent)"]);

