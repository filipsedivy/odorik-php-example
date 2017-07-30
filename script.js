(function($){

    // Skrytí stránky
    $('#informations').hide();

    // ID relace
    var sessionID = undefined;

    // Spojovací IVR kód
    var ivrCode = undefined;

    // Vytvoření spojení
    $.getJSON('ajax.php', { action: 'createSession' }, function(data){
        sessionID = data.sessionId;
    });

    // Získání klíče
    $.getJSON('ajax.php', { action: 'ivrCode', sessionId: sessionID }, function(data){
        ivrCode = data.ivrCode;
        $('#ivrCode').text(ivrCode);
    });


    // Kontrola IVR spojení
    var ivrCheck = setInterval(function(){
        $.getJSON('ajax.php', { action: 'ivrCheck', ivrCode: ivrCode }, function(data){
            if( data.status !== 'error' )
            {

                // Vypsání dat
                $('#fromNumber').text(data.from);

                // Prohození oken
                $('#informations').show();
                $('#startPage').hide();

                // Zrušení automatické obnovy
                clearInterval(ivrCheck);
            }
        });

    }, 1000);
}(jQuery));