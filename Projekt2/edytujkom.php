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

$sql = "SELECT * FROM komentarz WHERE Id_komentarz = :ids6";
$sth = $db->prepare($sql);
$sth->execute(array('ids6' => $_GET['ids6']));

$row = $sth->fetch();
$_SESSION['trescedytujekom'] = $row['tresc'];

$_SESSION['Id_komentarz'] = $_GET['ids6'];

header('location: wpisy.php');
?>
