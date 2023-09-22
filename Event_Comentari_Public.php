<html>
<head>
  <title>Pinyator CCM | Inscrits esdeveniment</title>
  <meta name="robots" content="noindex, nofollow">
  <meta charset="utf-8">
</head>
<?php include "$_SERVER[DOCUMENT_ROOT]/pinyator/utils/Style.php";?>
<body>
<?php  
	$id = intval($_GET["id"]);
	$nom = strval($_GET["nom"]); ?>
	
	<table class='butons'>
		<tr class='butons'>
			<th class='butons'><a href="Apuntat.php" class="boto" >Torna</a>
			<a href="Event_Comentari_Fitxa_Public.php?id=<?php echo $id?>&nom=<?php echo $nom?>" class="boto" >Nou</a></th>
		</tr>
	</table>

	<?php 	
include "Event_Comentari_Llista.php";
?>
   </body>
</html>

