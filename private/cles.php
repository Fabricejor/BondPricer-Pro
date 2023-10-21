<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("location: index.php");
    exit();
}
include_once "../connexion.php";

try {
// Récupération des données depuis la base de données
    $query = "SELECT * FROM clés ORDER BY date DESC LIMIT 20";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    // Récupérez les résultats dans un tableau associatif
    $resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Affichage des données sous forme de tableau HTML
echo"<div class=\"tab-container\">";
echo "<table class=\"tab cle\">";
echo "<tr><th>Code</th><th>Disponible depuis</th><th>Accesiblité</th><th colspan=\"2\" >Options</th></tr> ";
foreach ($resultats as $row) {
    echo "<tr>";
    echo "<td>" . $row["code"] . "</td>";
    echo "<td>" . $row["date"] . "</td>";
    switch ($row["Acces"]) {
        case 'disponible':
            echo "<td style='background-color: #5DADE2;'>" . $row["Acces"] . "</td>";
            break;
        case 'distribué':
            echo "<td style='background-color: #EC7063 ;'>" . $row["Acces"] . "</td>";
            break;
        default:
            echo "<td>" . $row["Acces"] . "</td>";
            break;
    }
    switch ($row["Acces"]) {
        case 'disponible':
            # code...
            $code=$row["code"];
            echo "<td><a title=\"marqué comme partagé\" href='modifclés.php?code=".$code."'><i class='bx bxs-share-alt' style='color:#0b99f9'  ></i></a></td>";
            echo "<td><a title=\"Supprimé code disponible\" href='deletekey.php?code=".$code."'><i class='bx bxs-trash' style='color:#e0a90a'  ></i></a></td>";
            break;
        case 'distribué':
            $code=$row["code"];
            echo "<td><a title=\"Attention ce code a déja été communiqué\" href='deletekey.php?code=".$code."'><i class='bx bxs-trash' style='color:#e40741'  ></i></td>";
            break;
        default:
            # code...
            break;
    }
    
    
    echo "</tr>";
}
echo "<tr>";
echo "<td colspan=\"4\"><a title=\"Ajouté un code\" href='addcode.php'><i class='bx bx-folder-plus' style='color:#0ec4c1'  ></i></a></td>";
echo "</tr>";

echo "</table>";
echo "</div>";
} catch (PDOException $e) {
    // Gérez les erreurs PDO de manière appropriée
    die("Erreur : " . $e->getMessage());
}

// Fermeture de la connexion
include "../deconnexion.php";
?>
