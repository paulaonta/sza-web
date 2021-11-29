<?php
$BL_FILE='musikantzun.xml';		// Iruzkinak gordeko diren fitxategia.

// Balioztatu iruzkin berri bat sortzeko formularioko datuak.
// Gogoratu nahiz eta balioztapen hau bezeroan egin den, zerbitzarian berriro egitea ezinbestekoa dela.
// Errorerik egonez gero errore mezu bat itzultzen du, bestela string hutsa.

function balidatu_berria($izenburua, $egilea, $albuma, $portada, $abestia)
{
	$mezua = '';
	if($izenburua == '')	// izenburua eremua ez da bete.
		$mezua = $mezua.'<li>Izenburua eremua ez da bete.</li>';
	if($eposta != '' && !formatua($eposta))	// E-posta eremua bete da, baina bere formatua ez da zuzena.
		$mezua = $mezua.'<li>Posta helbidearen formatua ez da zuzena.</li>';
	if($egilea == '')	// egilea eremua ez da bete.
		$mezua = $mezua.'<li>Egilea(k) eremua ez da bete.</li>';
	return $mezua;
}

// Abestia datu basean gorde. Errorerik ezean true itzultzen du eta false bestela.
function gorde_abestia($izena, $eposta, $pribatua, $iruzkina)
{
	global $BL_FILE;	// Funtzio baten barrutik aldagai global erabiltzeko 'global' erabili behar da.
	
	if(!file_exists($BL_FILE))	// Iruzkinak gordetzeko XML fitxategia ez bada existitzen, sortu iruzkinik gabeko XML fitxategia.
		$bl=new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><!DOCTYPE bisitak SYSTEM "musikantzun.dtd"><egileak></egileak>');
	else	// Bestela, kargatu XML fitxategia.
		$bl=simplexml_load_file($BL_FILE);
	if(!$bl)
		return false;
	
	$id = "b" . ((int) substr($bl['azkenid'], 1) + 1);	// Kalkulatu iruzkin berriaren identifikadorea.
	$berria=$bl->addChild('bisita');	// Sortu 'bisita' etiketa.
	$berria['id']=$id;
	$berria->addChild('data',date('r'));	// Sortu 'bisita' etiketa barruko etiketak.
	$berria->addChild('izena',$izena);
	$berria->addChild('iruzkina',$iruzkina);
	if($eposta!='')
	{
		$ep=$berria->addChild('eposta',$eposta);
		$ep->addAttribute('erakutsi',$pribatua?'ez':'bai');
	}
	$bl['azkenid']=$id;	// Eguneratu erroko 'azkenid' atributua.
	return $bl->asXML($BL_FILE);	// Gorde aldaketak fitxategian.
}
?>
