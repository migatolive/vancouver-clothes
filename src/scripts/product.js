$(document).ready(function () {
    $.ajax({
        url: 'backend/product.php',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.error) {
                alert(response.error);
                window.location.href = 'login.html';
                return;
            }

            let productList = $('#productList');
            productList.empty();

            response.products.forEach(function(product) {
                let productHtml = `
                    <div class="product">
                        <h2>${product.name}</h2>
                        <p>Precio: $${product.price}</p>
                        <input type="number" class="quantity" value="1" min="1">
                        <button class="add-to-cart" data-id="${product.id}">Agregar al Carrito</button>
                    </div>
                `;
                productList.append(productHtml);
            });

            console.log("La sesión está activa. ID del usuario: " + response.user_id);
        },
        error: function(xhr, status, error) {
            console.log('Error: ' + error);
        }
    });

    $('#productForm').on('submit', function(event) {
        event.preventDefault();
        const name = $('#name').val();
        const price = $('#price').val();

        $.ajax({
            url: 'backend/createProduct.php',
            type: 'POST',
            data: { name: name, price: price },
            success: function(response) {
                if (response.success) {
                    $('#productMessage').text('Producto agregado correctamente.');
                    $('#productForm').trigger('reset');
                } else {
                    $('#errorMessage').text('Error al agregar producto.');
                }
            },
            error: function(xhr, status, error) {
                console.log('Error: ' + error);
            }
        });
    });
});