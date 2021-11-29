function balidatu(f)
{
	// Formularioko balioak irakurri
	var izenburua = f.izenburua.value;
	var egilea = f.egilea.value;
	var albuma = f.albuma.value;
	var portada = f.portada.value;
	var abestia = f.abestia.value;
	
	// Ziurtatu beteta egon behar diren eremuak beteta daudela.
	var errorea = "";
	if(izenburua=="")
		errorea += "\tIzenburu eremua bete behar duzu.\n";
	if(egilea=="")
		errorea += "\tEgilea(k) eremua bete behar duzu.\n";
	
	//COMPROBAR QUE HA METIDO LA IMAGEN Y QUE ES UNA IMAGEN?
	//CON EL AUDIO COMO HACEMOS???
	

	// Errorerik badago, mezua erakutsi.
	if(errorea != "")
	{
		alert("Formularioa ez duzu ondo bete:\n" + errorea);
		return false;
	}
	else
		return true;
}


