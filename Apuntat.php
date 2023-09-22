<?php
$cookie_name = "marrec_inscripcio";
if (!empty($_GET['reset']))
{
	unset($_COOKIE[$cookie_name]);
	setcookie($cookie_name, "", -1);
}
?>
<html>
<head>
    <title>Pinyator CCM | Apuntat</title>
    <meta name="robots" content="noindex, nofollow">
    <meta charset="utf-8">
</head>
<?php include "$_SERVER[DOCUMENT_ROOT]/pinyator/utils/Style.php";?>
<body>

<?php include "$_SERVER[DOCUMENT_ROOT]/pinyator/utils/Politica_Cookies.php";?>
<?php include "$_SERVER[DOCUMENT_ROOT]/pinyator/utils/TranslatorHelper.php";?>

<?php
if(!isset($_COOKIE[$cookie_name]))
{
	include "$_SERVER[DOCUMENT_ROOT]/pinyator/utils/Connexio.php";


	echo "<br>";
	echo "<table class='llistes'>";
	echo "<tr class='llistes'>";
	echo "<th class='llistes'>"._('Malnom')."</th>";
	echo "</tr>";

	$sql="SELECT C.MALNOM, C.CODI
	FROM CASTELLER AS C
	LEFT JOIN POSICIO P ON P.POSICIO_ID=C.POSICIO_PINYA_ID
	WHERE ESCANALLA=0 OR ESCANALLA IS NULL
	ORDER BY MALNOM";

	$result = mysqli_query($conn, $sql);

	if (mysqli_num_rows($result) > 0)
	{
		// output data of each row
		while($row = mysqli_fetch_assoc($result))
		{
			echo "<tr class='llistes'>";

			echo "<td class='llistes'><a href='Inscripcio.php?id=".$row["CODI"]."'>".$row["MALNOM"]."</a></td>";

			echo "</tr>";
		}
	}
	else if (mysqli_error($conn) != "")
	{
		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}

	mysqli_close($conn);

	echo "</table>";
}
 else
{
    echo "<meta http-equiv='refresh' content='0; url=Inscripcio.php?id=".$_COOKIE[$cookie_name]."'/>";
}
?>

   </body>
</html>
