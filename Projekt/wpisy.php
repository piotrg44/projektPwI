<?php
session_start();

$config = require_once 'config.php';

							$db = new PDO
							( 
								"mysql:host={$config ['host']};
								dbname={$config ['database']};
								charset=utf8",
								$config ['user'],
								$config['password']
							);
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
						<?php
						if(isset($_SESSION['logged']) && $_SESSION['logged'] == true)
						echo "<li class= 'rejestracja'><a href='zmienHaslo.php'><span>Zmień hasło</span></a></li>";
						?>
					</ul>
				</nav>


			</header>
			
			<div class="content">
				<div class="mainContentIndex">
					<section>
						
						<?php

							$sql = 'SELECT * FROM post';

							foreach ($db -> query($sql) as $rows) {

							echo "<article>"."<div>"."<h2>".$rows['tytul']."</h2>".
							$rows['tresc']."</div>"."</article>";
							}
						?>

						
						<?php
						if(isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']){
							echo '<section><form action="edytujpost.php" method="get">';
							echo '<b>Edytowanie postu:<b><br>';
							echo '<select id="ids5" name="ids5">';
								
								$sql = "SELECT * FROM post";
								foreach ($db->query($sql) as $row) {
									echo "<option value=".$row['Id_post'].">".$row['tytul']."</option>";
								}
								
							echo'</select>
							<div>
							<input type="submit" value="EDYTUJ">
							</div>
						 </form>
						 </section>';
						}
						
					 ?>
					 
					 
					 <?php
             
             if(isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] && isset($_SESSION['trescedytuje'])){
                 echo '<article>
				 <div><form id = "edycja" method="post">';
                 echo '<label for="tytul">Tytuł:</label>';
                 echo '<input type="text" id="tytuledytuj" name="tytuledytuj2" value ="'.$_SESSION['tytuledytuje'].'" required><br>';
				 echo '<textarea name="trescedytuj" rows="7" cols="130">'.$_SESSION['trescedytuje'].'</textarea><br><br>';
				 echo '<input type="submit" name ="edyt" value="EDYTUJ">';
                 echo '</form>';
                 if(isset($_POST['tytuledytuj2'])){
                    $tytuledytuj = $_POST['tytuledytuj2'];
                    $trescedytuj = $_POST['trescedytuj'];
                    
                    $queryed = $db->prepare('UPDATE post 
                            SET tytul = "'.$tytuledytuj.'", tresc = "'.$trescedytuj.'"
                            WHERE Id_post ='.$_SESSION['Id_post'].'');
                    $queryed->execute();
                     
					unset($_SESSION['tytuledytuje']);
					unset($_SESSION['trescedytuje']);
                    
                    
                    
                     header('location: wpisy.php');
				 }
				 
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

								echo "<article>"."<div>"."<b>".$row['imie_i_nazwisko']."<br> Id komentarza: ".$rows['Id_komentarz']."<br> Napisal: <br>"."</b>".
								$rows['tresc']."</div>"."</article>";
							}else{
								$_SESSION['Id_komentarz'] = $rows['Id_komentarz'];

								$id = $rows['id_uzytkownika'];
								$sql2 = "SELECT imie_i_nazwisko FROM uzytkownicy WHERE Id_uzytkownik = $id";
								$stmt = $db->query($sql2); 
								$row = $stmt->fetch(PDO::FETCH_ASSOC);

								echo "<article>"."<div>"."<b>".$row['imie_i_nazwisko']." Napisal: <br>"."</b>".
								$rows['tresc']."</div>"."</article>";
							}
						
						}
						?>
						</section>
						
					
						<?php
						if(isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']){
							echo '<article><section><form action="edytujkom.php" method="get">';
							echo '<b>Edytowanie komentarza:<b><br>';
							echo '<select id="ids6" name="ids6">';
								
								$sql = "SELECT * FROM komentarz";
								foreach ($db->query($sql) as $row) {
									echo "<option value=".$row['Id_komentarz'].">".$row['Id_komentarz']." ".$row['tresc']."</option>";
								}
								
							echo'</select>
							<div>
							<input type="submit" value="EDYTUJ">
							</div>
						 </form>
						 </section></article>';
						}
						
					 ?>
					
					 
					 <?php
             
             if(isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] && isset($_SESSION['trescedytujekom'])){
                 echo '<article>
				 <div>
				 <form id = "edycja" method="post">';
				 echo '<textarea name="trescedytuj" rows="7" cols="130">'.$_SESSION['trescedytujekom'].'</textarea><br><br>';
				 echo '<input type="submit" name ="edyt" value="EDYTUJ">';
                 echo '</form></div></article>';
                 if(isset($_POST['trescedytuj'])){
                    $trescedytuj = $_POST['trescedytuj'];
                    
                    $queryed = $db->prepare('UPDATE komentarz 
                            SET tresc = "'.$trescedytuj.'"
                            WHERE Id_komentarz ='.$_SESSION['Id_komentarz'].'');
                    $queryed->execute();
                     
					unset($_SESSION['trescedytujekom']);
                     header('location: wpisy.php');
				 }
				 
			 }
			 
             ?>

						<?php
						if(isset($_SESSION['logged']) && $_SESSION['logged'] == true){
							echo'<article><form method="post" autocomplete="off">
								
										<b>Dodawanie komentarza:</b>
											<div >
												<label for="description">Napisz post:</label>
												<textarea id="description" name = "tresc" maxlength="150" placeholder="max 150 słów" rows="5"></textarea> 
											</div>
											<div>
											<input type="submit">
											</div>
											

										
								</form></article>';
						}
							?>
							
				</div>
					
			</div>
</div>

			<footer>
				Wszelkie prawa zastrzeżone
			</footer>


</body>
</html>	