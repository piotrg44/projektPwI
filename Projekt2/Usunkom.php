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

$sql = 'DELETE FROM komentarz WHERE Id_komentarz = :ids2';
$sth = $db->prepare($sql);
$sth->execute(array('ids2' => $_GET['ids2']));
header('location: admin.php');
?>