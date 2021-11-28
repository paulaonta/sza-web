<?php
	require_once("bisita_liburua.inc");
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Bisita liburua: iruzkinak.</title>
		<meta charset=UTF-8">
		<link rel="stylesheet" href="bisita_liburua.css" type="text/css">
	</head>
	<body>
		<h1>Bisita liburua</h1>
		<?php
			if(!file_exists($BL_FILE))
			{
				echo('<p>Bisita liburua hutsik dago. Iruzkin bat idazten lehenengoa izan nahi baduzu klikatu <a href="berria.html">hemen</a>.</p>');
			}
			elseif(!($bl=simplexml_load_file($BL_FILE)))
			{
				echo('<p>Errore bat gertatu datu bisita liburua irakurtzean. Barkatu eragozpenak</p>');
			}
			else
			{
			?>
			<p>Hona hemen eskatutako iruzkin zerrenda. Menu nagusira itzultzeko sakatu <a href="index.html">hemen</a>.</p>
			<?php
				$kop=0;
				foreach($bl->bisita as $bisita)
				{
					// Iruzkin bat pantailaratzeko 2 baldintza hauetako bat bete behar
					// da (lehenengoa betetzen bada, bigarrena ez da ebaluatzen):
					//   · 'erab' eremua ez da bidali (iruzkin zerrenda osoa eskatu da).
					//   · 'erab' eremuako balioa eta iruzkinari dagokion izena berdinak
					//      dira (minuskulak eta maiuskulak kontuan ez hartzeko bi
					//      balioak minuskulara pasatzen dira).
					if(!isset($_POST['erab']) || 
					   (strtolower($_POST['erab']) == strtolower($bisita->izena)))
					{
						$kop++;
						echo('<div class="iruzkina">');
						echo('<div class="ir_goiburua">');
						echo('<span class="data">'.$bisita->data.'</span>');
						echo('<span class="izena">'.$bisita->izena.'</span>');
						if($bisita->eposta && $bisita->eposta['erakutsi']=="bai")
							echo('<span class="eposta">&lt;'.
								$bisita->eposta.'&gt;</span>');
						echo('</div>');
						echo('<div class="ir_gorputza">');
						echo($bisita->iruzkina);
						echo('</div>');
						echo('</div>');
					}
				}
				// Erakutsi mezu bat ez bada iruzkinik aurkitu.
				if($kop==0)
					echo('Ez da aurkitu '.$_POST['erab'].' izeneko erabiltzailerik.');
			}
		?>
	</body>
</html>
