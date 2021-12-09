<html>
<head>
    <title>Musikantzun: musika entzun.</title>
    <meta charset="UTF-8"> 
    <link rel="stylesheet" href="css/reproduktore.css" type="text/css"/>
    <link rel="stylesheet" href="css/abesti_lista.css" type="text/css"/>
    <link rel="stylesheet" href="css/musika_igo.css" type="text/css"/>
    <script src="js/jquery.min.js"></script>
    <link rel="shortcut icon" type="image/jpg" href="icons/favicon.png">
    <script src='js/abestiak_ikusi.js'></script>
    <style>
        #showAbestiak_menu{
            color: white;
        }
    </style>

</head>
<body>
    <?php require 'html/nav.html' ?>
    <?php require_once 'dataFinder.inc' ?>
    <input class='abesti' type='button' value="Abesti guztiak" onclick='ikusiAbestiGuztiak()'/>
<div id='maincontent' class="content center" style="display:flex">
    <div class = 'center' id='abestiListaDiv'>  
        <h1>Abestien lista:</h1>
        <?php getAbestienListaHTML();?>
    </div>
    <div class = 'center'>
    <h1>Filtratu abestiak:</h1>
        <form id='filterForm' method='POST' enctype='multipart/form-data'>
            <input id='abestiIzenInput' type='text' name='abestia' placeholder='Abestia'/><br>
            <input id='albumIzenInput' type='text' name='albuma' placeholder='Albuma'/><br>
            <input id='egileIzenInput' type='text' name='egilea' placeholder='Egilea'/><br>
            <input class='abesti' type='button' value='Filtratu' name='filtratu' onClick='filtratuAbestiak()'/>
        </form>
    </div>

</div>


<footer id='playfooter' style='border-top-style:solid;'>
    <?php include 'html/erreproduktore.html';?>
</footer>
</body>

</html>

<?php

function filterAll($xml, $egileIzen = null, $albumIzen = null, $abestiIzen){
    $tableBody = '';
    $abestiKop = 0;
    foreach ($xml-> children() as $egilea){
        if($egileIzen == null || strpos($egilea['izenaEgile'], $egileIzen) !== false){
            foreach ($egilea-> children() as $albuma){
                if($albumIzen == null || strpos($albuma['izenaAlbum'], $albumIzen) !== false){
                    foreach ($albuma -> abestia as $abestia){
                        if($abestiIzen == null || strpos($abestia->izenburua, $abestiIzen) !== false){
                            $tableBody = $tableBody.toTableSong($egilea, $albuma, $abestia);
                            $abestiKop = $abestiKop + 1;  
                        } 
                    }
                }
            }
        }
    }
    return array('tableBody'=>$tableBody,
                'abestiKop' =>$abestiKop);
}

function getAbestienListaHTML(){
    $abestiKop = 0;

    $egilea = null;
    $albuma = null;
    $abestia = null;

    
    isset($_POST['egilea']) && $egilea = $_POST['egilea'];
    isset($_POST['albuma']) && $albuma = $_POST['albuma'];
    isset($_POST['abestia']) && $abestia = $_POST['abestia'];
    

    if(file_exists('./data/musikantzun.xml')){
        $xml = simplexml_load_file('./data/musikantzun.xml');
        $tableBody = '';

        $tableData = filterAll($xml, $egilea, $albuma, $abestia);
        $tableBody = $tableData['tableBody'];
        $abestiKop = $tableData['abestiKop'];
        
    }
    if($abestiKop == 0){
        echo '<h2>Oraindik ez dago abestirik</h2> <br> <a class="abesti" href="formAbestiaGehitu.php">Abesti bat gehitu!</a>';
    }else{
        ?>
            <table id='abestiTaula'class="center">
            <thead><tr>
                <th>    </th>
                <th>Egilea</th>
                <th>Albuma</th>
                <th>Abestia</th></tr>
            </thead>
            <tbody>
            <?php echo ($tableBody); ?>
            </tbody>
            </table> 
            <p>Abesti kopurua: <?php echo $abestiKop?></p>
        <?php    
    }
}

?>