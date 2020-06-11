<?php
$config = require_once 'config.php';
$db = new PDO
( 
    "mysql:host={$config ['host']};
    dbname={$config ['database']};
    charset=utf8",
    $config ['user'],
    $config['password']
);

$sql = 'DELETE FROM uzytkownicy WHERE Id_uzytkownik = :ids3';
$sth = $db->prepare($sql);
$sth->execute(array('ids3' => $_GET['ids3']));
header('location: admin2.php');
?>