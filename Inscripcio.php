<?php
if (!empty($_GET['id']))
{
	$cookie_name = "marrec_inscripcio";
	$cookie_value = strval($_GET['id']);
	if((isset($_COOKIE[$cookie_name])) && ($_COOKIE[$cookie_name] != $cookie_value))
	{
		unset($_COOKIE[$cookie_name]);
		setcookie($cookie_name, $cookie_value, -1, "/"); // 86400 = 1 day
	}
	else
	{
		setcookie($cookie_name, $cookie_value, time() + (86400 * 320), "/"); // 86400 = 1 day
	}
}
?>

<html>
<head>
  <title>Pinyator CCM | Inscripció</title>
  <meta name="robots" content="noindex, nofollow">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="apple-touch-icon" sizes="111x192" href="images\logo192.png">
  <link rel="icon" sizes="111x192" href="images\logo192.png">
  <script src="llibreria/inscripcio.js?v=1.4"></script>
</head>
<?php include "$_SERVER[DOCUMENT_ROOT]/pinyator/utils/Style.php";?>
<?php include "$_SERVER[DOCUMENT_ROOT]/pinyator/utils/TranslatorHelper.php";?>
<br>
<body style='background-color:#cce6ff;'>
<!-- <div style='position: fixed; z-index: -1; width: 90%; height: 80%;background-image: url("images/logo-ccm.png");background-repeat: no-repeat;
background-attachment: fixed;  background-position: center; opacity:0.4'>
</div> Comentado por ahora -->

<?php
	$topLlista = 60;

	include "$_SERVER[DOCUMENT_ROOT]/pinyator/utils/Connexio.php";

	$visualitzarFites = 0;
	$visualitzarPenya = 0;

	$sql="SELECT FITES, PARTICIPANTS
	FROM CONFIGURACIO";

	$result = mysqli_query($conn, $sql);

	if (mysqli_num_rows($result) > 0)
	{
		while($row = mysqli_fetch_assoc($result))
		{
			$visualitzarFites = $row["FITES"];
			$visualitzarPenya = $row["PARTICIPANTS"];
		}
	}
?>

<div style='position: absolute;'><a href="Apuntat.php?reset=1" class="boto" ><?php echo _('No sóc jo') ?></a>
<?php
	if ($visualitzarFites)
	{
		$topLlista = 100;
		echo "<br><br><a href='Fites_Llista.php'>
				<img src='images/trofeo.png' width=48 height=48>
			</a>";
	}
?>
</div>
<!-- Comentando esto por ahora, porque no hace falta, el equipo no lo utiliza y genera un extra de complejidad, performance y procesamiento que nos podemos ahorrar. -->
<!-- Commented area START -->
<!-- <div style="position: absolute; right: 0px; top: 4px;"> -->
<!-- <?php
    $eventId=0;
	$hashtag="";
	$hasHash=0;

	$sql="SELECT EVENT_ID, HASHTAG
	FROM EVENT
	WHERE CONTADOR=1
	AND ESTAT=1
	ORDER BY DATA LIMIT 1";

	$result = mysqli_query($conn, $sql);

	if (mysqli_num_rows($result) > 0)
	{
		$row = mysqli_fetch_assoc($result);
		$eventId = $row["EVENT_ID"];
		$hashtag = $row["HASHTAG"];
		if(strpos($hashtag, '#') !== false)
		{
			$hashtag=str_replace("#", "", $hashtag);
			$hasHash=1;
		}
	}

	echo "<iframe src='Counter.php?id=".$eventId."&h=".$hashtag."&hh=".$hasHash."' class='counterframe' id='counterCastellers'></iframe>";
?> -->
<!-- </div> -->
<!-- Commented area END -->

<div style="position: absolute; right: 6px; left: 6px; top: <?php echo $topLlista?>px;">
	<a class="pull-right" href=<?php echo "?lang=".$altLangCode.""?>><span class="glyphicon glyphicon-globe"></span><?php echo _('Canviar a')." ".$altLangName?></a>
<?php
if ((!empty($_GET['id'])) && (isset($_COOKIE[$cookie_name])))
{
	$Casteller_uuid = strval($_GET['id']);
	$Casteller_id=0;
	$malnom="";
	$malnomPrincipal="";

	$sql="SELECT C.MALNOM, C.CASTELLER_ID
	FROM CASTELLER AS C
	WHERE C.CODI='".$Casteller_uuid."'";

	$result = mysqli_query($conn, $sql);

	if (mysqli_num_rows($result) > 0)
	{
		while($row = mysqli_fetch_assoc($result))
		{
			$malnom=$row["MALNOM"];
			$malnomPrincipal=$row["MALNOM"];
			echo "<h2>".$malnom."</h2>";
			$Casteller_id = $row["CASTELLER_ID"];
		}
	}
	echo "<h3>"._('Llista esdeveniments disponibles').":</h3>";

	include "$_SERVER[DOCUMENT_ROOT]/pinyator/utils/Inscripcio_taula.php";

	$sql="SELECT DISTINCT C.CODI, C.MALNOM, C.CASTELLER_ID
	FROM CASTELLER AS CR
	INNER JOIN CASTELLER AS C ON C.FAMILIA_ID = CR.CASTELLER_ID OR C.FAMILIA2_ID = CR.CASTELLER_ID
	WHERE CR.CODI='".$Casteller_uuid."'
	ORDER BY C.MALNOM";

	$result = mysqli_query($conn, $sql);

	if (mysqli_num_rows($result) > 0)
	{
		while($row = mysqli_fetch_assoc($result))
		{
			$malnom = $row["MALNOM"];
			echo "<h3>".$malnom."</h3>";
			$Casteller_id = $row["CASTELLER_ID"];
			include "$_SERVER[DOCUMENT_ROOT]/pinyator/utils/Inscripcio_taula.php";
		}
	}

	mysqli_close($conn);
}
else
{
	echo "<meta http-equiv='refresh' content='0; url=Apuntat.php'/>";
}


?>
</div>
   </body>
</html>
