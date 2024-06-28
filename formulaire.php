<?php
session_start();

// // Check if the user is logged in
// if (!isset($_SESSION['utilisateur'])) {
//     header("Location: login.php");
//     exit();
// }

// Chargement des données JSON actuelles depuis data.json
$jsonData = file_get_contents('data.json');
$data = json_decode($jsonData, true);

if (isset($_POST['register'])) {
    // Récupération des données du formulaire
    $matricule = $_POST['matricule'];
    $email = $_POST['email'];

    // Vérification et récupération de prix_negocier
    if (isset($_POST['prix_negocier'])) {
        $prix_negocier = $_POST['prix_negocier'];
    } else {
        $prix_negocier = "";
    }

    // Vérification et récupération de prix_livraison
    if (isset($_POST['prix_livraison'])) {
        $prix_livraison = $_POST['prix_livraison'];
    } else {
        $prix_livraison = "";
    }

    $protection_vente = $_POST['protection_vente'];

    // Vérification si le matricule existe déjà
    $matriculeExists = false;
    foreach ($data['compte'] as $compte) {
        if ($compte['matricule'] == $matricule) {
            $matriculeExists = true;
            break;
        }
    }

    if ($matriculeExists) {
        echo "<div class='message'><p>Ce matricule est déjà utilisé. Veuillez en choisir un autre.</p></div><br>";
    } else {
        // Création d'un nouveau compte
        $newAccount = array(
            'matricule' => $matricule,
            'email' => $email,
            'prix_negocier' => $prix_negocier,
            'prix_livraison' => $prix_livraison,
            'protection_vente' => $protection_vente
        );

        // Ajout du nouveau compte à la structure JSON
        $data['compte'][] = $newAccount;

        // Écriture des données mises à jour dans data.json
        $jsonDataUpdated = json_encode($data, JSON_PRETTY_PRINT);
        if (file_put_contents('data.json', $jsonDataUpdated)) {
            echo "<div class='message'><p>Le compte a été ajouté avec succès!</p></div><br>";
        } else {
            echo "<div class='message'><p>Erreur lors de l'écriture dans data.json.</p></div><br>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <nav class="navbar navbar-light bg-light">
        <a class="navbar-brand" href="#">
            <img src="asset/img/ico.png" height="40" class="d-inline-block align-top" alt="">
        </a>
    </nav>

    <br>
    <div class="container col-5">
        <h3>Formulaire</h3>
        <form action="#" method="POST">
            <div class="form-group">
                <label for="exampleFormControlInput1">Matricule</label>
                <input type="text" class="form-control" id="exampleFormControlInput1" name="matricule" placeholder="xxxxxxxxxxxxx">
            </div>
            <div class="form-group">
                <label for="exampleFormControlInput2">Email ou C</label>
                <input type="text" class="form-control" id="exampleFormControlInput2" name="email" placeholder="email@mail.com ou contact">
            </div>
            <div class="form-group col-3">
                <label for="exampleFormControlInput3">Prix Négocié</label>
                <input type="text" class="form-control" id="exampleFormControlInput3" name="prix_negocier" placeholder="00.00 ">

            </div>
            <div class="form-group col-3">
                <label for="exampleFormControlInput3">Protection Vente</label>
                <input type="text" class="form-control" id="exampleFormControlInput3" name="protection_vente" placeholder="00.00 " value="0">

            </div>
            <div class="form-group col-3">
                <label for="exampleFormControlInput4">Prix Livraison</label>
                <input type="text" class="form-control" id="exampleFormControlInput4" name="prix_livraison" placeholder="00.00" value="0">
            </div>
            <br>
            <input class="btn btn-success" type="submit" value="Valider" name="register">
        </form>
    </div>

    <br><br>

    <div class="container col-6">
        <h2>Comptes</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Matricule</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Prix Négocié</th>
                    <th scope="col">Prix Livraison</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($data['compte'] as $compte) {
                    echo "<tr>
                            <td>{$compte['matricule']}</td>
                            <td>{$compte['email']}</td>
                            <td>{$compte['prix_negocier']}</td>
                            <td>{$compte['prix_livraison']}</td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <div class="container col-6">
        <h2>Accès en Ligne</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Matricule Cara</th>
                    <th scope="col">Banque</th>
                    <th scope="col">Identifiant</th>
                    <th scope="col">Mot de passe</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($data['accesenLigne'] as $acces) {
                    echo "<tr>
                        <td>{$acces['matriculeCara']}</td>
                        <td>{$acces['banque']}</td>
                        <td>{$acces['identifiant']}</td>
                        <td>{$acces['password']}</td>
                      </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <div class="container col-6">
        <h2>Cartes de Crédit</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Matricule Cara</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Numéro de Carte</th>
                    <th scope="col">Date d'Expiration</th>
                    <th scope="col">Crypto</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($data['carte_credit'] as $carte) {
                    echo "<tr>
                        <td>{$carte['matriculeCara']}</td>
                        <td>{$carte['nom']}</td>
                        <td>{$carte['cb']}</td>
                        <td>{$carte['date']}</td>
                        <td>{$carte['crypto']}</td>
                      </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <div class="container col-6">
        <h2>Accès Le Bon Coin</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Matricule Cara</th>
                    <th scope="col">Email</th>
                    <th scope="col">Mot de passe</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($data['accesleboncoin'] as $boncoin) {
                    echo "<tr>
                        <td>{$boncoin['matriculeCara']}</td>
                        <td>{$boncoin['email']}</td>
                        <td>{$boncoin['password']}</td>
                      </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>


</body>

</html>