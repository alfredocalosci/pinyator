<html>
<head>
  <title>Pinyator</title>
</head>
<body>
<?php
$id = intval($_POST["id"]);
$nom = strval($_POST["nom"]);
$data = $_POST["data"];
$locacio = strval($_POST["locacio"]);
$hora = $_POST["hora"];
$tipus = intval($_POST["tipus"]);
$estat = intval($_POST["estat"]);
$pare = intval($_POST["eventpareid"]);
$hashtag = strval($_POST["hashtag"]);
$temporada = strval($_POST["temporada"]);
$esplantilla = 0;
$contador = 0;

if (!empty($_POST["esplantilla"]))
{
	$esplantilla = intval($_POST["esplantilla"]);
}
if (!empty($_POST["escontador"]))
{
	$contador = intval($_POST["escontador"]);
}

include "$_SERVER[DOCUMENT_ROOT]/pinyator/utils/Connexio.php";

$nom = GetStrDB($nom);
$hashtag = GetStrDB($hashtag);
$temporada = GetStrDB($temporada);

if ($id > 0)
{
	$sql="UPDATE EVENT SET NOM='".$nom."',DATA='".GetFormatedDateTime($data,$hora)."',LOCACIO='".$locacio."',TIPUS=".$tipus.",ESTAT=".$estat.",EVENT_PARE_ID=".$pare."
	,ESPLANTILLA=".$esplantilla.",CONTADOR=".$contador.",HASHTAG='".$hashtag."',TEMPORADA='".$temporada."'  
	WHERE EVENT_ID = ".$id.";";
	$sql=$sql." UPDATE EVENT SET ESTAT=".$estat." WHERE EVENT_PARE_ID = ".$id.";";
}
else
{
	$sql="INSERT INTO EVENT(NOM,DATA,LOCACIO,TIPUS,ESTAT,EVENT_PARE_ID,ESPLANTILLA,CONTADOR,HASHTAG,TEMPORADA) VALUES('".$nom."','".GetFormatedDateTime($data,$hora)."','".$locacio."',".$tipus.",".$estat.",".$pare.",".$esplantilla.",".$contador.",'".$hashtag."','".$temporada."');";
}

if (mysqli_multi_query($conn, $sql)) 
{	
	echo "<meta http-equiv='refresh' content='0; url=Event.php'/>";
} 
else if (mysqli_error($conn) != "")
{
	echo $id.";".$nom.";".$data;
	echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);


?>
<a href='Event.php'>Torna als Esdeveniments.</a>
</body>
</html>