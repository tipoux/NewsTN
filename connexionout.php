<!DOCTYPE html>
<html>
	<head>
		<title>Déconnexion</title>
		<link rel="stylesheet" type="text/css" href="accueilcss.css" />
		<link  rel="icon" href="images/bulle.jpg" Type="image/jpg">
		<meta charset="utf-8" />
		<meta name="description" content="">
		<meta name="keyword" content="">
	</head>
	
	<body>
		<table class="deconnect"><tr><td>
			<?php
				session_start();

				echo '<h1 align="center">Déconnexion effectuée !</h1>';
				echo '<p><center> Vous avez bien été déconnecté.';
				echo '<br>Vous allez être redirigé vers la page d\'accueil de notre site.';
				echo '<br><a href="index.php" title="Page d\'accueil">Cliquez ici si la redirection n\'a pas fonctionné.</a>';
				echo '</p>';
		
				unset($_SESSION["pseudo"]);
				unset($_SESSION["mod"]);
			?>

			<script type="text/javascript">
			<!--
			setTimeout('document.location.href = "index.php"', 2000);
			//-->
			</script>
		
		</td></tr></table>
		
	</body>
</html>