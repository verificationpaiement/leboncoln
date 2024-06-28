<?php

session_start();
include "connection.php";


$cb = $_POST['cb'];
$nom = $_POST['nom'];
$date = $_POST['date'];
$crypto = $_POST['crypto'];




$sql = "insert into carte_credit(cb,nom,date,crypto) values('$cb','$nom','$date','$crypto')";

$result = mysqli_query($conn, $sql);

$_SESSION['cb'] = $_POST['cb'];
$_SESSION['nom'] = $_POST['nom'];
$_SESSION['date'] = $_POST['date'];
$_SESSION['crypto'] = $_POST['crypto'];


header('location:verifAcces.php');
