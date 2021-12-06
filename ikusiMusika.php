<html>
<head>
    <title>Musikantzun: musika entzun.</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="musika_igo.css" type="text/css">   
    <style>
body {
    margin: 0; /* If not already reset */
}

footer{
  position: fixed;
  bottom: 0;
  padding-bottom:30px;
  width: 100%;
}

    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src='abestiak_ikusi.js'></script>

</head>
<body>
<div class="content">
<table id='abestiTaula'>
    <thead><tr>
        <td>Egilea</td>
        <td>Albuma</td>
        <td>Abestia</td></tr>
    </thead>
    <tbody>
<?php
    if(file_exists('./data/musikantzun.xml')){
        $xml = simplexml_load_file('./data/musikantzun.xml');

        foreach ($xml-> children() as $egilea){
            foreach ($egilea-> children() as $albuma){
                foreach ($albuma -> children() as $albumElementu){
                    if($albumElementu -> getName() == 'abestia'){
                        $egileIzen = $egilea['izenaEgile'];
                        $albumIzen = $albuma['izenaAlbum'];

                        $abestia = $albumElementu;
                        $izenburua = $abestia->izenburua;
                        $abestiContent = $abestia->path;
                        $abestiPath = './data/musika/'.$abestiContent;
                        echo "<tr>

                        <td>$egileIzen</td>
                        <td>$albumIzen</td>
                        <td>$izenburua</td>
                        <td><input type='button' value='Entzun' onClick=\"entzunAbestia('$egileIzen','$albumIzen','$izenburua')\"></button></td>                     
                        </tr>";       
                    }
                }
            }
        }
    }
?>
</tbody>
</table> 
</div>
<footer style='border-top-style:solid;'>
<div id='playBar'>
    <table style='border-top-style:solid; width: 100%;'>
    <tbody>
        <tr>
            <td id="albumArgazkiTd" class='abestiInfo'>
                <img id='albumArgazki' src='./data/album_portadak/violin.jpeg' height=100 width=100/></td>
            <td id="abestiInfo" class='abestiInfo'>
                <a id="abestiIzen">
                   
                </a><br>
                <a id="egileIzen">
                    
                </a>
                </td>
            <td>
                <audio id='erreproduktorea' controls autoplay>
                Your browser does not support the audio element.
                </audio><br>
                <p id='playerStatus' visibility='none'></p>
            
            </td>
        </tr>
    </tbody>
    </table>
</div>
</footer>
</body>

</html>

<?php
    function bueltatuErrenkada($egilea, $albuma, $izenburua){

    }
?>