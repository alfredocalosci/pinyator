<select class="form_edit" name="posiciotroncid">
	<option value=0><?php echo _("Sense posicio"); ?></option>
	<?php

			$sql="SELECT POSICIO_ID, NOM
			FROM POSICIO
			WHERE ESTRONC=1
			ORDER BY NOM ";

			$result = mysqli_query($conn, $sql);

			if (mysqli_num_rows($result) > 0)
			{
				while($row = mysqli_fetch_assoc($result))
				{
					$selected="";
					if($row["POSICIO_ID"]==$posicioTronc)
					{
						$selected="selected";
					}
					echo "<option value=".$row["POSICIO_ID"]." ".$selected.">".$row["NOM"]."</option>";
				}
			}
			else if (mysqli_error($conn) != "")
			{
				echo "Error: " . $sql . "<br>" . mysqli_error($conn);
			}
	?>
</select>
