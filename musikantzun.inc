<?php
$BL_FILE='./data/musikantzun.xml';		// Musika gordeko den fitxategia.

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
	
	if(!file_exists($BL_FILE))	// Abestiak gordetzeko XML fitxategia ez bada existitzen, sortu abestirik gabeko XML fitxategia.
		$bl=new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><!DOCTYPE egileak SYSTEM "musikantzun.dtd"><egileak></egileak>');
	else	// Bestela, kargatu XML fitxategia.
		$bl=simplexml_load_file($BL_FILE);
	if(!$bl)
		return false;
	
	$berria=$bl->addChild('egilea');	// Sortu 'egilea' etiketa.
	$berria['izenaEgile']=$egilea;
	
	$alb = $berria->addChild('albuma'); 	// Sortu 'egilea' etiketa barruko etiketak.
	
	if ($albuma == ''){ //ez badu albumaren izena sartu
		$alb['izenaAlbum']=$izenburua; //jarriko zaio abestiaren izenburua albumaren izen moduan
	}
	else{ //Izena sartu du
		$alb['izenaAlbum']=$albuma;
	}

	if ($portada != ''){  //portada sartu badu
		$alb->addChild('portada',$portada);
	}
	
	$abes = $alb->addChild('abestia');
	$abes['content']=$abestia;
	
	$abes->addChild('izenburua', $izenburua) ;
	$abes->addChild('data', date('r')) ;
	
	$domxml = new DOMDocument('1.0');
	$domxml->preserveWhiteSpace = false;
	$domxml->formatOutput = true;
	/* @var $xml SimpleXMLElement */
	$domxml->loadXML($xml->asXML($BL_FILE));
	$domxml->save('../xml/Questions.xml');
	return True;
}

?>
