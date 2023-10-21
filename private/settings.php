<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("location: index.php");
    exit();
}
date_default_timezone_set('Africa/Dakar');
include_once "../connexion.php";
$aujourdhui= date('Y-m-d');
try {
// Récupération des données depuis la base de données
    $query = "SELECT * FROM administrateur";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    // Récupérez les résultats dans un tableau associatif
    $resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Affichage des données sous forme de tableau HTML
echo"<div class=\"tab-container\">";
echo "<table class=\"tab parametres\">";
echo "<tr><th>ID</th><th>Nom</th><th>Email</th><th>Derniere connexion</th></tr>";
foreach ($resultats as $row) {
    echo "<tr>";
    echo "<td>" . $row["id"] . "</td>";
    echo "<td>" . $row["User"] . "</td>";
    echo "<td>" . $row["email"] . "</td>";
    switch ($row["Date"]) {
        case $aujourdhui:
            echo "<td style='background-color: #5DADE2;'>" . $row["Date"] . "</td>";
            break;
        default:
            echo "<td>" . $row["Date"] . "</td>";
            break;
    }
    echo "</tr>";
}
echo "</table>";
echo "</div>";
} catch (PDOException $e) {
    // Gérez les erreurs PDO de manière appropriée
    die("Erreur : " . $e->getMessage());
}

echo "<div style='text-align: right; margin-top: 20px;'>";
echo "<a href='changepass.php' class='button'>changer de mot de passe</a>";
echo "</div>";
// Fermeture de la connexion
include "../deconnexion.php";
?>
