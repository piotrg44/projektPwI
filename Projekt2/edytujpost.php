<?php
session_start();
$config = require_once 'config.php';
$db = new PDO
(
    "mysql:host={$config ['host']};
    dbname={$config ['database']};
    charset=utf8",
    $config ['user'],
    $config['password']
);

$sql = "SELECT * FROM post WHERE Id_post = :ids5";
$sth = $db->prepare($sql);
$sth->execute(array('ids5' => $_GET['ids5']));

$row = $sth->fetch();
$_SESSION['tytuledytuje'] = $row['tytul'];
$_SESSION['trescedytuje'] = $row['tresc'];

$_SESSION['Id_post'] = $_GET['ids5'];

header('location: wpisy.php');
?>
