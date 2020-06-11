<?php
	session_start();
	
	if(isset($_POST['email'])){

		$allGood = true;
		$password = $_POST['password'];
		$email = $_POST['email'];
		$name = $_POST['name'];
		$date = $_POST['date'];
		$plec = $_POST['plec'];
		$woj = $_POST['woj'];
		$kod = $_POST['kod'];
		$omnie = $_POST['omnie'];

		$haslo_hash = password_hash($password, PASSWORD_DEFAULT);

		require_once 'connect.php';

		mysqli_report(MYSQLI_REPORT_STRICT);//zamiast ostrzezenia to wyjatki

		try{
			$connection = new mysqli($host, $db_user, $db_password, $db_name);

			if($connection -> connect_errno != 0)
			{
				throw new Exception(mysqli_connect_errno());
			} else{
				$result = $connection->query("SELECT id_uzytkownik FROM uzytkownicy WHERE email = '$email' ");
				if(!$result) {throw new Exception($connection -> error);}

				$how_much_that_same_mails = $result->num_rows;

				if($how_much_that_same_mails>0){
					$_SESSION['e_email'] = "Istnieje juz konto przypisane do tego adresu email";
					$allGood = false;

				}
				if(strlen($password) < 8){
				$_SESSION['e_password'] = "Haslo musi miec minimum 8 znakow!";
				$allGood = false;
				}
				if($allGood == true){
					if($connection-> query("INSERT INTO uzytkownicy VALUES (NULL, '$name', '$email', '$haslo_hash', '$data', '$plec', '$woj', '$kod', '$omnie')")){
						header('Location: witamy.php');
					}
					$connection -> close();
				}
			
			}

		}catch(Exception $e){
			echo 'Błąd serwera!';
			echo $e;
		}
	}
?>
<!DOCTYPE html>
<html lang="pl-PL">
<head>
	<meta charset="utf-8">

	<title>Blog</title>
	<link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>
	<div id="container">
		<header>
				<div>
					<h1>Blog o programowaniu</h1>
				</div>
				<nav>
					<ul>
						<li class="home"><a href="index.php"><span>Start</span></a></li>
						<li class="html5"><a href="wpisy.php"><span>Wpisy</span></a></li>
						<li class="omnie"><a href="omnie.php"><span>O mnie</span></a></li>
						
						<?php
						if(isset($_SESSION['logged']) && $_SESSION['logged'] == true)
						echo "<li class= 'rejestracja'><a href='wyloguj.php'><span>Wyloguj</span></a></li>";
						else
						echo '<li class= "zaloguj"><a href="zaloguj.php"><span>Zaloguj</span></a></li>
						<li class= "rejestracja"><a href="zarejestruj.php"><span>Zarejestruj</span></a></li>'
						?>
					</ul>
				</nav>


			</header>
				<div class="content">
					<form method="post" autocomplete="off">
							<div class="row">
								<label for="name">Imie i nazwisko</label>
								<input id="name" name = "name" type="text" required>
							</div>
							<div class="row">
								<label>Email</label>
								<input type="email" name = "email" id="email" required>
								<?php
								if(isset($_SESSION['e_email'])){
									echo $_SESSION['e_email'];
									unset($_SESSION['e_email']);
								}
								
								?>
							</div>
							<div class="row">
								<label for="password">Hasło</label>
								<input type="password" name = "password" id="password" required>
								<?php
								if(isset($_SESSION['e_password'])){
									echo $_SESSION['e_password'];
									unset($_SESSION['e_password']);
								}
								
								?>
							</div>
							<div class="row">
								<label for="date">Data urodzenia</label>
								<input type="text" name = "date" id="date">
							</div>
							<div class="row">
								<label for="plec">Płeć</label>
								<select id="plec" name = "plec">
									<option>Mezczyzna</option>
									<option>Kobieta</option>
								</select>
							</div>
							<div class="row">
								<label for="wojewodztwo">Województwo</label>
								<input type="text" name = "woj" id="wojewodztwo" list="wojewodztwa">
								<datalist id="wojewodztwa">
									<option value="dolnośląskie"></option>
									<option value="podlaskie"></option>
									<option value="warmińsko-mazurskie"></option>
									<option value="pomorskie"></option>
									<option value="śląskie"></option>
									<option value="zachodnio-pomorskie"></option>
									<option value="podkarpackie"></option>
								</datalist>
							</div>
								<div class="row">
									<label for="kodpocztowy">Kod pocztowy</label>
									<input type="text" name = "kod" id="kodpocztowy" pattern="\d{2}-\d{3}$" placeholder="XX-XXX">
								</div>
								<div class="row">
									<label for="description">O mnie</label>
									<textarea id="description" name = "omnie" maxlength="150" placeholder="max 150 słów" rows="3"> </textarea>
								</div>
								<div class="row">
									<input type="checkbox" id="rules" required>
									<span>Akceptuję regulamin</span>
								</div>
								<div class="row">
								<input type="submit">
								</div>
							
					</form>
				</div>
</div>

			<footer>
				Wszelkie prawa zastrzeżone
			</footer>


</body>
</html>