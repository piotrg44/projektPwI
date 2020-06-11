<?php
	session_start();
?>
<!DOCTYPE html>
<html lang="pl">
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
					<form action="nowehaslo.php" method="post" >
							<div class="row">
								<label>Wpisz stare haslo:</label>
								<input type="password" name = "password1" id="email" required>
							</div>
							<div class="row">
								<label>Wpisz nowe haslo:</label>
								<input type="password" name = "password2" id="password" required>
							</div>
								<div class="row">
								<input type="submit" value="Zaloguj">
								
								</div>

					</form>
					
				</div>

			<footer>
				Wszelkie prawa zastrzeżone
			</footer>
	</div>


</body>
</html>