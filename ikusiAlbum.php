<html>
<head>

</head>
<body>
<?php
    require_once 'dataFinder.inc';

    $albumID = $_GET['albumid'];
    
    if(!file_exists('./data/musikantzun.xml')){
        echo 'Ezinezkoa da abestiaren informazioa lortzea';
        die();
    }

    $xmlData = simplexml_load_file('./data/musikantzun.xml');

    $albumData = getAlbumId($xmlData, $albumID);
    
    if($albumData != null){
        $egileData =  $albumData['egilea'];
        $albumData =  $albumData['albuma'];

        $albumIzen = $albumData['izenaAlbum'];

        $albumPortada = 'data/unknown.png';
        if(isset($albumData->portada->path[0])){
            $albumPortada = $albumData->portada->path[0];
        }
        echo "<div>";
        echo "<img src='$albumPortada'/><div><h1>$albumIzen</h1></div>";
        echo "</div>";

    }

?>
</body>
</html>
<?php 
function getAlbumById($xmlData, $albumId){
    foreach($xmlData->children() as $egileElement){

    }
}