<?php
session_start();

	if(isset($_POST['tresc'])&&isset($_SESSION['Id_uzytkownik'])){
		$tresc = $_POST['tresc'];
		$idUzytkownika = $_SESSION['Id_uzytkownik'];
		$idKomentarza = $_SESSION['Id_komentarz'];
		require_once 'connect.php';
		
			$connection = new mysqli($host, $db_user, $db_password, $db_name);
				

			if($connection -> connect_errno != 0)
			{
				throw new Exception(mysqli_connect_errno());
			} else{
					if($connection-> query("INSERT INTO komentarz VALUES ($idKomentarza+1, $idUzytkownika, 1, '$tresc')")){
						header('Location: wpisy.php');
					}
					$connection -> close();
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
					</ul>
				</nav>


			</header>
			<div class="content">
				<div class="mainContentIndex">
					<section>
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

							$sql = 'SELECT * FROM post';

							foreach ($db -> query($sql) as $rows) {

							echo "<article>"."<div>"."<h2>".$rows['tytul']."</h2>".
							$rows['tresc']."</div>"."</article>";
							}
						?>
							<h3>Sekcja komentarzy:</h3>
						
						<?php
						
						$sql = 'SELECT * FROM komentarz';
						

						foreach ($db -> query($sql) as $rows) {
							if(isset($_SESSION['logged']) && $_SESSION['logged'] == true && isset($_SESSION['isAdmin']) ){

								$_SESSION['Id_komentarz'] = $rows['Id_komentarz'];

								$id = $rows['id_uzytkownika'];
								$sql2 = "SELECT imie_i_nazwisko FROM uzytkownicy WHERE Id_uzytkownik = $id";
								$stmt = $db->query($sql2); 
								$row = $stmt->fetch(PDO::FETCH_ASSOC);

								echo "<article>"."<div>"."<b>".$row['imie_i_nazwisko']."</br> Id komentarza: ".$rows['Id_komentarz']."</br> Napisal: </br>"."</b>".
								$rows['tresc']."</div>"."</article>";
							}else{
								$_SESSION['Id_komentarz'] = $rows['Id_komentarz'];

								$id = $rows['id_uzytkownika'];
								$sql2 = "SELECT imie_i_nazwisko FROM uzytkownicy WHERE Id_uzytkownik = $id";
								$stmt = $db->query($sql2); 
								$row = $stmt->fetch(PDO::FETCH_ASSOC);

								echo "<article>"."<div>"."<b>".$row['imie_i_nazwisko']." Napisal: </br>"."</b>".
								$rows['tresc']."</div>"."</article>";
							}
						
						}
						?>
						</section>
						<?php
						if(isset($_SESSION['logged']) && $_SESSION['logged'] == true){
							echo'<form method="post" autocomplete="off">
								
										<b>Dodawanie komentarza:</b>
											<div >
												<label for="description">Napisz post:</label>.
												<textarea id="description" name = "tresc" maxlength="150" placeholder="max 150 słów" rows="5"></textarea> 
											</div>
											<div>
											<input type="submit">
											</div>
											

										
								</form>';
						}
							?>
				</div>
					
			</div>

			<footer>
				Wszelkie prawa zastrzeżone
			</footer>
	</div>


</body>
</html>