<?php

if(isset($_GET['egilea']) && isset($_GET['albuma']) && isset($_GET['abestia'])){

    $egilea = $_GET['egilea'];
    $albuma = $_GET['albuma'];
    $abestia = $_GET['abestia'];

    if(!file_exists('./data/musikantzun.xml')){
        echo 'Ezinezkoa da abestiaren informazioa lortzea';
        die();
    }
    $xmlData = simplexml_load_file('./data/musikantzun.xml');
    
    echo '<pre>';print_r(getAbestia($xmlData, $egilea, $albuma, $abestia));echo '</pre>';
}

?>

<?php
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
                'abesti' => $abestiElement
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