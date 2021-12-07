<html>
<head>
<link rel="stylesheet" href="musika_igo.css" type="text/css">
</head>
<body>
<?php
    require_once 'dataFinder.inc';
    $config = require ('config.php');

    if(isset($_GET['albumid'])){
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
                $albumPortada = $config['album_path'].$albumPortada;
            }
            echo "<div id='maincontent' style='width: 100%'>";
            echo "<table style='width: 100%; display: table;'><tbody>";
            echo "<tr style='display: table-row; height:fixed'>";
    
            echo "  <td style='display: table-cell; padding:4vh; width:1%'><img src='$albumPortada' style='width:10vh;background-color:white;border-radius:10%'/></td>
                    <td style='display: table-cell'><h3>ALBUM</h3><h1>$albumIzen</h1></td>";
            echo "</tr></tbody></table><br><br> 
            <h3>Abestiak:</h3>
            <table style='margin-left:auto; margin-right:auto;'>
            <tbody>";
    
            foreach($albumData->abestia as $abestia){
                echo toTableSong($egileData, $albumData, $abestia);
            }
    
            echo "</tbody></table></div>";
    
        }
    }

?>
</body>
</html>