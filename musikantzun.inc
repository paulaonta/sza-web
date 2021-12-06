<?php
$BL_FILE='./data/musikantzun.xml';		// Musika gordeko den fitxategia.
$PORTADA = './data/album_portadak';     //Portadak gordeko den karpeta
$ABESTIA = './data/musika';     //Abestiak gordeko den karpeta
require_once("getAbestia.php");

function luzapen_egokia($fitxategia, $mota){
	$luzapen =  explode('.', $fitxategia);
	$luzapen = strtolower($luzapen[count($luzapen)-1]);
	if ($mota == "audio"){
		if ($luzapen == "mp3" || $luzapen == "ogg" || $luzapen == "wva" ){
			return True;
		}
		else{
			return False;
		}
	}
	else if ($mota == "argazki"){
		if ($luzapen == "jpg" || $luzapen == "jpeg" || $luzapen == "png" ){
			return True;
		}
		else{
			return False;
		}
	}
	return False;
}
// Balioztatu abesti berri bat igotzeko formularioko datuak.
// Errorerik egonez gero errore mezu bat itzultzen du, bestela string hutsa.

function balidatu_berria($izenburua, $egilea, $portada, $abestia)
{
	$mezua = '';
	if($izenburua == '')	// izenburua eremua ez da bete.
		$mezua = $mezua.'<li>Izenburua eremua ez da bete.</li>';
	if ($abestia == '') //abestia ez du sartu
		$mezua = $mezua.'<li>Abestia eremua ez da bete.</li>';
	if(!luzapen_egokia($abestia,'audio'))	// Abestia eremua bete da, baina bere luzapena ez da zuzena.
		$mezua = $mezua.'<li>Abestiaren luzapena ez da zuzena.</li>';
	if($egilea == '')	// egilea eremua ez da bete.
		$mezua = $mezua.'<li>Egilea(k) eremua ez da bete.</li>';
	if($portada != '' && !luzapen_egokia($portada,'argazki'))	// Portada eremua bete da, baina bere luzapena ez da zuzena.
		$mezua = $mezua.'<li>Portadaren argazkiaren luzapena ez da zuzena.</li>';
	return $mezua;
}

// Abestia datu basean gorde. Errorerik ezean true itzultzen du eta false bestela.
function gorde_abestia($izenburua, $egilea, $albuma , $portada, $abestia)
{
	global $BL_FILE;	// Funtzio baten barrutik aldagai global erabiltzeko 'global' erabili behar da.
	global $ABESTIA;
	global $PORTADA;

	if(!file_exists($BL_FILE)){	// Abestiak gordetzeko XML fitxategia ez bada existitzen, sortu abestirik gabeko XML fitxategia.
		$bl=simplexml_load_string('<?xml version="1.0" encoding="UTF-8"?><!DOCTYPE egileak SYSTEM "musikantzun.dtd"><egileak azkenIdAlbuma="0" azkenIdAbestia = "0"></egileak>');
	
	}else{	// Bestela, kargatu XML fitxategia.
		$bl=simplexml_load_file($BL_FILE);
	}
	if($bl === false) // Boolean motakoa eta false bada, orduan:
		return false;
	
	$lagEgilea = bilatuEgilea($bl,$egilea);
	if ($lagEgilea==null){ //egilea ez badago sartuta
		$berria=$bl->addChild('egilea');	// Sortu 'egilea' etiketa.
		$berria['izenaEgile']=$egilea;
	}
	else{ //egilea sartuta dago
		$berria = $lagEgilea;
	}

	$sartuta = FALSE; //aldagai honek esaten digu albuma sartuta dagoenetz
	if ($albuma != ''){//album baten izena sartu badu
		$lagAlbum = bilatuAlbumaOnEgilea($berria,$albuma);
	}
	else{
		$lagAlbum = bilatuAlbumaOnEgilea($berria,$izenburua.'(SINGLE)');
	}
	if($lagAlbum == null){  //albuma ez badago sartuta
		$alb = $berria->addChild('albuma'); 	// Sortu 'egilea' etiketa barruko album etiketa
		$idAlbum = $bl['azkenIdAlbuma']+1;
		$alb['albumaId'] = $idAlbum;
		if ($albuma == ''){ //ez badu albumaren izena sartu
			$alb['izenaAlbum']=$izenburua.'(SINGLE)'; //jarriko zaio abestiaren izenburua albumaren izen moduan eta gehituko diogu SINGLE zehazteko ez dela album baten parte
		}
		else{ //Izena sartu du
			$alb['izenaAlbum']=$albuma;
		}
	}
	else{ //albuma sartuta dago
		$alb = $lagAlbum;
		$sartuta = TRUE;
	}	
	

	if (($portada != '' && !$sartuta) || ($sartuta && $portada != '' && $alb->portada == '')){  //portada sartu badu eta albuma lehen aldiz sartu badu EDO
																			 //portada sartu badu, ez du albuma lehen aldiz sartu eta albuma ez dauka portadarik
		$port = $alb->addChild('portada');
		$port->addChild('path',$alb['albumaId']."_".$portada);

		//gordeko dugu fitxategi batean

		//konprobatuko dugu ea direktoria existitzen den
		if(!file_exists($PORTADA)){ //ez bada existitzen
			mkdir($PORTADA, 0700);//sortuko dugu
		}
		
		$image_path = "$PORTADA/$port->path";
		$imgDataBytes = file_get_contents($_FILES['portada']['tmp_name']); // Irakurri
		file_put_contents($image_path,$imgDataBytes); //gorde gure karpetan
	}


	$lagAbesti = bilatuAbestiaOnEgilea($berria,$izenburua); 
	if($lagAbesti == null){ //egileak abesti hori ez badauka
		$idAbesti = $bl['azkenIdAbestia']+1;
		$abes = $alb->addChild('abestia');
		$abes['abestiaId']=$idAbesti;
		
		$abes->addChild('izenburua', $izenburua) ;
		$abes->addChild('data', date('r')) ;
		$abes->addChild('path',"$idAbesti"."_"."$abestia");
		
		//gordeko dugu fitxategi batean

		//konprobatuko dugu ea direktoria existitzen den
		if(!file_exists($ABESTIA)){ //ez bada existitzen
			mkdir($ABESTIA, 0700);//sortuko dugu
		}

		$image_path = "$ABESTIA/$abes->path";
		$imgDataBytes = file_get_contents($_FILES['abestia']['tmp_name']); // Irakurri
		file_put_contents($image_path,$imgDataBytes); //gorde gure karpetan
	}
	else{
		return False;
	}	
	
	if(!$sartuta) //album berri bat sartu badu
		$bl['azkenIdAlbuma'] = $idAlbum;
	$bl['azkenIdAbestia'] = $idAbesti;

	$domxml = new DOMDocument('1.0');
	$domxml->preserveWhiteSpace = false;
	$domxml->formatOutput = true;	
	$domxml->loadXML($bl->asXML());
	$domxml->save($BL_FILE);	// Gorde aldaketak fitxategian.
	return True;
}

?>
