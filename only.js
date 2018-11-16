var video = document.getElementById('vid1');
var canvas = document.getElementById('canvas');
var context = canvas.getContext('2d');

//funtion to draw an image on the canvas once picture is taken
function snap() {
    var but = document.getElementById('but');
    but.setAttribute('type', 'submit');
    canvas.width = video.clientWidth;
    canvas.height = video.clientHeight;
    context.drawImage( video, 0, 0 );
}

//function that enable a draws a sticker onto the canvas
function draw(x) {
    var image = document.getElementById(x);
    context.drawImage(image, 0, 0, 70, 70);
}

//function creates the image
function finalImage() {
    var element = document.getElementById( 'picture' );
    var img = canvas.toDataURL( 'image/jpeg' );
    element.setAttribute('value', img);
}