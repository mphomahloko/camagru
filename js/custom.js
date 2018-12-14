
var p1 = document.getElementById( 'pass1' );
var p2 = document.getElementById( 'pass2' );

if (p2){
    p2.addEventListener("input", function(event){
        if ( p1.value != p2.value ) {
            document.getElementById('alert-error').innerHTML = "Error: passwords do not match";
            event.preventDefault();
        } else {
            document.getElementById('alert-error').innerHTML = "";
        }
    });
}