<?php
session_start();
$erreur = "";

// Protection contre les attaques CSRF : Génération et stockage du jeton CSRF
if (isset($_POST['submit'])) {
    include 'connexion.php';

    // Protection contre les injections SQL : Utilisation de déclarations préparées
    $code =htmlspecialchars($_POST['code'] ,ENT_QUOTES , 'UTF-8');

    // Validation du code d'accès alphanumérique (chiffres et lettres)
    if (!preg_match('/^[\p{L}0-9]+$/u', $code)) {
        // Code d'accès invalide, gérer l'erreur.
        $erreur = "Code d'accès invalide.";
    } else {
        $code = htmlspecialchars($code ,ENT_QUOTES , 'UTF-8');
        $sql = "SELECT * FROM clés WHERE code = ?";
        $result = $conn->prepare($sql);
        $result->execute([$code]);

        if ($result->rowCount() === 1) {
            // ALGORITHME KÉCÉ mo la si Guéné
            // 1. Le système range la donnée dans une variable plus globale
            $_SESSION['code'] = $code;
            //creation de cookie aussi
            $cookie_name = 'code';
            $cookie_value = $_SESSION['code'];
            $secure = true; // Le cookie ne sera envoyé que sur une connexion sécurisée
            $httponly = true; // Le cookie ne sera accessible que via le protocole HTTP(S), pas avec JavaScript
            setcookie($cookie_name, $cookie_value, [
                'expires' => time() + (5 * 60), // 5min 
                'path' => '/',
                'domain' => $_SERVER['HTTP_HOST'], // ou spécifiez votre domaine
                'secure' => $secure,
                'httponly' => $httponly,
                'samesite' => 'Strict' // Empêche le navigateur d'envoyer ce cookie avec des requêtes intersites
            ]);
            // 2. Le système supprime l'élément dans la BD
            $delete = "DELETE FROM clés WHERE `code` = ?";
            $drop = $conn->prepare($delete);
            $drop->execute([$code]);
            
            // 3. Le système redirige l'utilisateur vers la page demandée
            header("location: Acces/index.php");
            exit();
        } else {
            $erreur = "Ce code d'accès n'existe pas ou a expiré.";
            include 'deconnexion.php';
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BondPrice Access Portal</title>
    <link rel="shortcut icon" href="images/bondPriceLogo.png" type="image/x-icon">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="wrapper">
        <form action="" method="post">
            <h1>BondPricer Access Portal</h1>
            <?php
                if (isset($erreur)) {
                    print "<p class='erreur'>" . $erreur . "</p>"; // Si la variable erreur existe, alors on l'affiche
                }
            ?>
            <div class="input-box">
                <input type="password" name="code" id="code" placeholder="Code d'accès" required maxlength="10">
                <i class='bx bxs-lock'></i>
            </div>
            <div class="remember-forgot">
                <a href="mailto:ramos.jn.pro@gmail.com">Contacter le fournisseur</a>
            </div>
            <button type="submit" class="btn" name="submit">Accéder au logiciel</button>
        </form>
    </div>
</body>
</html>
