
window.onload = function () {
    var img = document.getElementById('imgUpload');
    var x = document.getElementById('canvas');
    x.height = 480;
    x.width = 640;
    var ctx = x.getContext('2d');
    ctx.drawImage( img, 0, 0, x.width, x.height);
}