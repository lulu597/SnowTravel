<?php
session_start();
unset($_SESSION['utilisateur']);
session_destroy();
header('Location: ../../connexion.php');
exit();