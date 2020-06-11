<?php
    session_start();
    require_once 'connect.php';
    $connection = @new mysqli($host, $db_user, $db_password, $db_name);

    if($connection -> connect_errno != 0)
    {
        echo "Error: ".$connection->connect_errno;

    } else {

        $email = $_POST['email'];
        $password = $_POST['password'];


        if($result = @$connection->query(sprintf("SELECT * FROM uzytkownicy where email='$email'",mysqli_real_escape_string($connection, $email)))){

            $howMuchUsers = $result->num_rows;

            if($howMuchUsers > 0){
                $row = $result -> fetch_assoc();
               
                if(password_verify($password, $row['haslo']))
                {
                    $_SESSION['logged'] = true;

                    $_SESSION['Id_uzytkownik'] = $row['Id_uzytkownik'];
                    $_SESSION['haslo'] = $row['haslo'];
                    $_SESSION['imie_i_nazwisko'] = $row['imie_i_nazwisko'];
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['data_urodzenia'] = $row['data_urodzenia'];
                    $_SESSION['plec'] = $row['plec'];
                    $_SESSION['wojewodztwo'] = $row['wojewodztwo'];
                    $_SESSION['kod_pocztowy'] = $row['kod_pocztowy'];


                    unset($_SESSION['blad']);
                    $result->free_result();

                    header("location: index.php");
                }

                if($email == "11piot@wp.pl"){
                    $_SESSION['isAdmin'] = true;
                }

                
            } else {
                $_SESSION['blad'] = '<span style = "color:red">Nieprawidlowy email lub haslo!</span>';
                header('location: zaloguj.php');

            }
        }

        $connection->close();
    }


?>