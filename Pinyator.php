<html lang="en">
<head>
  <title>Pinyator</title>
<?php include "$_SERVER[DOCUMENT_ROOT]/pinyator/utils/Head.php";?>
</head>
<?php include "$_SERVER[DOCUMENT_ROOT]/pinyator/utils/Style.php";?>
<body>
<?php $menu=0; include "$_SERVER[DOCUMENT_ROOT]/pinyator/utils/Menu.php";?>

<h1>Pinyator</h1>
<?php echo _("Aquesta web esta dissenyada per portar un control de les pinyes amb la seva assistència."); ?>

<h2>Castellers</h2>
<pre><?php echo _("Aquí podem trobar el llistat de castellers.\n"
    ."Pel tema assistència, cada casteller té un codi únic del qual es crea un link només per ell i on podrà consultar els esdeveniments de la colla.\n"
    ."En aquest apartat podem entrar dades d'un casteller, nom, malnom, altura, posició, si pot portar peu o si està lesionat.\n"
    ."Per l'assistència hi ha l'opció d'assignar-li un responsable per poder-lo apuntar a pinyes :)\n"
    ."També podrem veure un petit informe de les seves estadístiques."); ?>
</pre>

<h2><?php echo _("Esdeveniments"); ?></h2>
<pre><?php echo _("On es crean els esdeveniment per tal que la gent s'apunti.\n"
    ."Es poden crear esdeveniments principals i secundaris, la idea es:\n"
    ."Esdeveniment principal:\n"
    ."- Actuació Mataro\n"
    ."Esdeveniment secundari:\n"
    ."- Bus anada\n"
    ."- Bus tornada"); ?>

<?php echo _("També hi ha l'opció de veure els llistats de gent apuntada i modificar-ho."); ?>
</pre>

<h2><?php echo _('Plantilles'); ?></h2>
<pre>
<?php echo _("Aquí es crean les plantilles que després es s'utilitzaràn pels castells."); ?>
</pre>


<h2>Castells</h2>
<pre>
<?php echo _("On es crean els castells relacionats als esdeveniments per tal de tenir la gent apuntada.\n"
    ."Es poden crear castells des de plantilles o des d'altres castells lligats als esdeveniments.\n"
    ."Tot castell ha d'estar vinculat a un esdeveniment."); ?>
</pre>


</body>
</html>
