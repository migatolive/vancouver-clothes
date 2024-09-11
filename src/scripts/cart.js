$(document).ready(function() {
    function updateCart() {
        $.ajax({
            url: 'backend/cart.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    let cartItems = $('#cartItems');
                    cartItems.empty();

                    response.cartItems.forEach(function(item) {
                        let itemHtml = `
                            <tr>
                                <td>${item.name}</td>
                                <td>${item.quantity}</td>
                                <td>$${item.price}</td>
                                <td>$${item.total}</td>
                                <td><button class="remove-from-cart" data-id="${item.product_id}">Eliminar</button></td>
                            </tr>
                        `;
                        cartItems.append(itemHtml);
                    });

                    // Actualizar el total del carrito
                    let totalAmount = response.cartItems.reduce((sum, item) => sum + parseFloat(item.total), 0);
                    $('#totalAmount').text(totalAmount.toFixed(2));
                } else {
                    alert('Error al obtener los elementos del carrito: ' + response.message);
                    if (response.message === 'Usuario no autenticado') {
                        window.location.href = 'login.html';
                    }
                }
            },
            error: function(xhr, status, error) {
                console.log('Error: ' + error);
            }
        });
    }

    updateCart();

    $(document).on('click', '.add-to-cart', function() {
        const productId = $(this).data('id');
        const quantityElement = $(this).siblings('.quantity');
        const quantity = quantityElement.length ? parseInt(quantityElement.val()) : 1;

        $.ajax({
            url: 'backend/cart.php',
            type: 'POST',
            data: {
                action: 'add',
                product_id: productId,
                quantity: quantity
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    alert('Producto agregado al carrito.');
                } else {
                    alert('Error al agregar el producto al carrito: ' + response.message);
                    if (response.message === 'Usuario no autenticado') {
                        window.location.href = 'login.html';
                    }
                }
            },
            error: function(xhr, status, error) {
                console.log('Error: ' + error);
            }
        });
    });

    $(document).on('click', '.remove-from-cart', function() {
        const productId = $(this).data('id');

        $.ajax({
            url: 'backend/cart.php',
            type: 'POST',
            data: {
                action: 'remove',
                product_id: productId
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    alert('Producto eliminado del carrito.');
                    updateCart();
                } else {
                    alert('Error al eliminar el producto del carrito: ' + response.message);
                    if (response.message === 'Usuario no autenticado') {
                        window.location.href = 'login.html';
                    }
                }
            },
            error: function(xhr, status, error) {
                console.log('Error: ' + error);
            }
        });
    });
});