$(document).ready(function(){
    $errep = $(document).find('#erreproduktorea');
    
    $errep.on('canplay', function(){
        $('.abestiInfo').css('visibility','visible');
        $('#playerStatus').hide();
    });
    $('.abestiInfo').css('visibility','hidden');
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
function ikusiAlbuma(){
    idAlbum = this.albumId;
    $.ajax({
        url: 'ikusiAlbuma.php',
        type: 'GET',
        success: function(data){
            albumid

        }
    });
}

function filtratuAbestiak(data){
    formData = document.getElementById('filterForm');
    console.log(new FormData(data));
    console.log(formData);  
    $.ajax({
        url: 'ikusiMusika.php',
        type: 'POST',
        data: formData,
        success: function(data){
            $(document).find('#abestiListaDiv').html(
                $(data).find('#abestiListaDiv').html()
            );
            console.log(data);
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