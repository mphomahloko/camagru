function readyImg() {
    var img = document.getElementById('imgUpload');
    var x = document.getElementById('canvas');
    var ctx = x.getContext('2d');
    x.height = 480;
    x.width = 640;
    ctx.drawImage( img, 0, 0, x.width, x.height);
}
//readyImg();