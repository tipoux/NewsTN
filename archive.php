<?php
	session_start();

	include ("connexion_bdd.php");

	$lien = mysqli_connect($host,$user,$password,$bdd);
?>
	
<!DOCTYPE HTML>
<html>
	<head>
		<title>Actual | Archive</title>
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
									echo "Pas de catégorie disponible";
								}
								else
								{
									print('<td><span class="element"><a href=archives.php?archive='.$result["id_categorie"].'>'.$result["titre_categorie"].'</a></span><br></td>');
								}
							}
						?>
					</tr>
				</table><br>	
		</div>

<footer>
		<br>
			<table width="100%" align="center">
				<tr>
					<td>
						<hr width="75%">
							<p align="center">Copyright © 2013 Germain Tom & Blanchet Nicolas</p>
						<hr width="75%">
					</td>
				</tr>
			</table>		
		</footer>

</body>
</html>