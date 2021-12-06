<html>
<head>
    <title>Musikantzun: musika entzun.</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="musika_igo.css" type="text/css"/>   
    <link rel="stylesheet" href="reproduktore.css" type="text/css"/>
    <link rel="stylesheet" href="abesti_lista.css" type="text/css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src='abestiak_ikusi.js'></script>
    <style>
        #addAbesti_menu{
            color: white;
        }
    </style>

</head>
<body>
    <?php require 'html/nav.html' ?>
<div class="content">
    <h1>Abestien lista:</h1>
<table id='abestiTaula'class="center">
    <thead><tr>
        <td>    </td>
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
                        <td><img class='playIcon' src='./data/playArrow.png' onClick=\"entzunAbestia('$egileIzen','$albumIzen','$izenburua')\"/></td>
                        <td>$egileIzen</td>
                        <td>$albumIzen</td>
                        <td>$izenburua</td>
                                             
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
<script>// Change the selector if needed
var $table = $('#abestiTaula'),
    $bodyCells = $table.find('tbody tr:first').children(),
    colWidth;

// Get the tbody columns width array
colWidth = $bodyCells.map(function() {
    return $(this).width();
}).get();

// Set the width of thead columns
$table.find('thead tr').children().each(function(i, v) {
    $(v).width(colWidth[i]);
});</script>
<footer id='playfooter' style='border-top-style:solid;'>
    <?php include 'html/erreproduktore.html';?>
</footer>
</body>

</html>

<?php
    function bueltatuErrenkada($egilea, $albuma, $izenburua){

    }
?>