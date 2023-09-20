<?php
if (!empty($Casteller_id))
{
	$script = "";

	$sql="SELECT E.EVENT_ID, E.NOM AS EVENT_NOM, E.LOCACIO AS EVENT_LOCACIO, E.EVENT_PARE_ID,
	date_format(E.DATA, '%d-%m-%Y %H:%i') AS DATA, ".$Casteller_id." AS CASTELLER_ID, IFNULL(I.ESTAT,-1) AS ESTAT,
	IFNULL(EP.DATA, E.DATA) AS ORDENACIO,
	IFNULL(I.ACOMPANYANTS, 0) AS ACOMPANYANTS, E.TIPUS,
	(SELECT SUM(C.PUBLIC) FROM CASTELL AS C WHERE C.EVENT_ID=E.EVENT_ID) AS PUBLIC,
	(SELECT SUM(IF(IU.ESTAT > 0, 1,0))
		FROM INSCRITS IU
		JOIN CASTELLER C ON C.CASTELLER_ID=IU.CASTELLER_ID
		JOIN POSICIO P ON P.POSICIO_ID=C.POSICIO_PINYA_ID
		WHERE IU.EVENT_ID=E.EVENT_ID
		AND IU.ESTAT > 0
		AND (P.ESNUCLI=1 OR P.ESTRONC=1 OR P.ESCORDO=1)) AS APUNTATS,
	(SELECT SUM(IF(IU.ESTAT>0,1,0)) + SUM(IFNULL(IU.ACOMPANYANTS, 0))
		FROM INSCRITS IU
		JOIN CASTELLER C ON C.CASTELLER_ID=IU.CASTELLER_ID
		WHERE IU.EVENT_ID=E.EVENT_ID
		) AS APUNTATS_ALTRES
	FROM EVENT AS E
	LEFT JOIN EVENT AS EP ON EP.EVENT_ID = E.EVENT_PARE_ID
	LEFT JOIN CASTELLER_INSCRITS AS I ON I.EVENT_ID = E.EVENT_ID AND I.CASTELLER_ID=".$Casteller_id."
	WHERE E.ESTAT = 1
	ORDER BY ORDENACIO, E.EVENT_PARE_ID, E.DATA";

	$result2 = mysqli_query($conn, $sql);

	if (mysqli_num_rows($result2) > 0)
	{
		$PosicioId = 0;
		echo "<table width='100%' class='tabla-inscripcio'>
			<tr>
				<th  width='60%'>"._('Esdeveniments')."</th>";
		if ($visualitzarPenya)
		{
			echo "	<th width='20%'>Som</th>";
		}
		else
		{
			echo "	<th width='1%'></th>";
		}

		echo "	<th width='20%'>"._('Estat')."</th>
			</tr>";
		// output data of each row
		while($row2 = mysqli_fetch_assoc($result2))
		{
			$idElement="E".$row2["EVENT_ID"]."C".$row2["CASTELLER_ID"];

			$comment = "<a href='Event_Comentari_Public.php?id=".$row2["EVENT_ID"]."&nom=".$malnomPrincipal."'><img src='images/comment.png'></img></a>";

			$apuntats=0;
			if ($visualitzarPenya == 1)
			{
				if (($row2["APUNTATS"] > 0) && ($row2["TIPUS"] != -1))
				{
					$apuntats=$row2["APUNTATS"];
				}
				else if (($row2["APUNTATS_ALTRES"] > 0) && ($row2["TIPUS"] == -1))
				{
					$apuntats=$row2["APUNTATS_ALTRES"];
				}
			}

			if ($row2["PUBLIC"]>0)
			{
				$eventNom = "<a href='Actuacio.php?id=".$row2["EVENT_ID"]."'><b>".$row2["EVENT_NOM"]."</b></a>";
			}
			else
			{
				$eventNom = "<b>".$row2["EVENT_NOM"]."</b>";
			}
			$eventLocacio = "";
			if ($row2["EVENT_LOCACIO"] != "") {
			    $eventLocacio = "<span class='event-locacio'>".$row2["EVENT_LOCACIO"]."</span>";
			}
			$stat  = $row2["ESTAT"];
			if ($stat == -1)
			{
				// Comentado para que figure como no contestado.
				//$stat = 0;
				//$script .= "PrimerSave(".$row2["EVENT_ID"].",".$row2["CASTELLER_ID"].");";
				$color = "style='background-color:#FFFF00; color: grey;'";
				$estat=_('No ho sé');
			}

			if ($stat == 0)
			{
				$color = "style='background-color:#ff1a1a;'";
				$estat=_('No vinc');
			}
			elseif ($stat == 1)
			{
				$color = "style='background-color:#33cc33;'";//green
				$estat=_('Vinc');
			}

			$tInici = "";
			$tFinal = "";
			if ($row2["EVENT_PARE_ID"] > 0)
			{
				$tInici = "<li>";
				$tFinal = "</li>";
			}

			$acompanyants = "";
			if ($row2["TIPUS"] == -1)
			{
				$acompanyants = "<button class='boto' onClick='IncrementaAcompanyant(".$row2["EVENT_ID"].", ".$row2["CASTELLER_ID"].")'>&nbsp+&nbsp</button>";
				$acompanyants .= "&nbsp&nbsp&nbsp<font size='2px'><b>Acompanyants:</b></font> <label id='AE".$row2["EVENT_ID"]."C".$row2["CASTELLER_ID"]."'>".$row2["ACOMPANYANTS"]."</label>&nbsp&nbsp&nbsp";
				$acompanyants .= "<button class='boto' onClick='DecrementaAcompanyant(".$row2["EVENT_ID"].", ".$row2["CASTELLER_ID"].")'>&nbsp-&nbsp</button>";
			}

			$script .= "EventNou(".$row2["EVENT_ID"].",".$stat.",".$row2["CASTELLER_ID"].");";
			echo "<tr>
			<td width='85%'>".$tInici.$comment.$eventNom."<br>".$row2["DATA"]."<br>".$acompanyants.$tFinal.$eventLocacio."</td>";
			if ($visualitzarPenya)
			{
				echo "<td><b name='E".$row2["EVENT_ID"]."'>".$apuntats."</b></td>";
			}
			else
			{
				echo "<td></td>";
			}
			echo "<td><button class='boto' onClick='Save(".$row2["EVENT_ID"].", ".$row2["CASTELLER_ID"].")' data-vinc-label="._('Vinc')." data-novinc-label='"._('No vinc')."' id=".$idElement." ".$color.">".$estat."</button></td>
			</tr>";
		}
		echo "</table>";

		echo "<script>".$script."</script>";
	}
	else if (mysqli_error($conn) != "")
	{
		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}
}
?>
