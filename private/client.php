<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("location: index.php");
    exit();
}
include_once "../connexion.php";

try {
// Récupération des données depuis la base de données
    $query = "SELECT * FROM client ORDER BY id DESC LIMIT 10";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    // Récupérez les résultats dans un tableau associatif
    $resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Affichage des données sous forme de tableau HTML
echo"<div class=\"tab-container\">";
echo "<table class=\"tab client\">";
echo "<tr><th>ID</th><th>Nom</th><th>Email</th><th>Téléphone</th><th>Entreprise</th><th>Secteur</th><th>Fonction</th><th>Réponse enquete</th> <th>Info Supp</th> <th>Date</th> <th>Code utilisé</th> <th>heure</th><th colspan=\"1\" >Options</th></tr>";
foreach ($resultats as $row) {
    echo "<tr>";
    echo "<td>" . $row["id"] . "</td>";
    echo "<td>" . $row["nom"] . "</td>";
    $email= $row["email"];
    echo "<td><a href='mailto:$email' target='_blank'>" . $row["email"] . "</td>";
    echo "<td>" . $row["tel"] . "</td>";
    $urlRechercheGoogle = "https://www.google.com/search?q=" . urlencode($row["entreprise"]);
    echo "<td><a href='$urlRechercheGoogle' target='_blank'>" . $row["entreprise"] . "</a></td>";
    echo "<td>" . $row["secteur"] . "</td>";
    echo "<td>" . $row["fonction"] . "</td>";
    echo "<td>" . $row["enquete"] . "</td>";
    echo "<td>" . $row["infoadd"] . "</td>";
    echo "<td>" . $row["datecode"] . "</td>";
    echo "<td>" . $row["code"] . "</td>";
    echo "<td>" . $row["heure"] . "</td>";
    $id=$row["id"];
    echo "<td><a title=\"Modifier informations\" href='modifclient.php?id=".$id."'><i style='color:#0ec4c1' class='bx bx-edit-alt'></i></a></td>";
    echo "</tr>";
}
echo "</table>";
echo "</div>";
} catch (PDOException $e) {
    // Gérez les erreurs PDO de manière appropriée
    die("Erreur : " . $e->getMessage());
}

// Fermeture de la connexion
include "../deconnexion.php";
?>
