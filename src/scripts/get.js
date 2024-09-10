$(document).ready(function() {
    $.getJSON('./data/datos.json', function(data) {
        $('#userInfo').html(
            `<p>Nombre: ${data.nombre}</p>
             <p>Edad: ${data.edad}</p>
             <p>Email: ${data.email}</p>`
        );
    });
});