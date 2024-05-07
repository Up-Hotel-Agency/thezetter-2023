// set the global variables here for JSLint
/*global AOS, jQuery */
"use strict";

function initializeInsta() {
    $('.insta-images').each(function(){
        var userFeed = new Instafeed({
            get: 'user',
            target: "instafeed",
            limit:4,
            resolution: 'low_resolution',
            accessToken: 'IGQVJVa0dBaGFFc2hUMFotRFZAKMDJWQkI4RTRPWHRITGhoNFVkUV9xVzJxUzJBeGo5WFhTN1ZAKRVFYRXJNRVdBaW5EOXZAfUnJkOXZAySWVQRjU4VVBybHRxVHJmMXY2OWs1cDRlZAU1hSTlCUkhGQS1uagZDZD'
        });
        userFeed.run();

        setTimeout(function() {
            $('.instagram-image').removeClass('load');
        }, 1000);

    });
}


// only run this once per page
var instagramInit = true;
var instagramScriptLoaded = false;
function instagram(){
    // function to load in instagram
    function loadinstagramScript( url, callback ) {
        var script = document.createElement( "script" )
        script.type = "text/javascript";
        if(script.readyState) {  // only required for IE <9
            script.onreadystatechange = function() {
                if ( script.readyState === "loaded" || script.readyState === "complete" ) {
                    script.onreadystatechange = null;
                    callback();
                }
            };
        } else {  //Others
            script.onload = function() {
                callback();
            };
        }
      
        script.src = url;
        document.getElementsByTagName( "head" )[0].appendChild( script );
    }
    // if not already initialised
    if(instagramInit) {
        // if no, load the api script and run the function
        loadinstagramScript('/wp-content/themes/thezetter-2023/assets/js/instafeed.js', function() {
            instagramScriptLoaded = true;
            // run the map function
            initializeInsta();
        });
        // it's now initialised
        instagramInit = false;
    }
}

function IEinstagram(){
    instagram();
}

//If the script is loaded within the editor run the function
if( window.acf ) {
    window.acf.addAction( 'render_block_preview', instagram() );
}