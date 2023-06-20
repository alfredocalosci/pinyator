<html>
<head>
  <title>Pinyator</title>
</head>
<body>
<?php
$id = intval($_POST["id"]);
$nom = strval($_POST["nom"]);
$cognom1 = strval($_POST["cognom1"]);
$cognom2 = strval($_POST["cognom2"]);
$posicioPinya = intval($_POST["posiciopinyaid"]);
$posicioTronc = intval($_POST["posiciotroncid"]);
$altura = intval($_POST["altura"]);

include "$_SERVER[DOCUMENT_ROOT]/pinyator/utils/Connexio.php";

$nom = GetStrDB($nom);
$cognom1 = GetStrDB($cognom1);
$cognom2 = GetStrDB($cognom2);
$altura = GetStrDB($altura);
$posicioPinya = GetStrDB($posicioPinya);
$posicioTronc = GetStrDB($posicioTronc);

if ($id > 0)
{
	$sql="UPDATE CASTELLER SET NOM='".$nom."',COGNOM_1='".$cognom1."',COGNOM_2='".$cognom2."'
	,POSICIO_PINYA_ID=".$posicioPinya.",POSICIO_TRONC_ID=".$posicioTronc."
	,ALTURA=".$altura." WHERE CASTELLER_ID = ".$id;
}

if (mysqli_query($conn, $sql))
{
	echo "<meta http-equiv='refresh' content='0; url=Casteller.php'/>";
}
else if (mysqli_error($conn) != "")
{
	echo $id.";".$nom.";".$data;
	echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);

?>
<a href='Casteller.php'><?php echo _("Torna als Castellers"); ?></a>
</body>
</html>
