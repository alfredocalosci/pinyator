<?php
	$lang_cookie_name = 'langCookie';
	if (isset($_GET['lang'])) {
		$lang_value = $_GET['lang'];
		setcookie($lang_cookie_name, $lang_value, time() + (86400 * 320), "/"); // 86400 = 1 day
		$languageCode = $lang_value;
	} else {
		$languageCode = 'es';
		if (isset($_COOKIE[$lang_cookie_name]))
		{
			$languageCode = $_COOKIE[$lang_cookie_name];
		}
	}
	if ($languageCode == 'es') {
		// Configurar idioma
		putenv('LC_ALL=es_ES');
		setlocale(LC_ALL, 'es_ES.UTF-8');
		// Especifica la ubicación de la tabla de traducciones
		bindtextdomain("pinyator_es", "./locale");
		// Seleccionar dominio
		textdomain("pinyator_es");
	}
	$languagesList = array(
		'es' => 'Español',
		'ca' => 'Català'
	);
	if ($languageCode == 'es') {
		$altLangCode = 'ca';
	} else {
		$altLangCode = 'es';
	}
	$altLangName = $languagesList[$altLangCode];

 ?>
