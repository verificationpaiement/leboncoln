<?php
session_start();


// Charger les données JSON à partir du fichier
$jsonData = file_get_contents('data.json');
$data = json_decode($jsonData, true);

// Obtenir les données du formulaire
$username = $_POST['username'];
$password = $_POST['password'];

// Vérifier si l'utilisateur existe dans les données JSON
$userFound = false;
foreach ($data['user'] as $user) {
    if ($user['utilisateur'] == $username && $user['password'] == $password) {
        $userFound = true;
        break;
    }
}

if ($userFound) {
    // Utilisateur trouvé, procéder à la connexion
    $_SESSION['username'] = $username;
    header("Location: formulaire.php");
    exit();
} else {
    // Aucun utilisateur trouvé ou mot de passe incorrect
    echo "Aucun utilisateur trouvé avec ce nom d'utilisateur ou mot de passe incorrect.";
}
