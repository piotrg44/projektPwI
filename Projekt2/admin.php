<?php
	session_start();

			if(isset($_POST['tresc'])){
				$tresc = $_POST['tresc'];
				$tytul = $_POST['tytul'];
				$id_postu = $_POST['id_postu'];
				require_once 'connect.php';
				
					$connection = new mysqli($host, $db_user, $db_password, $db_name);
						

					if($connection -> connect_errno != 0)
					{
						throw new Exception(mysqli_connect_errno());
					} else{
							if($connection-> query("INSERT INTO post VALUES ($id_postu, 1, '$tresc', '$tytul')")){
								header('Location: wpisy.php');
							}
							$connection -> close();
					
						}
	}
			if(isset($_POST['id_postuDoUsuniecia'])){
					$config = require_once 'config.php';

			$db = new PDO
			( 
				"mysql:host={$config ['host']};
				dbname={$config ['database']};
				charset=utf8",
				$config ['user'],
				$config['password']
			);

				$idPostu = $_POST['id_postuDoUsuniecia'];
				$sql = 'DELETE FROM post WHERE Id_post = :id';
				$data = $db -> prepare($sql);
				if($data -> execute(array('id' => $idPostu)))
				header("location: admin.php");
	}

			if(isset($_POST['id_komentarzaDoUsuniecia'])){
				$config = require_once 'config.php';

				$db = new PDO
				( 
					"mysql:host={$config ['host']};
					dbname={$config ['database']};
					charset=utf8",
					$config ['user'],
					$config['password']
				);

					$idKomentarza = $_POST['id_komentarzaDoUsuniecia'];
					$sql = 'DELETE FROM komentarz WHERE Id_komentarz = :id';
					$data = $db -> prepare($sql);
					if($data -> execute(array('id' => $idKomentarza)))
					header("location: admin.php");
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
				<form method="post" autocomplete="off">
							<b>Dodawanie postu:</b>
								<div >	
									<label>Podaj id postu: </label>
									<input type="text" id="header3" name = "id_postu" >
								</div>
								<div >
									<label>Podaj nagłówek: </label>
									<input type="text" id="header4" name = "tytul" >
								</div>
								<div >
									<label for="description">Napisz post:</label>
									<textarea id="description" name = "tresc" maxlength="1000" placeholder="max 1000 słów" rows="15"></textarea> 
								</div>
								<div>
								<input type="submit">
								</div>
								

							
					</form>
				</div>
			</div>
			<div class="content">
			<div class="mainContentIndex">
			
				<form method="post" autocomplete="off">
				<b>Spis postów: </b><br>
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

					echo "<b>".$rows['Id_post']." ".$rows['tytul']."</b>"."<br>";
					}
					?>
</form>
					<br>
					<br>


<form method="post" autocomplete="off">
							<b>Usuwanie postu:</b>
								<div >	
									<label>Podaj id postu który chcesz usunac: </label>
									<input type="text" id="header1" name = "id_postuDoUsuniecia" >
								</div>
								<div>
								<input type="submit" value="Usuń">
								</div>
								</form>
								<form method="post" autocomplete="off">
								<b>Usuwanie komentarza:</b>
								<div >	
									<label>Podaj id komentarza który chcesz usunac: </label>
									<input type="text" id="header2" name = "id_komentarzaDoUsuniecia" >
								</div>
								<div>
								<input type="submit" value="Usuń">
								</div>
								</form>
							
							
					
					
				</div>
			</div>
</div>
			<footer>
				Wszelkie prawa zastrzeżone 
			</footer>
	


</body>
</html>			