<!DOCTYPE html>
<html>
	<head>
		<title>Musikantzun</title>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="musika_igo.css" type="text/css">
		<script type="text/javascript" src="animations.js"></script>
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
		<p id="egileak_index" class="kredituak">Paula Ontalvilla, Mikel Laorden, Iñigo Gil</p>
		<img class="infoIcon" src="icons/info.png" alt="info" onmouseenter='showKredituak("egileak_index")' onmouseout="unshowKredituak('egileak_index')">
	</body>
</html>
