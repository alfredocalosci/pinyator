<div class="topnav" id="MainTopnav">

<a href="Pinyator.php"  style="padding:3px 10px"><img src="images/logo.png"></a>
<?php include "$_SERVER[DOCUMENT_ROOT]/pinyator/utils/TranslatorHelper.php";?>
<?php

$event="";
$casteller="";
$plantilla="";
$castell="";
$planificacio="";
$login="";
$llistats="";
$usuaris="";
$posicions="";
$estadistiques="";
$configuracio="";

if($menu==1) $casteller="class='active'";
if($menu==2) $event="class='active'";
if($menu==3) $plantilla="class='active'";
if($menu==4) $castell="class='active'";
if($menu==-1) $login="class='active'";
if($menu==5) $llistats="class='active'";
if($menu==6) $usuaris="class='active'";
if($menu==7) $posicions="class='active'";
if($menu==8) $estadistiques="class='active'";
if($menu==9) $planificacio="class='active'";
if($menu==10) $configuracio="class='active'";

if (EsURLEvent() && !EsEventLv1())
{
	Redirecciona();
}
else if (EsURLCasteller() && !EsCastellerLv1())
{
	Redirecciona();
}
else if (EsURLCasteller() && !EsCastellerLv2() && !ContainsUrl("Casteller.php"))
{
	Redirecciona();
}
else if (EsURLCastell() && !EsCastellLv2())
{
	Redirecciona();
}
else if (EsURLBoss() && !EsBossLv2())
{
	Redirecciona();
}
else if (EsURLAdmin() && !EsAdmin())
{
	Redirecciona();
}

	if (EsCastellerLv1())
	{
		echo  "<a ".$casteller." href='Casteller.php'>Casteller</a>";
	}
	if (EsEventLv1())
	{
		echo  "<a ".$event." href='Event.php?e=1'>"._('Esdeveniments')."</a>";
	}
	if (EsCastellLv2())
	{
		echo  "<a ".$plantilla." href='Plantilla.php'>"._('Plantilles')."</a>
			<a ".$castell." href='Castell.php'>"._('Assaig/Actuació')."</a>
			<a ".$posicions." href='Posicio.php'>"._('Posicions')."</a>
			<a ".$estadistiques." href='Estadistiques.php'>"._('Estadístiques')."</a>";
	}
	if (EsBossLv2())
	{
		echo "<a ".$planificacio." href='Planificacio.php'>"._('Planificació')."</a>";
	}
	if (EsAdmin())
	{
		echo "<a ".$usuaris." href='Usuari.php'>"._('Usuaris')."</a>";
		echo "<a ".$configuracio." href='Configuracio.php'>"._('Configuració')."</a>";
	}

?>
	<div class="topnav-right">
		<a <?php echo $login?> href="Login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a>
		<a href="javascript:void(0);" class="icon" onclick="Resize()">&#9776;</a>
		<a href=<?php echo "?lang=".$altLangCode.""?> class="show"><span class="glyphicon glyphicon-globe"></span><?php echo $altLangName?></a>
	</div>
</div>
<br>

<script>
/* Toggle between adding and removing the "responsive" class to topnav when the user clicks on the icon */
function Resize()
{
    var x = document.getElementById("MainTopnav");
    if (x.className === "topnav")
	{
        x.className += " responsive";
    }
	else
	{
        x.className = "topnav";
    }
}
</script>

<?php

function Contains($url, $valor)
{
	return (strpos($url, $valor) !== false);
}

function ContainsUrl($valor)
{
	return Contains($_SERVER['REQUEST_URI'], $valor);
}

function EsLv1($valor)
{
	return (!empty($_SESSION[$valor]) && ($_SESSION[$valor]>0));
}

function EsLv2($valor)
{
	return (!empty($_SESSION[$valor]) && ($_SESSION[$valor]>1));
}

function EsEventLv1()
{
	return EsLv1("event");
}


function EsEventLv2()
{
	return EsLv2("event");
}

function EventLv2($value)
{
	if (EsEventLv2())
	{
		echo $value;
	}
}

function EventLv2Not($value)
{
	if (!EsEventLv2())
	{
		echo $value;
	}
}

function EsCastellerLv1()
{
	return EsLv1("casteller");
}

function EsCastellerLv2()
{
	return EsLv2("casteller");
}

function EsCastellerLv3()
{
	return EsLv3("casteller");
}

function SiCastellerLv2($value, $alternatiu)
{
	if (EsCastellerLv2())
	{
		return $value;
	}
	else
	{
		return $alternatiu;
	}
}

function CastellerLv2Not($value)
{
	if (!EsCastellerLv2())
	{
		echo $value;
	}
}


function EsCastellLv1()
{
	return EsLv1("castell");
}

function EsCastellLv2()
{
	return EsLv2("castell");
}


function EsBossLv1()
{
	return EsLv1("boss");
}

function EsBossLv2()
{
	return EsLv2("boss");
}


function EsAdmin()
{
	return EsLv2("admin");
}

function Redirecciona()
{
	echo "<meta http-equiv='refresh' content='0; url=Pinyator.php'/>";
}

function EsURLEvent()
{
	return ContainsUrl("event");
}

function EsURLCasteller()
{
	return ContainsUrl("Casteller");
}

function EsURLCastell()
{
	return (ContainsUrl("Plantilles") || ContainsUrl("Castell.") || ContainsUrl("Castell_") || ContainsUrl("Posicio") || ContainsUrl("Estadistiques"));
}

function EsURLBoss()
{
	return (ContainsUrl("Planificacio"));
}


function EsURLAdmin()
{
	return ContainsUrl("Usuari.php") || ContainsUrl("Configuracio.php");
}

?>
