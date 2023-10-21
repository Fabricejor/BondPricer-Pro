<?php 
session_start();
if (!isset($_SESSION['user'])) {
    header("location: index.php");
    exit();
}
include_once "../connexion.php";
$id = $_GET['id'];

$query = "SELECT * FROM client WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->execute([$id]);

    $resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($resultats as $row) {
        $nom= $row["nom"];
        $email= $row["email"];
        $tel=$row["tel"];
        $entreprise=$row["entreprise"];
        $secteur=$row["secteur"];
        $fonction=$row["fonction"];
        $enquete=$row["enquete"];
        $infoadd=$row["infoadd"];
        $date=$row["datecode"] ;
        $code=$row["code"];
        $heure=$row["heure"];
    }

    if (isset($_POST['submit'])) {
        $nom = htmlentities($_POST['nom'], ENT_QUOTES, 'UTF-8');
        $email = htmlentities($_POST['email'], ENT_QUOTES, 'UTF-8');
        $tel = htmlentities($_POST['tel'], ENT_QUOTES, 'UTF-8');
        $nom_entreprise = htmlentities($_POST['NomEntreprise'], ENT_QUOTES, 'UTF-8');
        $activite = htmlentities($_POST['activité'], ENT_QUOTES, 'UTF-8');
        $poste = htmlentities($_POST['poste'], ENT_QUOTES, 'UTF-8');
        $commentaires = htmlentities($_POST['question'], ENT_QUOTES, 'UTF-8');
        $informations_additionnelles = htmlentities($_POST['autres'], ENT_QUOTES, 'UTF-8');
        $date_creation = htmlentities($_POST['date'], ENT_QUOTES, 'UTF-8');
        $code_acces = htmlentities($_POST['clé'], ENT_QUOTES, 'UTF-8');
        try{
            $sql = "UPDATE client SET nom = ?, email = ?, tel = ?, entreprise = ?, secteur = ?, fonction = ?, enquete = ?, infoadd = ?, datecode = ?, code = ?, heure = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$nom, $email, $tel, $nom_entreprise, $activite, $poste, $commentaires, $informations_additionnelles, $date_creation, $code_acces,$heure,$id]);
            include '../deconnexion.php';            
            echo '<script type="text/javascript">';
            echo 'window.location.href = "dashboard.php";'; // Remplacez "nouvelle_page.php" par l'URL de la page de redirection
            echo '</script>';
            exit();
        }catch (PDOException $e) {
            echo "<script> alert('Une erreur s'est produite')</scritp>";
            include '../deconnexion.php';
            header("location: dashboard.php");
            exit();
        }
    }
?>

<!DOCTYPE html>
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!----======== CSS ======== -->
    <!----===== Iconscout CSS ===== -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="shortcut icon" href="../images/modifclient.png" type="image/x-icon">

    <title>Modifications infos client</title>
    <style>
        /* ===== Google Font Import - Poppins ===== */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #0f969c;
        }

        .container {
            position: relative;
            max-width: 900px;
            width: 100%;
            border-radius: 6px;
            padding: 30px;
            margin: 0 15px;
            background-color: #fff;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
        }

        .container header {
            position: relative;
            font-size: 20px;
            font-weight: 600;
            color: #333;
        }

        .container header::before {
            content: "";
            position: absolute;
            left: 0;
            bottom: -2px;
            height: 3px;
            width: 27px;
            border-radius: 8px;
            background-color: #0f969c;
        }

        .container form {
            position: relative;
            margin-top: 16px;
            min-height: 490px;
            background-color: #fff;
            overflow: hidden;
        }

        .container form .form {
            position: absolute;
            background-color: #fff;
            transition: 0.3s ease;
        }

        .container form .form.second {
            opacity: 0;
            pointer-events: none;
            transform: translateX(100%);
        }

        form.secActive .form.second {
            opacity: 1;
            pointer-events: auto;
            transform: translateX(0);
        }

        form.secActive .form.first {
            opacity: 0;
            pointer-events: none;
            transform: translateX(-100%);
        }

        .container form .title {
            display: block;
            margin-bottom: 8px;
            font-size: 16px;
            font-weight: 500;
            margin: 6px 0;
            color: #333;
        }

        .container form .fields {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        form .fields .input-field {
            display: flex;
            width: calc(100% / 3 - 15px);
            flex-direction: column;
            margin: 4px 0;
        }

        .input-field label {
            font-size: 12px;
            font-weight: 500;
            color: #2e2e2e;
        }

        .input-field input,
        select {
            outline: none;
            font-size: 14px;
            font-weight: 400;
            color: #333;
            border-radius: 5px;
            border: 1px solid #aaa;
            padding: 0 15px;
            height: 42px;
            margin: 8px 0;
        }

        .input-field input:is(:focus, :valid),
        .input-field textarea:is(:focus) {
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.13);
            outline-color: #0f969c;
            outline-style: outset;
        }

        .input-field input :focus,
        .input-field select:focus {
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.13);
        }

        .input-field select,
        .input-field input[type="date"] {
            color: #707070;
        }

        .input-field input[type="date"]:valid {
            color: #333;
        }

        .container form button,
        .backBtn {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 45px;
            max-width: 200px;
            width: 100%;
            border: none;
            outline: none;
            color: #fff;
            border-radius: 5px;
            margin: 25px 0;
            background-color: #0f969c;
            transition: all 0.3s linear;
            cursor: pointer;
        }

        .container form .btnText {
            font-size: 14px;
            font-weight: 400;
        }

        form button:hover {
            background-color: #163489;
            transform: scale(0.9);
        }

        form button i,
        form .backBtn i {
            margin: 0 6px;
        }

        form .backBtn i {
            transform: rotate(180deg);
        }

        form .buttons {
            display: flex;
            align-items: center;
        }

        form .buttons button,
        .backBtn {
            margin-right: 14px;
        }

        .enquete {
            width: 100%;
            border-radius: 5px;
        }

        textarea {
            resize: none;
        }

        @media (max-width: 750px) {
            .container form {
                overflow-y: scroll;
            }

            .container form::-webkit-scrollbar {
                display: none;
            }

            form .fields .input-field {
                width: calc(100% / 2 - 15px);
            }
        }

        @media (max-width: 550px) {
            form .fields .input-field {
                width: 100%;
            }
        }
    </style>

</head>

<body>
    <div class="container">
        <header>Modifications Informations client  BondPricer Pro</header>

        <form action="" method="POST">
            <div class="form first">
                <div class="details personal">
                    <span class="title">Détails personnels</span>

                    <div class="fields">
                        <div class="input-field">
                            <label>Nom Complet</label>
                            <input type="text" name="nom" value="<?php echo $nom ?>" required>
                        </div>

                        <div class="input-field">
                            <label>E-mail</label>
                            <input type="email" name="email" value="<?php echo $email ?>" required>
                        </div>

                        <div class="input-field">
                            <label>télephone(avec indicatif sans le '+')</label>
                            <input type="text" name="tel" value="<?php echo $tel ?>" required>
                        </div>
                    </div>
                </div>

                <div class="details ID">
                    <span class="title">Détails de l'entreprise</span>

                    <div class="fields">
                        <div class="input-field">
                            <label>Nom de l'entreprise</label>
                            <input type="text" name="NomEntreprise" value="<?php echo $entreprise ?>" required>
                        </div>

                        <div class="input-field">
                            <label>Secteur d'activité</label>
                            <select name="activité" id="activité">
                                <option value="<?php echo $secteur ?>" selected><?php echo $secteur ?></option>
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
                            <input type="text" name="poste" value="<?php echo $fonction ?>" required>
                        </div>

                        <div class="input-field">
                            <label>comment avez vous entendu parler de nous ?</label>
                            <textarea value="<?php echo $enquete ?>" name="question" class="enquete" name="message" readonly cols="60" rows="4"><?php echo $enquete ?></textarea>
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
                            <input type="text" name="autres" value="<?php echo $infoadd ?>" readonly>
                        </div>

                        <div class="input-field">
                            <label>Code d'acces utilisé le:</label>
                            <input type="text" name="date" value="<?php echo $date; ?>" placeholder="Date d'aujourdhui" readonly>
                        </div>

                        <div class="input-field">
                            <label>Clés d'acces unique</label>
                            <input type="text" name="clé" placeholder="la cles d'acces" readonly value="<?php echo $code; ?>">
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

    <script>
        const form = document.querySelector("form"),
            nextBtn = form.querySelector(".nextBtn"),
            backBtn = form.querySelector(".backBtn"),
            allInput = form.querySelectorAll(".first input");


        nextBtn.addEventListener("click", () => {
            allInput.forEach(input => {
                if (input.value != "") {
                    form.classList.add('secActive');
                } else {
                    form.classList.remove('secActive');
                }
            })
        })

        backBtn.addEventListener("click", () => form.classList.remove('secActive'));
    </script>
</body>

</html>