<?php 
session_start();
if (!isset($_SESSION['user'])) {
    header("location: index.php");
    exit();
}
include_once "../connexion.php";
$code = $_GET['code'];

// Mettez à jour la base de données ici
$sql = "DELETE FROM clés  WHERE code = ?";
$stmt= $conn->prepare($sql);
$stmt->execute([$code]);

include_once "../deconnexion.php";
header("location: dashboard.php");
?>