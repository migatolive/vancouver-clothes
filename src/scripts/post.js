$(document).ready(function() {
    $('#loginForm').on('submit', function(event) {
        event.preventDefault();
        const email = $('#email').val();
        const password = $('#password').val();

        $.ajax({
            url: 'backend/datos.php',
            type: 'POST',
            data: { email: email, password: password },
            success: function(response) {
                if (response.success) {
                    window.location.href = 'products.html';
                } else {
                    $('#errorMessage').text('Correo electronico o contraseña incorrectos.');
                }
            },
            error: function(xhr, status, error) {
                console.log('Error: ' + error);
            }
        });
    });

    $('#registerForm').on('submit', function(event) {
        event.preventDefault();
        const email = $('#email').val();
        const password = $('#password').val();

        $.ajax({
            url: 'backend/register.php',
            type: 'POST',
            data: { email: email, password: password },
            success: function(response) {
                if (response.success) {
                    $('#registerMessage').text('Usuario registrado correctamente.');
                } else {
                    $('#errorMessage').text('El correo electronico ya esta registrado.');
                }
            },
            error: function(xhr, status, error) {
                console.log('Error: ' + error);
            }
        });
    });

    $(document).on('click', '.logout', function() {
        event.preventDefault();
        $.ajax({
            url: 'backend/logout.php',
            type: 'GET',
            success: function(response) {
                if (response.success) {
                    window.location.href = 'index.html';
                } else {
                    alert('Error al cerrar sesión.');
                }
            },
            error: function(xhr, status, error) {
                console.log('Error: ' + error);
            }
        });
    });
});