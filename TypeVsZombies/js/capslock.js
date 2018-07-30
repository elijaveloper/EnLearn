var gameLowerCaseHackEnabled = true;

$(document).keypress(function(e) {
    if(!gameLowerCaseHackEnabled){
    	var s = String.fromCharCode( e.which );
        if ( s.toUpperCase() === s && s.toLowerCase() !== s && !e.shiftKey ) {
            $("#modal_caps").show(500);
        }
    }
});

$(document).keyup(function(e){
    if(!gameLowerCaseHackEnabled){
        if(e.keyCode == 20){
            $("#modal_caps").hide(500);
        }
    }
});