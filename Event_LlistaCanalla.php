<html>
<head>
  <title>Pinyator - Inscrits esdeveniment</title>
  <meta charset="utf-8">
<?php include "$_SERVER[DOCUMENT_ROOT]/pinyator/utils/Head.php";?>
</head>
<script src="llibreria/inscripcio.js"></script>
<?php include "$_SERVER[DOCUMENT_ROOT]/pinyator/utils/Style.php";?>
<body>
<?php $menu=2; include "$_SERVER[DOCUMENT_ROOT]/pinyator/utils/Menu.php";

$estat = intval($_GET["e"]);
$id = intval($_GET["id"]);
$nom = "";
$public = false;

$link = "id=".$id."&e=".$estat;
$esEditable = 1;
?>
	<div>
	</div> 
	<table class='butons'>
		<tr class='butons'>
			<th class='butons'><a href="Event.php?e=<?php echo $estat?>" class="boto" >Torna</a></th>
			<th></th>
			
			<th class='butons'>
				Ordena per:
				<a href="Event_LlistaPrivat.php?<?php echo $link?>"  class="boto" >Malnom</a>
				<a href="Event_LlistaPrivat.php?<?php echo $link?>&o=ESTAT" class="boto" >Estat</a>
			</th>
		</tr>
	</table>

	<br>
<?php

$NoVincColor = "#ff1a1a";
$VincColor = "#33cc33";
$NoVistColor = "#FFFF00";
$AquiColor = "#B0E0E6";

if ($public)
{
	$url = "Event_Comentari_Public.php";
}
else
{
	$url = "Event_Comentari_Privat.php";
}

$ordenacio="MALNOM";
if (!empty($_GET["o"]))
{
	$ordenacio=($_GET["o"])." DESC,".$ordenacio;
}

if (!EsEventLv2()) $esEditable=0;

include "$_SERVER[DOCUMENT_ROOT]/pinyator/utils/Connexio.php";

$sql="SELECT E.NOM, date_format(E.DATA, '%d/%m/%Y %H:%i') AS DATA,
E.EVENT_PARE_ID
FROM EVENT AS E
WHERE E.EVENT_ID = ".$id;

$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0)
{
	while($row = mysqli_fetch_assoc($result))
	{
		if ($row["EVENT_PARE_ID"] < 1)
		{
			echo "<a href='".$url."?id=".$id."&nom=".$nom."' class='boto'>Comentaris</a>";
		}

		echo "<h3>".$row["NOM"]." - ".$row["DATA"]."</h3>";
	}
}

?>
<label id="txtErrors"></label>
 <table class="llistes">
  <tr class="llistes">
    <th class="llistes"><?php echo _("Malnom"); ?></th>
	<th class="llistes">CO.</th>
    <th class="llistes"><?php echo _("Estat"); ?></th>
	<?php if ($esEditable == 1) echo "<th class='llistes'>"._('Vinc')."</th><th class='llistes'>"._('No vinc')."</th><th class='llistes'>Aquí</th><th class='llistes'>Clear</th>";?>
  </tr>
<?php

$edicioInscripcio="";

$sql="SELECT C.MALNOM, IFNULL(I.ESTAT,-1) AS ESTAT, C.CODI, C.CASTELLER_ID,
IFNULL(I.ACOMPANYANTS,0) AS ACOMPANYANTS
FROM CASTELLER AS C
LEFT JOIN INSCRITS AS I ON C.CASTELLER_ID=I.CASTELLER_ID AND I.EVENT_ID=".$id."
WHERE C.POSICIO_TRONC_ID = 12
ORDER BY ".$ordenacio;

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0)
{
	$PosicioId = 0;
    // output data of each row
    while($row = mysqli_fetch_assoc($result))
	{
		$Acompanyants = "";
		if ($row["ACOMPANYANTS"] > 0)
		{
			$Acompanyants = $row["ACOMPANYANTS"];
		}

		$color = "";
		$a  = $row["ESTAT"];
		if ($a == 0)
		{
			$Estat = "No vinc";
			$color = "style='background-color:".$NoVincColor.";'";
		}
		elseif ($a == 1)
		{
			$Estat = "Vinc";
			$color = "style='background-color:".$VincColor.";'";
		}
		elseif ($a == 2)
		{
			$Estat = "Aqui";
			$color = "style='background-color:".$AquiColor.";'";
		}
		elseif ($a == -1)
		{
			$Estat = "????";
			$color = "style='background-color:".$NoVistColor.";'";
		}
		echo "<tr class='llistes'>";
		if ($esEditable == 1)
		{
			echo "<td class='llistes'><a href='Inscripcio.php?id=".$row["CODI"]."'>".$row["MALNOM"]."</a></td>";
		}
		else
		{
			echo "<td class='llistes'>".$row["MALNOM"]."</td>";
		}

		echo "<td class='llistes'>".$Acompanyants."</td>";
		echo "<td class='llistes' id=".$row["CASTELLER_ID"]." ".$color.">".$Estat."</td>";

		if ($esEditable == 1)
		{
			echo "<td class='llistes'><button class='boto' style='background-color:".$VincColor."' onClick='Vinc(".$row["EVENT_ID"].", ".$row["CASTELLER_ID"].")'>&nbsp+&nbsp</button></td>";
			echo "<td class='llistes'><button class='boto' style='background-color:".$NoVincColor."' onClick='NoVinc(".$row["EVENT_ID"].", ".$row["CASTELLER_ID"].")'>&nbsp-&nbsp</button></td>";
			echo "<td class='llistes'><button class='boto' style='background-color:".$AquiColor."' onClick='Aqui(".$row["EVENT_ID"].", ".$row["CASTELLER_ID"].")'>&nbspA&nbsp</button></td>";
			echo "<td class='llistes'><button class='boto' style='background-color:".$NoVistColor.";color:black' onClick='Esborra(".$row["EVENT_ID"].", ".$row["CASTELLER_ID"].")'>&nbsp?&nbsp</button></td>";
		}
		echo "</tr>";
    }
}
else if (mysqli_error($conn) != "")
{
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);

?>
	</table>
   </body>
</html>

