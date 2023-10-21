<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("location: index.php");
    exit();
}


if (isset($_POST["submit"])) {
    include_once "../connexion.php";
    
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);
    $confirmPassword = filter_input(INPUT_POST, "confirmPassword", FILTER_SANITIZE_STRING);

    if (!empty($password) && !empty($confirmPassword)) {
        if ($password === $confirmPassword) {
            // Les mots de passe correspondent, hachez le mot de passe
            $hashedPassword = $password;
            
            // Mettez à jour le mot de passe haché dans la base de données
            $user = $_SESSION["user"];
            
            try {
                $query = "UPDATE administrateur SET mdp = :mdp WHERE User = :user";
                $stmt = $conn->prepare($query);
                $stmt->bindParam(':mdp', $hashedPassword, PDO::PARAM_STR);
                $stmt->bindParam(':user', $user, PDO::PARAM_STR);
                $stmt->execute();
                
                header("location: dashboard.php");
                // Vous pouvez ajouter un indicateur de succès si nécessaire pour JavaScript
            } catch (PDOException $e) {
                // Vous pouvez ajouter un indicateur d'erreur si nécessaire pour JavaScript
            }
        } 
    }
}




?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../images/mdp.png" type="image/png">
    <title>changement de mot de passe</title>

</head>
<style>
    .mainDiv {
        display: flex;
        min-height: 100%;
        align-items: center;
        justify-content: center;
        background-color: #f9f9f9;
        font-family: 'Open Sans', sans-serif;
    }

    .cardStyle {
        width: 500px;
        border-color: white;
        background: #fff;
        padding: 36px 0;
        border-radius: 4px;
        margin: 30px 0;
        box-shadow: 0px 0 2px 0 rgba(0, 0, 0, 0.25);
    }

    #signupLogo {
        max-height: 100px;
        margin: auto;
        display: flex;
        flex-direction: column;
    }

    .formTitle {
        font-weight: 600;
        margin-top: 20px;
        color: #2F2D3B;
        text-align: center;
    }

    .inputLabel {
        font-size: 12px;
        color: #555;
        margin-bottom: 6px;
        margin-top: 24px;
    }

    .inputDiv {
        width: 70%;
        display: flex;
        flex-direction: column;
        margin: auto;
    }

    input {
        height: 40px;
        font-size: 16px;
        border-radius: 4px;
        border: none;
        border: solid 1px #ccc;
        padding: 0 11px;
    }

    input:disabled {
        cursor: not-allowed;
        border: solid 1px #eee;
    }

    .buttonWrapper {
        margin-top: 40px;
    }

    .submitButton {
        width: 70%;
        height: 40px;
        margin: auto;
        display: block;
        color: #fff;
        background-color: #065492;
        border-color: #065492;
        text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.12);
        box-shadow: 0 2px 0 rgba(0, 0, 0, 0.035);
        border-radius: 4px;
        font-size: 14px;
        cursor: pointer;
    }

    .submitButton:disabled,
    button[disabled] {
        border: 1px solid #cccccc;
        background-color: #cccccc;
        color: #666666;
    }

    #loader {
        position: absolute;
        z-index: 1;
        margin: -2px 0 0 10px;
        border: 4px solid #f3f3f3;
        border-radius: 50%;
        border-top: 4px solid #666666;
        width: 14px;
        height: 14px;
        -webkit-animation: spin 2s linear infinite;
        animation: spin 2s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>

<body>
    <div class="mainDiv">
        <div class="cardStyle">
            <form action="#" method="POST" name="signupForm" id="signupForm">

                <img src="" id="signupLogo" />

                <h2 class="formTitle">
                    Vous allez changez de mot de passe!!!
                </h2>

                <div class="inputDiv">
                    <label class="inputLabel" for="password">Nouveau Mot de passe</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <div class="inputDiv">
                    <label class="inputLabel" for="confirmPassword">comfirmez le nouveau mot de passe</label>
                    <input type="password" id="confirmPassword" name="confirmPassword">
                </div>

                <div class="buttonWrapper">
                    <button type="submit" name="submit" id="submitButton" onclick="validateSignupForm()" class="submitButton pure-button pure-button-primary">
                        <span>Continue</span>
                        <span id="loader"></span>
                    </button>
                </div>

            </form>
        </div>
    </div>
</body>

<script>
    var password = document.getElementById("password"),
        confirm_password = document.getElementById("confirmPassword");

    document.getElementById('signupLogo').src = "../images/AIP.png";
    enableSubmitButton();

    function validatePassword() {
        if (password.value != confirm_password.value) {
            confirm_password.setCustomValidity("Tapez le meme mot de passe");
            return false;
        } else {
            confirm_password.setCustomValidity('');
            return true;
        }
    }

    password.onchange = validatePassword;
    confirm_password.onkeyup = validatePassword;

    function enableSubmitButton() {
        document.getElementById('submitButton').disabled = false;
        document.getElementById('loader').style.display = 'none';
    }

    function disableSubmitButton() {
        document.getElementById('submitButton').disabled = true;
        document.getElementById('loader').style.display = 'unset';
    }

    function validateSignupForm() {
        var form = document.getElementById('signupForm');

        for (var i = 0; i < form.elements.length; i++) {
            if (form.elements[i].value === '' && form.elements[i].hasAttribute('required')) {
                console.log('There are some required fields!');
                return false;
            }
        }

        if (!validatePassword()) {
            return false;
        }

    }
</script>

</html>