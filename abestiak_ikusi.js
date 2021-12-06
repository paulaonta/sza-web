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
                console.log(this);
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
            albumIzen = $(data).find('albuma').attr('izenaAlbuma');
            $(document).find('#abestiIzen').attr('albumId', albumIzen);

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


            //$err[0].play();
        }

    });
}
