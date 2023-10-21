<?php 
session_start();
if (!isset($_SESSION['user'])) {
    header("location: index.php");
    exit();
}
$erreur = "";
$succes="";
if (isset($_POST["submit"])) {
    if (isset($_POST["code"]) && !empty($_POST["code"]) ) {
        $code = $_POST["code"];
        $code = htmlspecialchars($code);
        try {
            include "../connexion.php";
            // Vérification dans la table "clés"
        $requete_cles = $conn->prepare("SELECT * FROM clés WHERE BINARY code = :code");
        $requete_cles->bindParam(':code', $code);
        $requete_cles->execute();
        if ($requete_cles->rowCount() > 0) {
            // Correspondance trouvée dans la table "clés"
            $erreur = "Le code existe déja comme 'clés'.";
            include '../deconnexion.php';
        } else {
            // Aucune correspondance trouvée dans la table "clés", vérification dans la table "client"
            $requete_client = $conn->prepare("SELECT * FROM client WHERE BINARY code = :code");
            $requete_client->bindParam(':code', $code);
            $requete_client->execute();

            if ($requete_client->rowCount() > 0) {
                // Correspondance trouvée dans la table "client"
                $erreur = "Ce code a déja été utilisé par l'un de vos client.";
                include '../deconnexion.php';
            } else {
                $date = date('Y-m-d');
                $acces = "disponible";
                $sql = "INSERT INTO clés (code, date, Acces)
                VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$code, $date, $acces]);
                include '../deconnexion.php';

                // Aucune correspondance trouvée dans aucune des deux tables
                $succes = "Ok le code".$code."a été crée.";
            }
        }
        } catch (PDOException $e) {
            echo "<script> alert('Une erreur s'est produite')</script>";
            include '../deconnexion.php';
            echo "Erreur de connexion à la base de données : " . $e->getMessage();
            // header("location: dashboard.php");
            // exit();
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
    <link rel="shortcut icon" href="../images/code.png" type="image/x-icon">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');

*{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: "Poppins", sans-serif;
}

body{
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    background:url("../images/addcodebackground.jpg") no-repeat;
    background-size: cover;
    background-position: center;
    width: 100%;
}

.wrapper{
    width: 420px;
    background: transparent;
    border: 2px solid rgba(255, 255, 255, 0.731);
    backdrop-filter: blur(20px);
    box-shadow: 0 0 10px rgba(0 , 0 , 0 , .1);
    color: #fff;
    border-radius: 10px;
    padding: 30px 40px;
}

.wrapper h1{
    font-size: 36px;
    text-align: center;
}
.wrapper .input-box{
    position: relative;
    width: 100%;
    height: 50px;
    margin: 30px 0;
}
.input-box input{
    width: 100%;
    height: 100%;
    background: transparent;
    border: none;
    outline: none;
    border: 2px solid rgba(255,255,255, .2);
    border-radius: 40px;
    font-size: 16px;
    color: #fff;
    padding: 20px 45px 20px 20px;
}

.input-box input::placeholder{
    color: #fff;;
}

.input-box i{
    position: absolute;
    right: 20px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 20px;
}

.wrapper .remember-forgot{
    display: flex;
    justify-content: space-between;
    font-size: 14.5px;
    margin: -15px 0 15px;
}
.remember-forgot label input{
    accent-color: #fff;
    margin-right: 3px;
}
.remember-forgot a{
    color: #fff;
    text-decoration: none;
}
.remember-forgot a:hover{
    text-decoration: underline;
}
.wrapper .btn{
    width: 100%;
    height: 45px;
    background: #fff;
    border: none;
    outline: none;
    border-radius: 40px;
    box-shadow: 0 0 10px rgba(0 , 0 , 0 , .1);
    cursor: pointer;
    font-size: 16px;
    color: #333;
    font-weight: 600;
}

.wrapper .register-link{
    font-size: 14.5px;
    text-align: center;
    margin: 20px 0 15px;
}

.register-link p a{
    color: #fff;
    text-decoration: none;
    font-weight: 600;
}

.register-link p a:hover{
    text-decoration: underline;
}

button{
    position: relative;
    border: none;
    transition: .4s ease-in;
    z-index: 1;
}
button::before,
button:after{
    position: absolute;
    content: "";
    z-index: 1;
}

.btn:hover{
    background: #0f969c;
    color: #fff;
    box-shadow: 0 0 5px #0f969c , 0 0 25px  #0f969c, 0 0 50px #0f969c , 0 0 200px #0f969c ;
    transform: scale(0.9);
}

.erreur{
    color:red;
    margin: 10px 0;
    text-align: center;
}
.succes{
    color:greenyellow;
    margin: 10px 0;
    text-align: center;
}
    </style>
</head>

<body>
    <div class="wrapper">
        <form action="" method="post">
            <h1>BondPrice code Generator</h1>
            <?php
                if (isset($erreur) && !empty($erreur)) {
                    print "<p class='erreur'>" . $erreur . "</p>"; // Si la variable erreur existe, alors on l'affiche
                }else {
                    print "<p class='succes'>" . $succes . "</p>"; // Si la variable erreur existe, alors on l'affiche
                }
            ?>
            <div class="input-box">
                <input type="text" name="code" id="code" placeholder="Code d'accès"  maxlength="10">
                <i class='bx bxs-lock'></i>
            </div>
            <div class="remember-forgot">
                <a title="Retour au dashboard" href="dashboard.php"><i class='bx bxs-dashboard bx-tada' style='color:#1fba62; width:102px;'></i></a>
            </div>
            <button type="submit" class="btn" name="submit">Ajouter un code d'acces</button>
        </form>
    </div>
</body>
</html>
