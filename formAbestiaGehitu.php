<!DOCTYPE html>
<html>
	<head>
		<title>Musikantzun: musika igo</title>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="css/musika_igo.css" type="text/css">
		<script type="text/javascript" src="js/balidatu.js"></script>
		<script type="text/javascript" src="js/animations.js"></script>
		<style>
			#addAbesti_menu{
				color: white;
			}
		</style>
	</head>
	<body>
		<?php require 'html/nav.html'?>
		<h1 id="title" class="izenburua">Musikantzun</h1>
		<h2 class="formIzenburua">Igo nahi duzun musika</h2>
		<p>Abesti bat igotzeko bete hurrengo formularioa:</p><br/>
		<form action="gehituAbestia.php" method="post" enctype='multipart/form-data'>
			<input type="text" id="izenburua" name="izenburua" class="txt_field" placeholder="Izenburua (*)" required>
			<input type="text" name="egilea" class="txt_field" placeholder="Egilea(k) (*)" required> <br/>
			<input type="text" name="albuma" class="txt_field" placeholder="Albuma"><br/><br/>
			<label for="azala">Azala: </label><input id="azala" type="file" name="portada" accept=".png, .jpg, .jpeg" placeholder="Azala" class="fileHautatzaileak" onmouseenter='enterAzalaAlerta()' onmouseout="outAzalaAlerta()" ><br/>
			<p id ="azalaAlerta">Gogoratu, album baten abestiak igotzean albumeko abesti batekin baino ez duzu azala igo behar. Bakarrik gordeko da igo duzun lehenengo azala!<p><br/>
			<label for="abestia">Abestia (*): </label><input id="abestia" type="file" name="abestia" accept="audio/*" class="fileHautatzaileak"><br/>
			<input type="submit" onclick="return balidatu(this.form);" value="Bidali">
		</form>
		<p id="egileak_berria" class="kredituak">Paula Ontalvilla, Mikel Laorden, Iñigo Gil</p>
		<img class="infoIcon" src="icons/info.png" alt="info" onmouseenter='showKredituak("egileak_berria")' onmouseout="unshowKredituak('egileak_berria')">
	</body>
</html>
