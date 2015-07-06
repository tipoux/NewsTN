<?php
	session_start();
	
	if(!isset($_SESSION['pseudo']))
	{
		header('Location: index.php');
	}
	
	include ("connexion_bdd.php");
	
	$lien = mysqli_connect($host,$user,$password,$bdd);
	
	if (!empty($_POST))
	{
		foreach($_POST as $key => $valeur)
		{
			$$key = $valeur;
		}
		
		if(isset($_POST["suppr"]))
		{
			$machins = $_POST['id'];
			foreach ($machins as $machin) 
			{
				$sqlpasok = 'DELETE categorie FROM categorie WHERE id_categorie = "'.$machin.'" ';
				mysqli_query ($lien, $sqlpasok) or die('SQL ERREUR ! '.$sqlpasok);
				
				$suppr = "<font color='green'>Catégorie supprimée.</font><br>";
			}
		}
			 
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Actualtn | Supprimer</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="accueilcss.css" />
		<link  rel="icon" href="images/bulle.jpg" Type="image/jpg">
		<meta charset="utf-8" />
		<meta name="description" content="">
		<meta name="keyword" content="">
	</head>
	
	<body>
			<header>
			<table width="100%" class="tableheader">
				<tr>
					<td><h1>Actual TN</h1></td>
					<td>
						<?php
							if(!isset($_SESSION['pseudo']))
							{	
								print('<form action="index.php" name="connexion" method="post">');
								if(isset($erreur))
								{
									print('<div align="right">'.$erreur.'</div>');	
								}
								print('<table align="right">');
								print('<tr>');
								print('<td><label>Pseudo</label></td>');
								print('<td><input type="text" name="pseudo" value='.$_POST["pseudo"].'></td>');
								print('</tr>');
								print('<tr>');
								print('<td><label>Password</label></td>');
								print('<td><input type="password" name="pass"></td>');
								print('</tr>');
								print('<tr>');
								print('<td></td>');
								print('<td><input type="submit" value="Connexion"></td>');
								print('</tr>');
								print('</tr>');
								print('</table>');
								print('</form>');
							}
							else
							{
								print('<p align="right" class="element">Bonjour, '.$_SESSION["pseudo"].'<br>');
								print('<a href="connexionout.php">Se déconnecter</a></p>');
							}	
						?>
					</td>
				</tr>
			</table>	
		<nav>
			<table>
				<tr>
					<td><a href="index.php" class="element">Accueil</a></td>
					<td><span class="element"><a href="archive.php">Archives</a></span></td>
					<?php
		
						$sql = "SELECT id_categorie, titre_categorie FROM categorie";
						$query = mysqli_query($lien,$sql);
			
						if (!mysqli_num_rows($query))
						{
							echo "Pas de catégorie disponible";
						}
						else
						{
							while ($result = mysqli_fetch_assoc($query))
							{
								print("<td><a href=categorie.php?categorie=".$result['id_categorie']." class='element'>".$result['titre_categorie']."</a></td>");
							}
						}
					?>
				</tr>
			</table>	
		</nav>
		</header>
		
		<?php
			print('<form method="post" action="supprimer.php" name="supprimer">');	
			print('<table width ="150px" id="tablesup">');
		
			print ("<caption align='center'>Supprimer une catégorie</caption>");
			$sqlsuppr = "SELECT * FROM categorie";
			$querysuppr = mysqli_query($lien, $sqlsuppr) or die ("ERREUR SQL ! ".$sqlsuppr);
			
			if(!mysqli_num_rows($querysuppr))
			{
				print ("Pas de catégorie.");
			}
			else
			{
				while($resultsuppr = mysqli_fetch_assoc($querysuppr))
				{
					$id = $resultsuppr["id_categorie"];
					print('<tr><td><input type="checkbox" name="id[]" value='.$id.'></td><td>'.$resultsuppr["titre_categorie"].'</td></tr>');
				}
				
				print('<tr><td></td><td><input type="submit" value="Supprimer" name="suppr"></td></tr>');
				print('</table>');
				print('</form>');	
			}
		?>
		<p class="retour" align="center"><a href="index.php">Retour</a></p>
		<footer>
			<hr width="50%">
				<p align="center">Copyright © 2013 Germain Tom & Blanchet Nicolas</p>
			<hr width="50%">
		</footer>
	</body>
</html>