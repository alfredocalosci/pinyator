<html>
<head>
	<title>Pinyator - Castellers</title>
	<?php include "$_SERVER[DOCUMENT_ROOT]/pinyator/utils/Head.php";?>
	<script src="llibreria/grids.js"></script>

</head>
<?php include "$_SERVER[DOCUMENT_ROOT]/pinyator/utils/Style.php";?>
<script src="llibreria/table2CSV.js"></script>
<body>
<?php $menu=1; include "$_SERVER[DOCUMENT_ROOT]/pinyator/utils/Menu.php";?>
	<table class="butons">
		<tr>
			<th>
				<a href="Casteller_Fitxa.php" class="boto" <?php CastellerLv2Not("hidden")?>><?php echo _('Nou'); ?></a>
			</th>
			<th></th>
			<th>
				<input type="text" id="edtCerca" style="width:200" class="form_edit" onkeyup="CercaEnter(event)" placeholder="<?php echo _('Cerca'); ?>..." title="<?php echo _('Cerca'); ?>...">
				<button class="boto" onClick="Cerca()"><?php echo _('Cerca'); ?></button>
			</th>
			<!--th>
				<input type="text" id="edtFiltra" style="width:200" class="form_edit" onkeyup="filterTable(this,'castellers')" placeholder="Filtra.." title="Filtr...">
			</th-->
			<th><a class="boto" onClick="ExportCSV()"><?php echo _('Exporta CSV'); ?></a></th>
		</tr>
	</table>
	<label id="Total"></label>
	<br>
	<table class="llistes" id="castellers">
		<tr class="llistes">
			<th class="llistes" onClick="sortTable(0,'castellers')"><?php echo _('Malnom'); ?><i></i></th>
			<th class="llistes" onClick="sortTable(1,'castellers')"><?php echo _('Nom'); ?><i></i></th>
			<th class="llistes" onClick="sortTable(2,'castellers')"><?php echo _('Cognom 1er'); ?><i></i></th>
			<th class="llistes" onClick="sortTable(3,'castellers')"><?php echo _('Cognom 2on'); ?><i></i></th>
			<th class="llistes" onClick="sortTable(4,'castellers')"><?php echo _('Posicio pinya'); ?><i></i></th>
			<th class="llistes" onClick="sortTable(5,'castellers')"><?php echo _('Posicio tronc'); ?><i></i></th>
			<th class="llistes" onClick="sortTable(6,'castellers')"><?php echo _('Altura'); ?><i></i></th>
			<th class="llistes" <?php CastellerLv2Not("hidden")?>><?php echo _('Assistència'); ?></th>
			<th class="llistes" onClick="sortTable(7,'castellers')"><?php echo _('Estat'); ?><i></i></th>
			<!-- <th class="llistes" onClick="sortTable(8,'castellers')"><?php //echo _('Responsables'); ?><i></i></th> -->
			<th class="llistes" <?php CastellerLv2Not("hidden")?>></th>
			<th class="llistes" <?php CastellerLv2Not("hidden")?>></th>
		</tr>
<?php
	$count = 0;
	include "$_SERVER[DOCUMENT_ROOT]/pinyator/utils/Connexio.php";

	$count=0;

	$baixa = "";
	if (!empty($_GET["e"]))
	{
		$baixa=" OR C.ESTAT = 2";
	}
	if (empty($_GET["b"]))
	{
		$value = "($)($)";
	} else {
		$value = strval($_GET["b"]);
	}

	// START Posicio
	$pinyaPosicions = array();
	$troncPosicions = array();
	$sql="SELECT POSICIO_ID, NOM, ESTRONC
	FROM POSICIO
	ORDER BY NOM ";
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0)
	{
		while($row = mysqli_fetch_assoc($result))
		{
			if ($row["ESTRONC"] == 0) {
				$pinyaPosicions[] = array($row["POSICIO_ID"], $row["NOM"]);
			} else if ($row["ESTRONC"] == 1) {
				$troncPosicions[] = array($row["POSICIO_ID"], $row["NOM"]);
			}
		}
	}
	else if (mysqli_error($conn) != "")
	{
		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}
	//$veureCanalla = EsCastellerLv2() ? "" : " AND (IFNULL(P1.ESCANALLA, 0) = 0)";

	$where = "";
	if($value != "($)($)")
	{
		$where = " AND ((C.MALNOM LIKE '%".$value."%')
			OR (C.NOM LIKE '%".$value."%')
			OR (C.COGNOM_1 LIKE '%".$value."%')
			OR (C.COGNOM_2 LIKE '%".$value."%')
			OR (P1.NOM LIKE '%".$value."%')
			OR (P2.NOM LIKE '%".$value."%')) ";
	}

	$sql="SELECT C.CASTELLER_ID, IFNULL(C.MALNOM, '---') AS MALNOM, C.NOM, C.COGNOM_1, C.COGNOM_2,
	P1.NOM AS POSICIO_PINYA, P2.NOM AS POSICIO_TROC,C.CODI,
	CR1.MALNOM AS RESPONSABLE1, CR2.MALNOM AS RESPONSABLE2, C.POSICIO_PINYA_ID, C.POSICIO_TRONC_ID,
	C.ALTURA, CASE WHEN C.ESTAT = 1 THEN 'ACTIU' ELSE 'BAIXA' END AS ESTAT
	FROM CASTELLER AS C
	LEFT JOIN POSICIO AS P1 ON P1.POSICIO_ID=C.POSICIO_PINYA_ID
	LEFT JOIN POSICIO AS P2 ON P2.POSICIO_ID=C.POSICIO_TRONC_ID
	LEFT JOIN CASTELLER AS CR1 ON CR1.CASTELLER_ID=C.FAMILIA_ID
	LEFT JOIN CASTELLER AS CR2 ON CR2.CASTELLER_ID=C.FAMILIA2_ID
	WHERE 1=1
	".$where."
	ORDER BY C.MALNOM";

	$result = mysqli_query($conn, $sql);

	if (mysqli_num_rows($result) > 0)
	{
		$PosicioId = 0;
		// output data of each row
		while($row = mysqli_fetch_assoc($result))
		{
			$castellerId = $row["CASTELLER_ID"];
			$malnom = $row["MALNOM"];
			if ($malnom== "")
			{
				$malnom = "----";
			}
			if ($row["ESTAT"] == "ACTIU")
			{
				$a=2;
				$aTxt="BAIXA";
			}
			else
			{
				$a=1;
				$aTxt="ACTIU";
			}
			$posicioPinya = $row["POSICIO_PINYA_ID"];
			$posicioTronc = $row["POSICIO_TRONC_ID"];
			$malnom = SiCastellerLv2("<a href='Casteller_Fitxa.php?id=".$castellerId."'>".$malnom."</a>", $malnom);
			$codi = SiCastellerLv2("<td class='llistes'><a href='Inscripcio.php?id=".$row["CODI"]."'>"._('Veure')."</a></td>", "");
			$accio = SiCastellerLv2("<td class='llistes'><a href='Casteller_Accio.php?id=".$castellerId."&a=".$a."'>".$aTxt."</a></td>", "");

			echo "<tr class='llistes'>";
			echo "<td class='llistes'>".$malnom."</td>";
			echo "<td class='llistes'><input name='nom' value='".$row["NOM"]."' disabled/></td>";
			echo "<td class='llistes'>";
			echo "<input name='cognom1' value='".$row["COGNOM_1"]."' disabled/>";
			echo "</td>";
			echo "<td class='llistes'>";
			echo "<input name='cognom2' value='".$row["COGNOM_2"]."' disabled/>";
			echo "</td>";
			echo "<td class='llistes'>";
			echo "<select class='form_edit' name='posiciopinyaid' disabled>";
			echo "<option value=0>"._("Sense posicio")."</option>";
			foreach($pinyaPosicions as $posicio) {
				$selected="";
				if($posicio[0]==$posicioPinya)
				{
					$selected="selected";
				}
				echo "<option value=".$posicio[0]." ".$selected.">".$posicio[1]."</option>";
			}
			echo "</select>";
			echo "</td>";
			echo "<td class='llistes'>";
			echo "<select class='form_edit' name='posiciotroncid' disabled>";
			echo "<option value=0>"._("Sense posicio")."</option>";
			foreach($troncPosicions as $posicio) {
				$selected="";
				if($posicio[0]==$posicioTronc)
				{
					$selected="selected";
				}
				echo "<option value=".$posicio[0]." ".$selected.">".$posicio[1]."</option>";
			}
			echo "</select>";
			echo "</td>";
			echo "<td class='llistes'><input value='".$row["ALTURA"]."' name='altura' disabled/></td>";
			echo $codi;
			echo "<td class='llistes'>".$row["ESTAT"]."</td>";
			// echo "<td class='llistes'>".implode(", ", array_filter([$row["RESPONSABLE1"],$row["RESPONSABLE2"]]))."</td>";
			echo $accio;
			echo "<td class='llistes'>";
			echo "<button type='button' name='edita' class='boto' onClick='editRow(this)'>"._("Edita")."</button>";
			echo "<div class='desa-btn-container' style='display: none;'>";
			echo "<button type='button' name='desa' class='boto' onClick='saveRow(this, ".$castellerId.")'>"._("Desa")."</button>";
			echo "<button type='button' name='close' class='btn btn-danger btn-xs' onclick='cancel(this)'>x</button>";
			echo "</div>";
			echo "</td>";
			echo "</tr>";
			$count++;
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
<script>
	function editRow(elem)
	{
		var $row = $(elem).closest('tr');
		$row.find('select:disabled, input:disabled').attr('disabled', false);
		$row.find('button[name="edita"]').hide();
		$row.find('div.desa-btn-container').show();
	}
	function saveRow(elem, id)
	{
		var $row = $(elem).closest('tr');
		var data = {
			'id': id,
			'nom': $row.find('[name="nom"]').val(),
			'cognom1': $row.find('[name="cognom1"]').val(),
			'cognom2': $row.find('[name="cognom2"]').val(),
			'posiciopinyaid': $row.find('[name="posiciopinyaid"]').val(),
			'posiciotroncid': $row.find('[name="posiciotroncid"]').val(),
			'altura': $row.find('[name="altura"]').val()
		};

		$.post( "Casteller_Inline_Desa.php", data)
			.done(function( response ) {
				console.log("Canvi desat.");
			})
			.fail(function (response) {
				console.log(response);
			});
		$row.find('select, input').attr('disabled', true);
		$row.find('div.desa-btn-container').hide();
		$row.find('button[name="edita"]').show();
	}
	function cancel(elem)
	{
		var $row = $(elem).closest('tr');
		$row.find('select, input').attr('disabled', true);
		$row.find('div.desa-btn-container').hide();
		$row.find('button[name="edita"]').show();
	}

	function ExportCSV()
	{
		$("#castellers").table2CSV();
	}

	sortTable(0,'castellers');
	<?php echo "setTotal('Total', ".$count.");"; ?>



	function Cerca()
	{
		input = document.getElementById("edtCerca").value;
		if (input == "")
			input = "($)($)";
		window.open("Casteller.php?b=" + input, "_self");
	}

	function CercaEnter(event)
	{
		var code = event.keyCode;
		 if (event.charCode && code == 0)
		 {
			code = event.charCode;
		 }
		 if(code == 13)
		{
			Cerca();
		}
	}


</script>
</html>
