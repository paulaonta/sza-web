$(document).ready(function(){
    $errep = $(document).find('#erreproduktorea');
    
    $errep.on('canplay', function(){
        $('.abestiInfo').css('visibility','visible');
        $('#playerStatus').hide();
    });
    $('.abestiInfo').css('visibility','hidden');
    eguneratuTamainaTaulaHeader();
});

function entzunAbestia(id){
    $.ajax({
        url: 'getAbestia.php',
        type: 'GET',
        data: { 'id':id},
        success: function(data){
            var $err = $(document).find('#erreproduktorea');
            $err.find('source').remove(); //Borratu aurreko abestien path-ak
            $(data).find('path').each(function(){ //lortu Uneko abestiaren path-ak
                var src = document.createElement('source');
                src.setAttribute('src', $(this).text());
                $err.prepend(src);
            });

            //Egilearen izena:
            egileIzen = $(data).find('egilea').attr('izenaEgile');
            if(egileIzen == ''){
                egileIzen = 'Ez-Ezaguna';
            }
            $(document).find('#egileIzen').text(egileIzen);

            //Abestiaren izena:
            abestiIzen = $(data).find('izenburua').text();
            if(abestiIzen == ''){
                abestiIzen = 'Ez-Ezaguna';
            }
            $(document).find('#abestiIzen').text(abestiIzen);
            
            //Albumaren izena: Gorde atributu bezala abestiaren izenean
            albumId = $(data).find('albuma').attr('albumaId');
            $(document).find('#abestiIzen').attr('albumaId', albumId);
            $(document).find('#abestiIzen').click(ikusiAlbuma);
            //Album-aren portada lortu
            $portadaElem = $(data).find('portada');
            portadaPath = './data/unknown.png';
            if($portadaElem.length >=1){
                portadaPath = $portadaElem.text();
            }
            $(document).find('#albumArgazki').attr('src', portadaPath);
            
            //Erreproduktorea:
            if($err.find('source').length == 0){
                $('.abestiInfo').css('visibility','visible');
                $playerStatus = $('#playerStatus');
                $playerStatus.text('Ezin da abestia erreproduzitu');
                $playerStatus.css('color', 'red');
                $playerStatus.show();
            }
            


            $err[0].load();

        }

    });
}

function ikusiAbestiGuztiak(){
    $.ajax({
        url: 'ikusiMusika.php',
        type: 'GET',
        success: function(data){
            $(document).find('#maincontent').html(
               $(data).filter('#maincontent').html()
            );
            eguneratuTamainaTaulaHeader();
        }
    });
}

function ikusiAlbuma(){
    
}

function ikusiAlbuma(id){
    idAlbum = id;
    if(typeof id === 'undefined'){
        idAlbum = this.getAttribute("albumaid");
    }
    $.ajax({
        url: 'ikusiAlbum.php',
        type: 'GET',
        data: {'albumid':idAlbum},
        success: function(data){
            $(document).find('#maincontent').html(
                data
            );
        }
    });
}

function filtratuAbestiak(){
    formData = {};

    abestiIzen = $(document).find('input#abestiIzenInput').val();
    if(abestiIzen != ''){
        formData.abestia = abestiIzen;
    }
    albumIzen = $(document).find('input#albumIzenInput').val();
    if(albumIzen != ''){
        formData.albuma = albumIzen;
    }
    egileIzen = $(document).find('input#egileIzenInput').val();
    if(egileIzen != ''){
        formData.egilea = egileIzen;
    }
    
    $.ajax({
        url: 'ikusiMusika.php',
        type: 'POST',
        data: formData,
        success: function(data){
            $(document).find('#abestiListaDiv').html(
                $(data).find('#abestiListaDiv').html()
            );
            eguneratuTamainaTaulaHeader();
        }
    });
    
}

function eguneratuTamainaTaulaHeader(){
    // Change the selector if needed
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
    });
}
