<?php
session_start();

echo $_POST['password1'];
echo $_SESSION['haslo'];
if(password_verify($_POST['password1'], $_SESSION['haslo']))
{
    $config = require_once 'config.php';

    $db = new PDO
    ( 
        "mysql:host={$config ['host']};
        dbname={$config ['database']};
        charset=utf8",
        $config ['user'],
        $config['password']
    );

    $queryed = $db->prepare('UPDATE uzytkownicy
                            SET haslo = "'.password_hash($_POST['password2'], PASSWORD_DEFAULT).'"
                            WHERE Id_uzytkownik ='.$_SESSION['Id_uzytkownik'].'');
                    $queryed->execute();

                    header("location: index.php");
    echo "Hasla sa takie same";
}else{
    echo "Hasla nie sa takie same";
}
?>