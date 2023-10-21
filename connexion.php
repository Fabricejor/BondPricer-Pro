<?php
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname='bondpricebd';
    //On essaie de se connecter
    try{
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    
    /*On capture les exceptions si une exception est lancée et on affiche
     *les informations relatives à celle-ci*/
    catch(PDOException $e){
        $erreur_message = "Erreur : " . $e->getMessage();

                 // Chemin complet vers le fichier d'erreur dans un autre répertoire
            $chemin_fichier_erreur = '/Acces/error.log.txt';

            // Écriture du message d'erreur dans le fichier
            file_put_contents($chemin_fichier_erreur, $erreur_message, FILE_APPEND);
            echo "une erreur sést produite";
    }

    // on ferme la connexion
    // $conn = null;
?>