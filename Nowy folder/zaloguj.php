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
					<form action="zalogujbac.php" method="post" >
							<div class="row">
								<label>Email</label>
								<input type="email" name = "email" id="email" required>
							</div>
							<div class="row">
								<label for="password">Hasło</label>
								<input type="password" name = "password" id="password" required>
							</div>
								<div class="row">
								<input type="submit" value="Zaloguj">
								<?php
									if(isset($_SESSION['blad'])) echo $_SESSION['blad'];	
								?>
								</div>

					</form>
					
				</div>

			<footer>
				Wszelkie prawa zastrzeżone
			</footer>
	</div>


</body>
</html>