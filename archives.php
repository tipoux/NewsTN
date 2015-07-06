<?php
	session_start();

	$get = $_GET["archive"];

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
		<title>Actualtn | Archive</title>
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
		
		<div id="categorie">
			<h1 align="center">Archives</h1>
			<table width="auto" align="center" class="navarchive">
					<tr>
						<?php
							$sql = "SELECT titre_categorie, id_categorie FROM categorie";
							$query = mysqli_query($lien,$sql);
							while($result = mysqli_fetch_assoc($query))
							{
								if (!mysqli_num_rows($query))
								{
									echo "Pas d'archives disponible";
								}
								else
								{
									print('<td><span class="element"><a href=archives.php?archive='.$result["id_categorie"].'>'.$result["titre_categorie"].'</a></span><br></td>');
								}
							}
						?>
					</tr>
				</table>
			
			<br>
			
			<?php
				$messagesParPage=5;
							
				$sql_total='SELECT COUNT(*) AS total FROM archive where id_categorie = "'.$get.'" ';
				$retour_total=mysqli_query($lien, $sql_total);
				$donnees_total=mysqli_fetch_assoc($retour_total);
				$total=$donnees_total['total'];
							
				$nombreDePages=ceil($total/$messagesParPage);
							
				if(isset($_GET['page']))
				{
					$pageActuelle=intval($_GET['page']);
				 
					if($pageActuelle>$nombreDePages)
					{
					  $pageActuelle=$nombreDePages;
					}
				}
				else
				{
					$pageActuelle= 1;   
				}
							
				$premiereEntree=($pageActuelle-1)*$messagesParPage;



				$sql = 'SELECT DISTINCT titre_archive, description_archive, url_archive, date_archive, image_archive FROM archive WHERE id_categorie = "'.$get.'" ORDER BY date_archive DESC LIMIT '.$premiereEntree.', '.$messagesParPage.' ';
				$query = mysqli_query($lien, $sql) or die ("ERREUR SQL ! ".$sql);
				
				if(!mysqli_num_rows($query))
				{
					print ("Pas d'archives disponibles pour le moment");
				}
				else
				{	
					// print("<table>");
					while($result = mysqli_fetch_assoc($query))	
					{
						$image = $result["image_archive"];
						$date = date("d-m-Y", strtotime($result["date_archive"]));
						
						print("<table border=0 width='100%'><tr><td>");
						print("<b>".$result["titre_archive"]."</b><br>");
						print("<table align='right'><tr><td>".$date."</td></tr></table><br>");
						if($image == "")
						{
							print("");
						}
						else
						{
							print("<img class='image' src=".$image."><br>");
						}
						if($result["description_archive"] == "")
						{
							print ("<p class='description'>Description :</p>");
    						print ("<p><font color='red'>Pas de description</font></p>");
						}
						else
						{
							print ("<p><span class='description'>Description :</span><br><br>".$result['description_archive']."</p><br>");
						}
						print('<a class="lien" align="right" href='.$result["url_archive"].' target="_blank">En savoir plus</a>');
						print("</td></tr></table><br>");
					}
				}
				// print("</table>");
				
				print('<p align="center">Page : ');
				for($i=1; $i<=$nombreDePages; $i++)
				{ 
					if($i==$pageActuelle)
					{
						print(' [ '.$i.' ] '); 
					}	
					else 
					{
						print(' <a href="archives.php?archive='.$get.'&page='.$i.'">'.$i.'</a> ');
					}
				}
				print('</p>');
			?>
		</div>	
		
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

