let constraintObj = {
    audio : false,
    video : {
        facingMode: 'user',
       // width: { min: 640, ideal: 1280, max: 1920 },
        //height: { min: 480, ideal: 720, max: 1080 } 
    }
};

//handle older browsers that might implement getUserMedia differently
if ( navigator.mediaDevices === undefined ) {
    navigator.mediaDevices = {};
    navigator.mediaDevices.getUserMedia = function( constraintObj ) {
        navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia 
        || navigator.mozGetUserMedia || navigator.oGetUserMedia || navigator.msGetUserMedia;
        if ( !getUserMedia ) {
            return Promise.reject( new Error( 'getUserMedia is not implemented in this browser' ) );
        }
        return new Promise( function( resolve, reject ) {
            getUserMedia.call( navigator, constraintObj, resolve, reject );
        } );
    }
} else {
    navigator.mediaDevices.enumerateDevices();
}

navigator.mediaDevices.getUserMedia( constraintObj ).then( function( mediaStreamObj ) {
 //connecting the meadia stream to the video element
 var video = document.querySelector( 'video' );
 if ( 'srcObject' in video ) {
     //newer versions
     video.srcObject = mediaStreamObj;
 } else {
     //old versions
     video.src = window.URL.createObjectURL( mediaStreamObj );
 }

//auto show in the video element what is being shown in the video stream
 video.onloadedmetadata = function ( ev ) {
     video.play();
 };
 
} ).catch( function( err ) {
    console.log( err.name, err.message );
} );