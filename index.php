<!DOCTYPE html>
<html>
	<head>
		<title>Musikantzun</title>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="css/musika_igo.css" type="text/css">
		<link rel="stylesheet" href="css/index.css" type="text/css">
		<script type="text/javascript" src="js/animations.js"></script>
		<style>
			#index_menu{
				color: white;
			}
		</style>
	</head>
	<body>
		<?php require 'html/nav.html'?>
		<h1 class="izenburua">Musikantzun</h1>
		<p class="formIzenburua">Hurrengo ekintza hauek egin ditzakezu:</p>
	    <a href="formAbestiaGehitu.php" class="center_menu_item" id="addAbesti_center"><li><img class = "icon" src="icons/upload.png" height="50px">Musika igo</li></a>
        <a href="ikusiMusika.php" class="center_menu_item" id='showAbestiak_center'><li><img class = "icon" src="icons/listen.png" height="50px">Musika entzun</li></a>
		<p id="egileak_index" class="kredituak">Paula Ontalvilla, Mikel Laorden, Iñigo Gil</p>
		<img class="infoIcon" src="icons/info.png" alt="info" onmouseenter='showKredituak("egileak_index")'
		onmouseout="unshowKredituak('egileak_index')">
	</body>
</html>
