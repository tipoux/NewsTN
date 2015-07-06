<?php
$alaune = $result["url_categorie"];
$root = @simplexml_load_file($alaune);

$imgurl = (string) $root->channel->image->url;
$imgtit = (string) $root->channel->image->title;
$imglink = (string) $root->channel->image->link;


print ("<a href='$imglink' target='_blank'><img src='$imgurl' title='$imgtit' alt='$imgtit'/></a> ");


function convertit($chaine)
{
  $tab_htm = array("&amp;#34;","&amp;#39;");
  $tab_fin = array("\"", "'");
  $chaine = str_replace($tab_htm, $tab_fin, $chaine);
  return $chaine;
}

$i=1;
echo "<dl> ";
foreach($root->channel->item as $actu)
{
	$get = $_GET['categorie'];
	$date = date("d-m-Y", strtotime($actu->pubDate));
	$date2 = date("Y-m-d H:i:s", strtotime($actu->pubDate));
	
	$titre = $actu->title;
	$url = $actu->link;
	$description = $actu->description;
	$image = $actu->enclosure["url"];
	
	print ("<b>".$titre."</b><br>");
	if($image == "")
	{
		print("");
	}
	else
	{
	print ('<img class="image" src="'.$image.'"> ');
	}
	print ("<table align='right'><tr><td>".$date2."</td></tr></table><br>");
	if($description == "")
    {
    	print ("<p class='description'>Description :</p>");
    	print ("<p><font color='red'>Pas de description</font></p>");
    }
    else
    {
    	print ("<p><span class='description'>Description :</span><br><br>".$description."</p><br>");
    }
    print ('<a class="lien" align="right" href="'.$url.'" target="_blank">Plus d\'info ici</a><br><br> ');
    
    print("<hr><br>");
    
   include ("connexion_bdd.php");
    
    $lien = mysqli_connect($host,$user,$password,$bdd);
    
    $sql = 'SELECT id_categorie, date_archive FROM archive WHERE id_categorie = "'.$get.'" AND date_archive = "'.$date2.'" ';
    $query = mysqli_query($lien, $sql) or die ("ERREUR SQL ! ".$sql);
    if(mysqli_num_rows($query))
    {
    	print ("");
    }
    else
    {
    	$sqlajout = 'INSERT INTO archive VALUES ("", "'.$get.'", "'.addslashes($titre).'", "'.addslashes($description).'", "'.$url.'", "'.$date2.'", "'.$image.'")';
    	mysqli_query($lien, $sqlajout) or die ("ERREUR SQL ! ".$sqlajout);
    }
       
	if (++$i>10) 
	{
		break;
	}	
}
echo "</dl> ";
?>