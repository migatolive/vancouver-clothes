// const jsdom = require('jsdom');
// const { JSDOM } = jsdom;
// const { window } = new JSDOM('<!doctype html><html><body><div id="userInfo"></div></body></html>');
// const $ = require('jquery')(window);

$(document).ready(function() {
    $.getJSON('data/datos.json', function(data) {
        $('#userInfo').html(
            `<p>Nombre: ${data.nombre}</p>
             <p>Edad: ${data.edad}</p>
             <p>Email: ${data.email}</p>`
        );
    });
});