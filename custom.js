
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