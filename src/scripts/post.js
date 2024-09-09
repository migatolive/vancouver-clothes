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
                    window.location.href = 'success.html';
                } else {
                    $('#errorMessage').text('Correo electronico o contraseña incorrectos.');
                }
            },
            error: function(xhr, status, error) {
                console.log('Error: ' + error);
            }
        });
    });
});