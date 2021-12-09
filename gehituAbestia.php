<?php
	require_once("musikantzun.inc");	
	// Jaso formularioko balioak eta testuei hasierako eta amaierako hutsuneak kendu (trim).
	$izenburua=($_POST['izenburua']);
	$egilea=($_POST['egilea']);
	$albuma=($_POST['albuma']);
	$portada=($_FILES['portada']['name']); //izena luzapenarekin
	$abestia=($_FILES['abestia']['name']); //izena luzapenarekin
	
	//Balidatu formularioko datuak.
	$errorea = balidatu_berria($izenburua, $egilea, $portada, $abestia);
	if($errorea == ''){
		if(!gorde_abestia($izenburua, $egilea, $albuma , $portada, $abestia))	// Gorde abestia datu basean (XML fitxategia).
			$errorea = 'Ezin izan da abestia datu basean gorde.</br>';
	}
			
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="css/musika_igo.css" type="text/css">
		<link rel="shortcut icon" type="image/jpg" href="icons/favicon.png">
		<script type="text/javascript" src="js/animations.js"></script>
		<?php
			if($errorea=='')
				echo '<title>Zure abestia inolako arazorik gabe igo da.</title>';
			else
				echo '<title>Errorea abesti berria gehitzerakoan</title>';
		?>
		<meta charset="UTF-8">
	</head>
	<body>
	<body>
		<?php require 'html/nav.html'?>
		<h1 class="izenburua">Musikantzun</h1>
			<?php
			if($errorea != '')
			{
				echo('<img src="icons/txarto.png" alt="error">');
				echo('<h1>Errore bat gertatu da abestia igotzean.</h1>');
				echo("<ul>$errorea</ul>");
				echo('<form class="transparentForm" action="formAbestiaGehitu.php">
                          <input id="atzeraJoan" type="submit" value="Atzera joan" />
                      </form>');
			}
			else
			{
				echo('<img src="icons/ongi.png" alt="ondo">');
				echo('<h1>Eskerrik asko abestia igotzeagatik.</h1>');
				echo('<form class="transparentForm" action="formAbestiaGehitu.php">
                                                <input type="submit" value="Atzera joan" />
                                            </form>');
			}
			?>
		<p id="egileak_index" class="kredituak">Paula Ontalvilla, Mikel Laorden, Iñigo Gil</p>
		<img class="infoIcon" src="icons/info.png" alt="info" onmouseenter='showKredituak("egileak_index")' onmouseout="unshowKredituak('egileak_index')">
	</body>
</html>
