<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../images/exceller.png" type="image/png">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="dashboard.css">
    <title>Menu Gestion bondpricer</title>
</head>

<body class="light-mode">
    <div class="sidebar">
        <div class="logo_content">
            <div class="logo">
                <i class='bx bxs-briefcase'></i>
                <div class="logo_name">BondPrice</div>
            </div>
            <i class='bx bx-menu'id="btn" class="btn"></i>
        </div>
        <ul class="nav_list">
            <li>
                <i class='bx bx-search'></i>
                <input type="text" placeholder="search">
                <span class="tooltip">search</span>
            </li>
            <li>
                <a href="#" id="lien1">
                    <i class='bx bxs-dashboard'></i>
                    <span class="links_name">Dashboard</span>
                </a>
                <span class="tooltip">Dashboard</span>
            </li>
            <li>
                <a href="#" id="lien2" >
                    <i class='bx bx-user-check'></i>
                    <span class="links_name">Client</span>
                </a>
                <span class="tooltip">client</span>
            </li>
            <li>
                <a href="#" id="lien3">
                    <i class='bx bxs-key' ></i>
                    <span class="links_name">clés </span>
                </a>
                <span class="tooltip">clés</span>
            </li>
            <li>
                <a href="#" id="lien4">
                    <i class='bx bxs-cog'></i>
                    <span class="links_name">Parametres</span>
                </a>
                <span class="tooltip">parametres</span>
            </li>
            <li>
                <a href="telecharge.php">
                    <i class='bx bxs-cloud-download'></i>
                    <span class="links_name">Télécharger</span>
                </a>
                <span class="tooltip">télécharger</span>
            </li>
            <li>
                <a href="logout.php">
                    <i class='bx bx-power-off'></i>
                    <span class="links_name">Déconnexion</span>
                </a>
                <span class="tooltip">Déconnexion</span>
            </li>
        </ul>
        <div class="profile_content">
            <div class="profile">
                <div class="profile_details">
                    <img src="../images/profile.jpg" alt="">
                    <div class="name_job">
                        <a href="mailto:fabricejordan2001gmail.com" style="color:#fff"><div class="name">Fabricejor</div></a>
                        <div class="job">Developpeur</div>
                    </div>
                </div>
                <a href="logout.php"><i class='bx bx-log-out' style="color:aqua" id="log_out"></i></a>
            </div>
        </div>
    </div>
    <div class="home_content">
        <div class="text">Outils Excel / Bienvenue <?php echo $_SESSION['user'] ?></div>
        <div id="contenu">
    <!-- Le contenu des liens sera affiché ici -->
        </div>
    </div>

    <script>
        let btn =document.querySelector("#btn");
        let sidebar =document.querySelector(".sidebar");
        let searchBtn =document.querySelector(".bx-search");

        btn.onclick =function (){
            sidebar.classList.toggle ("active");
        }

        searchBtn.onclick =function (){
            sidebar.classList.toggle ("active");
        }
    </script>
    <script>
    const darkModeMediaQuery = window.matchMedia('(prefers-color-scheme: light)');

    function toggleDarkMode() {
        if (darkModeMediaQuery.matches) {
            // Appliquer le mode sombre
            document.body.classList.add('dark-mode');
        } else {
            // Appliquer le mode clair
            document.body.classList.remove('dark-mode');
        }
    }

        // Appelez la fonction pour appliquer le thème initial
        toggleDarkMode();

        // Ajoutez un écouteur d'événement pour détecter les changements de thème
        darkModeMediaQuery.addListener(toggleDarkMode);

    </script>
    <script src="dash.js"></script>
</body>

</html>