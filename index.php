<?php

session_start();

	include ("connexion_bdd.php");

$lien = mysqli_connect($host,$user,$password,$bdd);
	
if (!empty($_POST))
{
	foreach($_POST as $key => $valeur)
	{
		$$key = $valeur;
	}
		
	if($pseudo == "" or $pass == "")
	{
		$erreur = '<font color="red">Veuillez saisir un pseudo et un mot de passe.</font>';
	}
		
	else
	{
		$sqlConnexionAdmin = 'SELECT * FROM utilisateurs WHERE pseudo_users = "'.$pseudo.'" and mdp_users = "'.$pass.'" and mod_users = "1" ';
		$queryConnexionAdmin = mysqli_query($lien, $sqlConnexionAdmin) or die ('ERREUR SQL ! '.$sqlConnexionAdmin);
		if(mysqli_num_rows($queryConnexionAdmin))
		{
			$resultConnexion = mysqli_fetch_assoc($queryConnexionAdmin) ;
			$_SESSION["mod"] = $resultConnexion["mod_users"] ;
			$_SESSION["pseudo"] = $resultConnexion["pseudo_users"];
			header('Location: index.php');
		}
		else
		{
			$erreur = '<font color="red">Pseudo et/ou mot de passe incorrect.</font>' ;
		}
	}
}
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Actualtn</title>
		<link rel="stylesheet" type="text/css" href="accueilcss.css" />
		<link  rel="icon" href="images/bulle.jpg" Type="image/jpg">
		<meta charset="utf-8" />
		<meta name="description" content="">
		<meta name="keyword" content="">
	</head>
	
	<body>
	<?php include_once("analyticstracking.php") ?>
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
								print('<td><label>Login</label></td>');
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
					<td><span class="element"><a href="index.php">Accueil</a></span></td>
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
								print("<td><span class='element'><a href=categorie.php?categorie=".$result['id_categorie'].">".$result['titre_categorie']."</a></span></td>");
							}
						}
					?>
				</tr>
			</table>	
		</nav>
		</header>
		
		<br><br>
		
		<div>
			<table width="60%" align="left" class="tablearticle">
				<tr>
					<td>
						<?php
		
							$sql = "SELECT * FROM categorie";
							$query = mysqli_query($lien,$sql);
							while($result = mysqli_fetch_assoc($query))
							{
								if (!mysqli_num_rows($query))
								{
									echo "Pas de catégorie disponible";
								}
								else
								{
									$alaune = $result["url_categorie"];
									$root = @simplexml_load_file($alaune);
									$desc = (string) $root->channel->description;
									
									print("<h2>".$result['titre_categorie']."</h2>");
									if($desc == "")
									{
										print($result["titre_categorie"]." - Actualites");
									}
									else
									{
									print("<p>".$desc."</p>");
									}
									print("<a href=categorie.php?categorie=".$result['id_categorie']." class='lien'>Fil d'actualité</a><br><br>");
								}
							}
						?>
						
					</td>
				</tr>
			</table>
		</div>	
		<div>
			<?php
				if(isset($_SESSION['pseudo']))
				{
					print('<table width="30%" align="right" class="tableajsup">');
					print('<tr>');
					print('<td>');
					print('<a href="ajouter.php" class="ajsup">Ajouter une catégorie</a>');
					print('</td>');
					print('</tr>');
					print('<tr><td><p align="center">ou</p></td></tr>');
					print('<tr>');
					print('<td>');
					print('<a href="supprimer.php" class="ajsup">Supprimer une catégorie</a>');
					print('</td>');
					print('</tr>');
					print('</table>');
				}
			?>
		</div>	
		<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
		
		<footer>
		<br>
			<table width="100%" align="center">
				<tr>
					<td>
						<hr>
							<p align="center">Copyright © 2013 Germain Tom & Blanchet Nicolas</p>
						<hr>
					</td>
				</tr>
			</table>		
		</footer>	
	</body>
</html>