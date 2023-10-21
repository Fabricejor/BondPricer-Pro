<?php
session_start();
$erreur = "";
$datejour=date('Y-m-d');
// Protection contre les attaques CSRF : Génération et stockage du jeton CSRF


if (isset($_POST['submit'])) {
    include '../connexion.php';

    $user = $_POST['user'];//peut etre remplacer par les mails
    $mdp = $_POST['password'];

    // Protection contre les injections SQL : Utilisation de déclarations préparées
    $user = htmlentities($user ,ENT_QUOTES , 'UTF-8');
    $mdp = htmlentities($mdp ,ENT_QUOTES , 'UTF-8');
    
    // Validation du code d'accès alphanumérique (chiffres et lettres)
    if (!preg_match('/^[a-zA-Z0-9]+$/', $user) || !preg_match('/^[a-zA-Z0-9]+$/', $mdp)) {
        // Nom d'utilisateur ou mot de passe invalide, gérer l'erreur.
        $erreur = "Nom d'utilisateur ou mot de passe invalide.";
    } else {
        $user = htmlentities($user ,ENT_QUOTES , 'UTF-8');
        $mdp = htmlentities($mdp ,ENT_QUOTES , 'UTF-8');
        $sql = "SELECT * FROM administrateur WHERE User = ? AND mdp = ?";
        $result = $conn->prepare($sql);
        $result->execute([$user, $mdp]);

        if ($result->rowCount() === 1) {
            // L'utilisateur est authentifié avec succès
            try {
                // Requête SQL pour mettre à jour la date de l'administrateur spécifique
                $query = "UPDATE administrateur SET Date = :nouvelleDate WHERE User = :user";
                $stmt = $conn->prepare($query);
            
                // Liaison des paramètres
                $stmt->bindParam(':nouvelleDate', $datejour, PDO::PARAM_STR);
                $stmt->bindParam(':user', $user, PDO::PARAM_STR);
            
                // Exécution de la requête
                $stmt->execute();
                //recuperation de l'adresse mail
                $queryEmail = "SELECT email FROM administrateur WHERE User = :user";
                $stmtEmail = $conn->prepare($queryEmail);
                $stmtEmail->bindParam(':user', $user, PDO::PARAM_STR);
                $stmtEmail->execute();
                if ($stmtEmail->rowCount() === 1) {
                    // Récupérez l'adresse email de l'administrateur
                    $rowEmail = $stmtEmail->fetch(PDO::FETCH_ASSOC);
                    $mail = $rowEmail['email'];
                    // Maintenant, $mail contient l'adresse email de l'administrateur
                }

            // ici faudra plasser un include pour les messages mail:
            $_SESSION['adminMail']=$mail;
            } catch (PDOException $e) {
                // Gérer les erreurs PDO de manière appropriée
                echo "Erreur : " . $e->getMessage();
            }
            $_SESSION['user'] = $user;
            $cookie_name = 'user';
            $cookie_value = $_SESSION['user'];
            $secure = true; // Le cookie ne sera envoyé que sur une connexion sécurisée
            $httponly = true; // Le cookie ne sera accessible que via le protocole HTTP(S), pas avec JavaScript
            setcookie($cookie_name, $cookie_value, [
                'expires' => time() + (240 * 60), // 4h = 260min 
                'path' => '/',
                'domain' => $_SERVER['HTTP_HOST'], // ou spécifiez votre domaine
                'secure' => $secure,
                'httponly' => $httponly,
                'samesite' => 'Strict' // Empêche le navigateur d'envoyer ce cookie avec des requêtes intersites
            ]);
            header("location: dashboard.php");
            exit();


        } else {
            $erreur = "Nom d'utilisateur ou mot de passe incorrect.";
            include '../deconnexion.php';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BondPrice tool private</title>
    <link rel="shortcut icon" href="../images/connexion.png" type="image/x-icon">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="wrapper">
        <form action="" method="POST">
            <h1>BondPrice Gestion</h1>
            <?php
                if (isset($erreur)) {
                    print "<p class='erreur'>" . $erreur . "</p>"; // Si la variable erreur existe, alors on l'affiche
                }
            ?>
            <div class="input-box">
                <input type="text" name="user" id="user" placeholder="Nom utilisateur" required>
                <i class='bx bxs-user bx-tada bx-flip-horizontal'></i>
            </div>
            <div class="input-box">
                <input type="password" name="password" id="password" placeholder="Mot de passe" maxlength="10" required>
                <i class='bx bxs-lock'></i>
            </div>
            
            <div class="remember-forgot">
                <label> <input type="checkbox">Se souvenir de moi</label>
                <a href="mailto:fabricejordan2001@gmail.com">Contact admin</a>
            </div>
            <button type="submit" class="btn" name="submit">Se connecter</button>
        </form>
    </div>
</body>
</html>
