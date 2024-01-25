//FUNCION DE GEOREFERENCIA CON PERMISO DEL NAVEGADOR QUE YA VIENE INCLUIDA EN JAVASCRIPT
if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
    document.getElementById('lat').value = position.coords.latitude;
    document.getElementById('lon').value = position.coords.longitude;
    });
} else {
    console.log("Geolocalización no está disponible en este navegador.");
}