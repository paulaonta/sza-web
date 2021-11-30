<?php
	require_once("musikantzun.inc");	
	// Jaso formularioko balioak eta testuei hasierako eta amaierako hutsuneak kendu (trim).
	$izenburua=trim($_POST['izenburua']);
	$egilea=trim($_POST['egilea']);
	$albuma=isset($_POST['albuma']);
	$portada=trim($_POST['portada']);
	$abestia=trim($_POST['abestia']);

	//Balidatu formularioko datuak.
	$errorea = balidatu_berria($izenburua, $egilea, $portada, $abestia);
	if($errorea == '')
		if(!gorde_iruzkina($izenburua, $egilea, $albuma , $portada, $abestia))	// Gorde iruzkina datu basean (XML fitxategia).
			$errorea = '<li>Ezin izan da iruzkina datu basean gorde.</li>';
?>
<!DOCTYPE html>
<html>
	<head>
	<?php
		if($errorea=='')
			echo '<title>Eskerrik asko zure iruzkina uzteagatik</title>';
		else
			echo '<title>Errorea iruzkin berria jasotzean</title>';
	?>
		<meta charset="UTF-8">
	</head>
	<body>
	<?php
		if($errorea != '')
		{
			echo('<h1>Errore bat gertatu da iruzkina gordetzean.</h1>');
			echo("<ul>$errorea</ul>");
		}
		else
		{
			echo('<h1>Eskerrik asko zure iruzkina uzteagatik.</h1>');
		}
	?>
		<a href="index.html">Itzuli menu nagusira</a>.
	</body>
</html>
