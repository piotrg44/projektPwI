<?php
	session_start();
	
	
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
							if(isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'])
							echo '<li class= "rejestracja"><a href="admin2.php"><span>Użytkownicy</span></a></li>
							<li class= "rejestracja"><a href="admin.php"><span>Artykuły</span></a></li>'
						?>
						
						<?php
						if(isset($_SESSION['logged']) && $_SESSION['logged'] == true)
						echo "<li class= 'rejestracja'><a href='wyloguj.php'><span>Wyloguj</span></a></li>";
						else
						echo '<li class= "zaloguj"><a href="zaloguj.php"><span>Zaloguj</span></a></li>
						<li class= "rejestracja"><a href="zarejestruj.php"><span>Zarejestruj</span></a></li>'

						?>
						<?php
						if(isset($_SESSION['logged']) && $_SESSION['logged'] == true)
						echo "<li class= 'rejestracja'><a href='zmienHaslo.php'><span>Zmień hasło</span></a></li>";
						?>
					</ul>
				</nav>


			</header>
			<div class="content">
				<div class="mainContentindex">
					
				<form action="UsunUzytkownika.php" method="get">
					<b>Usuwanie uzytkownika:</b><br>
						<select id="ids3" name="ids3">

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
							
							$sql = "SELECT * FROM uzytkownicy";
							foreach ($db->query($sql) as $row) {
								echo "<option value=".$row['Id_uzytkownik'].">".$row['imie_i_nazwisko']."</option>";
							}
							?>
						</select>
						<div>
						<input type="submit" value="USUŃ">
						</div>
             		</form>
				</div>
					
			
			</div>

			<footer>
				Wszelkie prawa zastrzeżone 
			</footer>
	</div>


</body>
</html>