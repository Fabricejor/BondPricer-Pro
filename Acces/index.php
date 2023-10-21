<?php
session_start();
date_default_timezone_set('Africa/Dakar');
$date = date('Y-m-d');
$heure = date('H:i:s');
if (isset($_COOKIE['code'])) {
    
    if (isset($_POST['submit'])) {
        // Récupération des données du formulaire
        $nom = filter_var($_POST['nom'], FILTER_SANITIZE_STRING);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $tel = filter_var($_POST['tel'], FILTER_SANITIZE_STRING);
        $nom_entreprise = filter_var($_POST['NomEntreprise'], FILTER_SANITIZE_STRING);
        $activite = filter_var($_POST['activité'], FILTER_SANITIZE_STRING);
        $poste = filter_var($_POST['poste'], FILTER_SANITIZE_STRING);
        $commentaires = filter_var($_POST['question'], FILTER_SANITIZE_STRING);
        $informations_additionnelles = filter_var($_POST['autres'], FILTER_SANITIZE_STRING);
        $date_creation = date('Y-m-d');
        $code_acces = @$_SESSION['code'];
        
        // Inclure le fichier de connexion à la base de données
        include '../connexion.php';
        try {
            $nom = htmlentities($nom, ENT_QUOTES, 'UTF-8');
            $email = htmlentities($email, ENT_QUOTES, 'UTF-8');
            $tel = htmlentities($tel, ENT_QUOTES, 'UTF-8');
            $nom_entreprise = htmlentities($nom_entreprise, ENT_QUOTES, 'UTF-8');
            $activite = htmlentities($activite, ENT_QUOTES, 'UTF-8');
            $poste = htmlentities($poste, ENT_QUOTES, 'UTF-8');
            $commentaires = htmlentities($commentaires, ENT_QUOTES, 'UTF-8');
            $informations_additionnelles = htmlentities($informations_additionnelles, ENT_QUOTES, 'UTF-8');
            // Préparez et exécutez la requête d'insertion
            $sql = "INSERT INTO client (nom, email, tel, entreprise, secteur, fonction, enquete, infoadd, datecode, code,heure)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$nom, $email, $tel, $nom_entreprise, $activite, $poste, $commentaires, $informations_additionnelles, $date_creation, $code_acces,$heure]);
            include '../deconnexion.php';

            $_SESSION['proges']=1;
            // Redirigez l'utilisateur vers une page de confirmation ou une autre page
            header('location:remerciement.php');
            echo '<script type="text/javascript">';
            echo 'window.location.href = "remerciement.php";'; // Remplacez "nouvelle_page.php" par l'URL de la page de redirection
            echo '</script>';
            exit();
        } catch (PDOException $e) {
            echo "<script> alert('Une erreur s'est produite')</scritp>";
            $donnees_csv = array(
                'Nom' => $nom,
                'Email' => $email
            );
            $nom_fichier_csv = 'donnees.csv';
            $fichier_csv = fopen($nom_fichier_csv, 'a'); // Utilisez 'a' pour ajouter des données à un fichier existant
            fputcsv($fichier_csv, $donnees_csv);
            fclose($fichier_csv);
            // Enregistrez un message d'erreur dans un fichier de journal personnalisé
            error_log('Erreur MySQL : ' . $e->getMessage(), 3, 'error.log.text');
            // Redirigez l'utilisateur vers une page d'erreur générique
            include '../deconnexion.php';
            header("location: ../index.php");
            exit();
        }
    }
} else {
    header('location:../index.php');
}
?>

<!-- formulaire d'enquette uniquement -->
<!DOCTYPE html>
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!----======== CSS ======== -->
    <link rel="stylesheet" href="Assets/style.css">
    <!----===== Iconscout CSS ===== -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="shortcut icon" href="../images/bondPriceLogo.png" type="image/x-icon">

    <title>Enquete-formulaire</title>

</head>

<body>
    <script type="text/javascript">
        alert(" Votre code d'acces viens d'etre consomé .Remplissez le formulaire avant d'acceder au logiciel. Vous avez 5 minutes.");
    </script>
    <div class="container">
        <header>Formulaire téléchargement BondPricer Pro</header>

        <form action="" method="POST">
            <div class="form first">
                <div class="details personal">
                    <span class="title">Détails personnels</span>

                    <div class="fields">
                        <div class="input-field">
                            <label>Nom Complet</label>
                            <input type="text" name="nom" placeholder="Votre Nom Complet" required>
                        </div>

                        <div class="input-field">
                            <label>E-mail</label>
                            <input type="email" name="email" placeholder="Votre Email" required>
                        </div>

                        <div class="input-field">
                            <label>télephone(avec indicatif sans le '+')</label>
                            <input type="number" name="tel" placeholder="Ex:221771234567" required>
                        </div>
                    </div>
                </div>

                <div class="details ID">
                    <span class="title">Détails de l'entreprise</span>

                    <div class="fields">
                        <div class="input-field">
                            <label>Nom de l'entreprise</label>
                            <input type="text" name="NomEntreprise" placeholder="Nom complet de l'entreprise" required>
                        </div>

                        <div class="input-field">
                            <label>Secteur d'activité</label>
                            <select name="activité" id="activité">
                                <option value="Aérospatiale">Aérospatiale</option>
                                <option value="Agriculture">Agriculture</option>
                                <option value="Alimentation et Boissons">Alimentation et Boissons</option>
                                <option value="Assurance">Assurance</option>
                                <option value="Automobile">Automobile</option>
                                <option value="Banque et Finance">Banque et Finance</option>
                                <option value="Commerce de détail">Commerce de détail</option>
                                <option value="Divertissement">Divertissement</option>
                                <option value="Éducation">Éducation</option>
                                <option value="Énergie">Énergie</option>
                                <option value="Fabrication">Fabrication</option>
                                <option value="Gouvernement">Gouvernement</option>
                                <option value="Hôtellerie et Tourisme">Hôtellerie et Tourisme</option>
                                <option value="Immobilier">Immobilier</option>
                                <option value="Microfinance">Microfinance</option>
                                <option value="Organisations à but non lucratif">Organisations à but non lucratif</option>
                                <option value="Pharmaceutique">Pharmaceutique</option>
                                <option value="Santé">Santé</option>
                                <option value="Services environnementaux">Services environnementaux</option>
                                <option value="Sociétés de gestion et d'intermédiation">Sociétés de gestion et d'intermédiation</option>
                                <option value="Télécommunications">Télécommunications</option>
                                <option value="Technologie">Technologie</option>
                                <option value="Transport">Transport</option>
                                <option value="autres">Autres</option>
                            </select>
                        </div>

                        <div class="input-field">
                            <label>Votre Fonction </label>
                            <input type="text" name="poste" placeholder="Poste occupé dans l'entreprise" required>
                        </div>

                        <div class="input-field">
                            <label>comment avez vous entendu parler de nous ?</label>
                            <textarea placeholder="Votre message" name="question" class="enquete" name="message" cols="60" rows="4"></textarea>
                        </div>
                    </div>

                    <button class="nextBtn">
                        <span class="btnText">suivant</span>
                        <i class="uil uil-navigator"></i>
                    </button>
                </div>
            </div>

            <div class="form second">
                <div class="details address">
                    <span class="title">Conditions contrats</span>

                    <div class="fields">
                        <div class="input-field">
                            <label>Informations Additionels</label>
                            <input type="text" name="autres" placeholder="Autres informations?">
                        </div>

                        <div class="input-field">
                            <label>Code d'acces utilisé le:</label>
                            <input type="text" name="date" value="<?php echo @$date; ?>" placeholder="Date d'aujourdhui" readonly>
                        </div>

                        <div class="input-field">
                            <label>Clés d'acces unique</label>
                            <input type="text" name="clé" placeholder="la cles d'acces" disabled value="<?php echo @$_SESSION['code']; ?>">
                        </div>

                    </div>
                </div>

                <div class="details family">
                    <span class="title">Conditions d'utilisations</span>

                    <div class="fields">
                        <div class="input-field">
                            <label>le conrats</label>
                            <textarea placeholder="Votre message" name="contrat" disabled readonly class="enquete" name="message" cols="70" rows="4">En remplissant ce formulaire, vous acceptez de recevoir l'accès à notre outil Excel de tarification d'obligations. Vous autorisez également Votre Entreprise à vous contacter par e-mail pour vous fournir des mises à jour et des informations liées à l'outil. Nous respectons votre vie privée et ne partagerons pas vos informations avec des tiers.</textarea>
                        </div>

                        <div class="input-field">
                            <input type="checkbox" name="accepte" required>
                            <label>J'accepte les conditions</label>
                        </div>

                        <div class="input-field">
                            <input type="checkbox" name="accepte1" required>
                            <label>Je confirme que j'accepte</label>
                        </div>
                    </div>

                    <div class="buttons">
                        <div class="backBtn">
                            <i class="uil uil-navigator"></i>
                            <span class="btnText">Précédent</span>
                        </div>

                        <button class="sumbit" type="submit" name="submit">
                            <span class="btnText">Valider</span>
                            <i class="uil uil-check-circle"></i>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script src="Assets/script.js"></script>
</body>

</html>