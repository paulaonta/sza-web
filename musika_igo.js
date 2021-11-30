function balidatu(f)
{
	// Formularioko balioak irakurri
	var izenburua = f.izenburua.value;
	var egilea = f.egilea.value;
	//Albuma balioa ez da irakurri behar ez delako beharrezkoa eta ez du inolako murriztapenik
	var portadaPath = f.portada.value;
	var abestiaPath = f.abestia.value;
	
	// Ziurtatu beteta egon behar diren eremuak beteta daudela.
	var errorea = "";
	if(izenburua=="")
		errorea += "\tIzenburu eremua bete behar duzu.\n";
	if(egilea=="")
		errorea += "\tEgilea(k) eremua bete behar duzu.\n";
	
	//Ziurtatu sartu diren file motatako fitxategiak formatu egokia izatea
    var allowedExtensionsA = /(.jpg|.jpeg|.png)$/i;
    if(portadaPath != '' && !allowedExtensionsA.exec(portadaPath)){
        errorea += "\tMesedez sartu .jpg, .jpeg edo .png luzapeneko argazki bat.\n";
    }

	var allowedExtensionsB = /(.mp3|.ogg|.wva)$/i;
	if (abestiaPath == '' ){
		errorea += "\Abesti eremua bete behar duzu.\n";
	}
    else if( !allowedExtensionsB.exec(abestiaPath)){
        errorea += "\tMesedez sartu .mp3, .ogg edo .wva luzapeneko abesti bat.\n";
    }

	// Errorerik badago, mezua erakutsi.
	if(errorea != "")
	{
		alert("Formularioa ez duzu ondo bete:\n" + errorea);
		return false;
	}
	else{
		return true;
	}
}


