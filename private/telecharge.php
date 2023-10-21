<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("location: index.php");
    exit();
}
include_once "../connexion.php";


// Load the database configuration file 

// Filter the excel data 
function filterData(&$str)
{
    $str = preg_replace("/\t/", "\\t", $str);
    $str = preg_replace("/\r?\n/", "\\n", $str);
    if (strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
}

// Excel file name for download 
$fileName = "Bond_pricer_client" . date('Y-m-d') . ".xls";

// Column names 
$fields = array('ID', 'Nom complet', 'Email', 'Numero de telephone', 'Entreprise', 'Secteur activite ', 'Fonction du client', 'Reponse a l\'enquete' ,'informations supplementaire' , 'Date' , 'code utilise', 'heure');

// Display column names as first row 
$excelData = implode("\t", array_values($fields)) . "\n";

// Fetch records from database 
$query = $conn->query("SELECT * FROM client ORDER BY id ASC");
if ($query->rowCount() > 0) {
    // Output each row of the data 
    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        $lineData = array($row['id'], $row['nom'], $row['email'], $row['tel'], $row['entreprise'], $row['secteur'], $row['fonction'],$row['enquete'],$row['infoadd'],$row['datecode'],$row['code'],$row['heure'] );
        array_walk($lineData, 'filterData');
        $excelData .= implode("\t", array_values($lineData)) . "\n";
    }
} else {
    $excelData .= 'No records found...' . "\n";
}

// Headers for download 
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=\"$fileName\"");

// Render excel data 
echo $excelData;

exit;
?>