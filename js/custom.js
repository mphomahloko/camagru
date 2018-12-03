var canvas = document.getElementById('canvas');
var ctx = canvas.getContext('2d');
//function that enable a draws a sticker onto the canvas
function draw(x, dx, dy) {
    var image = document.getElementById(x);
    ctx.drawImage(image, dx, dy, 70, 70);
}

//function creates the image
function finalImage() {
    var element = document.getElementById( 'picture' );
    var img = canvas.toDataURL( 'image/jpeg' );
    element.setAttribute('value', img);
}