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
		
		if(isset($_POST["ajout"]));
		{
			if(($titre == "") or ($url == ""))
			{
				$erreurajout = "<font color='red'>Tous les champs sont obligatoires.</font><br>";
			}
		
			else
			{
				$sqlexist = 'SELECT titre_categorie, url_categorie FROM categorie WHERE titre_categorie="'.$titre.'" AND url_categorie="'.$url.'" ';
				$queryexist = mysqli_query($lien, $sqlexist) or die ("ERREUR SQL ! ".$sqlexist);
				if(mysqli_num_rows($queryexist))
				{
					$erreurajout = "<font color='red'>Catégorie déjà enregistrée.</font><br>";
				}
				else
				{
					$sqlajout = 'INSERT INTO categorie VALUES ("", "'.$titre.'", "'.$url.'")';
					mysqli_query($lien, $sqlajout) or die ("ERREUR SQL ! ".$sqlajout);
					$ok = "<font color='green'>Catégorie ajouter avec succès.</font><br />";
				}
			}
		}
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Actualtn | Ajouter</title>
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
		
		<form method="post" action="ajouter.php" name="ajouter">
		
		<table id="tableajout">
			<caption align="center">Ajouter une catégorie</caption>
			<tr>
			
			<tr>
				<td>Titre de la catégorie</td>
				<td><input type="text" name="titre" >
			</tr>
			<tr>
				<td>URL de la catégorie</td>
				<td><input type="text" name="url" >
			</tr>
			<tr>
				<td>
				<?php
					if(isset($erreurajout))
					{
						print($erreurajout);
					}
					else
					{
						print($ok);
					}
				?>
				</td>
			</tr>
			<tr>
				<td></td>
				<td><table align="center"><tr><td><input type="submit" value="Ajouter" name="ajout"></td></tr></table></td>
			</tr>
		</table>
		<p class="retour" align="center"><a href="index.php">Retour</a></p>
		<footer>
			<hr width="50%">
				<p align="center">Copyright © 2013 Germain Tom & Blanchet Nicolas</p>
			<hr width="50%">
		</footer>
	</body>
</html>