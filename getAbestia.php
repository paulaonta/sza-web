<?php
$config = require ("./config.php");
if(isset($_GET['id']) || isset($_GET['egilea']) && isset($_GET['albuma']) && isset($_GET['abestia'])){

    if(!file_exists('./data/musikantzun.xml')){
        echo 'Ezinezkoa da abestiaren informazioa lortzea';
        die();
    }
    $xmlData = simplexml_load_file('./data/musikantzun.xml');
    //echo '<pre>';print_r();echo '</pre>';
    $abestiData = null;
    if(isset($_GET['egilea']) && isset($_GET['albuma']) && isset($_GET['abestia'])){
        $egilea = $_GET['egilea'];
        $albuma = $_GET['albuma'];
        $abestia = $_GET['abestia'];
        $abestiData = getAbestia($xmlData, $egilea, $albuma, $abestia);
    }else if(isset($_GET['id'])){
        $id = $_GET['id'];
        $abestiData = getAbestiaId($xmlData, $id);
    }

    if($abestiData != null){
        $egilea = $abestiData['egilea'];
        $albuma = $abestiData['albuma'];
        $abestia = $abestiData['abestia'];

        $returnXML = new SimpleXMLElement(
            '<?xml version="1.0" encoding="UTF-8"?>
            <!DOCTYPE abestia SYSTEM "dtd/abestiDeskribapena.dtd">
            <abestia></abestia>');
        $returnXML->addChild('izenburua', $abestia->izenburua);
        $returnXML->addChild('egilea')->addAttribute('izenaEgile', $egilea['izenaEgile']);
        $albumXmlElement = $returnXML->addChild('albuma');
        $albumXmlElement->addAttribute('izenaAlbum', $albuma['izenaAlbum']);
        if(isset($albuma->portada) && isset($albuma->portada->path)){
            $albumXmlElement->addChild('portada', $config['album_path'].$albuma->portada->path[0]);
        }
        $returnXML->addChild('path',$config['audio_path'].$abestia->path);
   
        print_r($returnXML->asXML());
        
    }else{
        echo "error";
    }
}

?>

<?php

    function getAbestiaId($datuakXml, $id){
        foreach($datuakXml->children() as $egileElement){
            foreach ($egileElement-> children() as $albumElement){
                foreach ($albumElement-> abestia as $abestiElement){
                    if($abestiElement['abestiaId'] == $id){
                        $abestiData = array(
                            'egilea' => $egileElement,
                            'albuma' => $albumElement,
                            'abestia' => $abestiElement
                        );
                        return $abestiData;
                    }
                }
            }
        }
        return null;
    }

    function getAbestia($datuakXml, $egile, $album, $abesti){
        $abestiaLortua = false;        
        $egileElement = bilatuEgilea($datuakXml, $egile);
        if($egileElement != null){
            $albumElement = bilatuAlbumaOnEgilea($egileElement, $album);
            if($albumElement != null){
                $abestiElement = bilatuAbestiaOnAlbum($albumElement, $abesti);
                if($abestiElement != null){
                    $abestiaLortua = true;     
                }
            }
        }

        if($abestiaLortua){
            $abestiData = array(
                'egilea' => $egileElement,
                'albuma' => $albumElement,
                'abestia' => $abestiElement
            );
            return $abestiData;
        }else{
            return null;
        }
    }

    function bilatuEgilea($egileakElement, $egileaIzen){
        foreach($egileakElement->children() as $egileaElement){
            if($egileaElement['izenaEgile'] == $egileaIzen){
                return $egileaElement;
            }
        }
        return null;
    }

    function bilatuAlbumaOnEgilea($egileElement, $albumIzen){
        foreach ($egileElement-> children() as $albumElement){
            if($albumElement['izenaAlbum'] == $albumIzen){
                return $albumElement;
            }
        }
        return null;
    }

    function bilatuAbestiaOnAlbum($albumElement, $abestiIzen){
        foreach ($albumElement -> abestia as $abestiElement){
            if($abestiElement->izenburua == $abestiIzen){
                return $abestiElement;
            }
        }
        return null;         
    }

    function bilatuAbestiaOnEgilea($egileElement, $abestiIzen){
        foreach ($egileElement-> children() as $albumElement){
            foreach ($albumElement-> abestia as $abestiElement){
                if($abestiElement->izenburua == $abestiIzen){
                    return $abestiElement;
                }
            }
        }
        return null;
    }
?>