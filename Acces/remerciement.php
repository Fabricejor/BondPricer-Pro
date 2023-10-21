<?php 
session_start();
@ini_set('session.gc_maxlifetime', 600);
if (!isset($_COOKIE['code'])) {
    header('location:../index.php');
}else{
    if ($_SESSION['proges'] != 1) {
        header("location:../index.php");
    }else {
        $_SESSION['proges'] = 2 ;
    }
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Merci</title>
    <link rel="shortcut icon" href="../images/bondPriceLogo.png" type="image/x-icon">

<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600&display=swap');
*{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

body{
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
    background: #06006F;
}
.wrapper{
    display: inline-flex;
}
.wrapper .static-txt{
    color: #fff;
    font-size: 60px;
    font-weight: 400;
}
.wrapper .dynamic-txts{
    margin-left: 15px;
    height: 90px;
    line-height: 90px;
    overflow: hidden;
}
.dynamic-txts li{
    color:#4070f4;
    list-style: none;
    font-size: 60px;
    font-weight: 500;
    position: relative;
    top: 0;
    animation:slide 10s steps(4) infinite;
}
@keyframes slide{
    100%{
    top: -360px;
    }
}
.dynamic-txts li span{
    position: relative;
}

.dynamic-txts li span::after{
    content: "";
    position: absolute;
    height: 100%;
    left: 0;
    width: 100%;
    background: #06006F;
    border-left:2px solid #4070f4 ;
    animation: typing 1.5s steps(22) infinite;
}

@keyframes typing{
    100%{
        left:100%;
        margin: 0 -35px 0 35px;
    }
}
</style>

<script type="text/javascript">
        // Fonction de redirection différée
        function redirectionDifferee() {
            // Attendre le délai spécifié (5 secondes)
            setTimeout(function() {
                // Effectuer la redirection vers une autre page
                window.location.href = 'download.php';
            }, 9000); // Délai en millisecondes (9 secondes = 9000 millisecondes)
        }
</script>
</head>
<body  onload="redirectionDifferee()">
    <div class="wrapper">
        <div class="static-txt">BondPricer</div>
        <ul class="dynamic-txts">
            <li><span>vous remercie!</span></li>
            <li><span>vous remercie!</span></li>
            <li><span>vous remercie!</span></li>
            <li><span>vous remercie!</span></li>
        </ul>
    </div>
</body>
</html>