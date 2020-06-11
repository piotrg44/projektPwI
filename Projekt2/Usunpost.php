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

$sql = 'DELETE FROM post WHERE Id_post = :ids1';
$sth = $db->prepare($sql);
$sth->execute(array('ids1' => $_GET['ids1']));
header('location: admin.php');
?>