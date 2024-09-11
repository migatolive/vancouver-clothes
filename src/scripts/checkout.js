$(function() {
    const stripe = Stripe('pk_test_51P8tTJJHmiqmw4zZwvLrCq5sYd6q8U0TmZvhAMwUYASAhry7pBdbl4tp7lcv6iqC7aZv0fca66iu5tM9tYhCLG7Q00IGO05F2k');
    let card, address, totalAmount = 0;
    const appearance = {
        theme: 'flat',
        variables: {
            colorPrimary: '#262626',
            colorBackground: '#f8f9fa',
            colorText: '#262626',
            colorDanger: '#dc3545',
            fontFamily: 'Ideal Sans, system-ui, sans-serif',
            spacingUnit: '4px',
            borderRadius: '4px',
        },
        labels: 'floating',
    };

    $("#checkoutButton").on("click", function(event) {
        event.preventDefault();
        totalAmount = Math.round(parseFloat($('#totalAmount').text()) * 100);

        if (isNaN(totalAmount) || totalAmount <= 0) {
            console.error('El monto total de la compra debe ser mayor a 0 y un número válido.');
            console.log('Monto total: ' + totalAmount);
            return;
        }

        const options = {
            mode: 'payment',
            amount: totalAmount,
            currency: 'ars',
            appearance: appearance,
        }
        const elements = stripe.elements(options);
        card = elements.create('card', {
            hidePostalCode: true
        });
        address = elements.create('address', {
            mode: 'shipping',
            allowedCountries: ['AR']
        });

        card.mount('#card-element');
        address.mount('#address-element');

        $("#paymentForm").css("display", "block");
        $('#checkoutButton').addClass("hidden");
    });

    $("#paymentForm").on("submit", function(event) {
        event.preventDefault();
        stripe.createToken(card).then(function(result) {
            if (result.error) {
                console.error(result.error.message);
            } else {
                const token = result.token.id;
                const data = address.getValue(); // Obtener los datos de la dirección

                $.ajax({
                    url: 'backend/checkout.php',
                    type: 'POST',
                    data: {
                        action: 'createPaymentIntent',
                        token: token,
                        amount: totalAmount,
                        address: data,
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            $('#payment-message').text('Compra realizada con éxito.').css('color', 'green').removeClass("hidden");
                            $('#paymentForm').off('submit');
                            $.ajax({
                                url: 'backend/checkout.php',
                                type: 'POST',
                                data: {
                                    action: 'confirmPaymentIntent',
                                    paymentIntentId: response.paymentIntentId,
                                },
                            });

                            $.ajax({
                                url: 'backend/checkout.php',
                                type: 'POST',
                                data: {
                                    action: 'dropOrderTable',
                                },
                            });

                            setTimeout(() => {
                                location.reload();
                            }, 2000);
                        } else {
                            $('#payment-message').text('Error al procesar la compra: ' + response.message + ' (Código: ' + response.code + ')').css('color', 'red').removeClass("hidden");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log('Error: ' + error);
                        try {
                            let response = JSON.parse(xhr.responseText);
                            console.error('Server response:', response);
                        } catch (e) {
                            console.error('Invalid JSON response from server');
                        }
                    }
                });
            }
        });
    });
});