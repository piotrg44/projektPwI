<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<html lang="pl">
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
						<li class="home"><a href="index.html"><span>Start</span></a></li>
						<li class="html5"><a href="wpisy.html"><span>Wpisy</span></a></li>
						<li class="omnie"><a href="omnie.html"><span>O mnie</span></a></li>
						<li class= "zaloguj"><a href="zaloguj.html"><span>Zaloguj</span></a></li>
						<li class= "rejestracja"><a href="zarejestruj.html"><span>Zarejestruj</span></a></li>
					</ul>
				</nav>


			</header>
				<div class="content">
					<form action="zaloguj.php" method="post">
						
							<div class="row">
								<label for="Email">Email</label>
								<input type="email" id="email" required>
							</div>
							<div class="row">
								<label for="password">Hasło</label>
								<input type="password" id="password" required>
							</div>
								<div class="row">
								<input type="submit" value="Zaloguj">
								</div>
							</div>

							</div>
								<div class="row">
								<a href="admin.html">Strona admina</a>
								</div>
							</div>
					</form>
				</div>

			<footer>
				Wszelkie prawa zastrzeżone
			</footer>
	</div>


</body>
</html>