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

function getAlbumId($datuakXml, $id){
    foreach($datuakXml->children() as $egileElement){
        foreach ($egileElement-> children() as $albumElement){
            if($albumElement['albumaId'] ==  $id){
                $albumData = array(
                    'egilea' => $egileElement,
                    'albuma' => $albumElement
                );
                return $albumData;
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


function toTableSong($egileElement, $albumElement, $abestiElement ){
    $egileIzen = $egileElement['izenaEgile'];
    $albumIzen = $albumElement['izenaAlbum'];

    $albumId = $albumElement['albumaId'];
    $izenburua = $abestiElement->izenburua;
    $abestiContent = $abestiElement->path;
    $abestiPath = './data/musika/'.$abestiContent;
    $abestiID = $abestiElement['abestiaId'];
    $tableBody = "<tr>
    <td><img class='playIcon' src='./data/playArrow.png' onClick=\"entzunAbestia('$abestiID')\"/></td>
    <td>$egileIzen</td>
    <td><h id='albumIzenTestua' onClick=\"ikusiAlbuma('$albumId')\">$albumIzen</h></td>
    <td>$izenburua</td>
                            
    </tr>"; 
    return $tableBody;
}

?>