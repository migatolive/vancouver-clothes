# Trabajo Practico: Tareas con jQuery, PHP y AJAX

## Introducción

Este repositorio contiene una serie de tareas enfocadas en el uso de jQuery con PHP. Estas tareas buscan demostrar el uso de tecnologías modernas para la creación de formularios, manejo de datos JSON, y comunicación asíncrona mediante AJAX.

Para esta serie de tareas, he utilizado **PostgreSQL** como sistema de base de datos, en lugar de MySQL, debido a los requerimientos de mi entorno. Además, he implementado AJAX tal como lo pide la tarea para la comunicación entre el cliente y el servidor.

El repositorio incluye tanto el código HTML como el PHP, junto con los scripts necesarios para realizar las solicitudes AJAX y manejar respuestas JSON.

**Nota importante:** Al clonar este repositorio en sus máquinas, deberán instalar las dependencias con el siguiente comando antes de ejecutar el proyecto:

```bash
composer install
```

Luego, para ejecutar el servidor, pueden usar el siguiente comando:

```bash
php -S localhost:8000 -t src
```

## Tecnologias Utilizadas

- HTML5: Para la estructura de las páginas web.
- JavaScript (jQuery): Para la manipulación del DOM y las solicitudes AJAX.
- PHP: Para el backend que maneja el envío de datos y el acceso a la base de datos.
- PostgreSQL: Como sistema de base de datos.
- AJAX: Para la comunicación asíncrona entre el cliente y el servidor.
- JSON: Para el intercambio de datos entre el cliente y el servidor.
- Composer: Para la gestión de dependencias en PHP.

## Instrucciones de uso

1. Clonar el repositorio en sus máquinas.
2. Ejecuta el siguiente comando para instalar las dependencias:
```bash
composer install
```
3. Inicia el servidor con el siguiente comando:
```bash
php -S localhost:8000 -t src
```
4. Abre el navegador y ve a la dirección `http://localhost:8000/login.html`
para ver el formulario de inicio de sesion.

## Estructura

```CSS
.
└── src/
      ├── backend/
      │   ├── cart.php
      │   ├── checkout.php
      │   ├── createProduct.php
      │   ├── datos.php
      │   ├── logout.php
      │   ├── product.php
      │   ├── register.php
      │   └── utils/
      │       ├── .env
      │       └── connection.php
      ├── data/
      │   └── datos.json
      ├── scripts/
      │   ├── cart.js
      │   ├── get.js
      │   ├── post.js
      │   ├── product.js
      ├── cart.html
      ├── header.html
      ├── index.html
      ├── login.html
      ├── products.html
      ├── register.html
      └── success.html  (ya no se usa)
```

## Desarrollo de la Tarea: Conexión de jQuery con PHP

### 1. Crear un formulario de login en HTML y enviar los datos mediante AJAX a un archivo PHP llamado `datos.php`

En la tarea se creó un formulario simple de login (`src/login.html`) que recoge el correo electronico y contraseña. Los datos del formulario se envían de forma asíncrona a un archivo PHP (`src/backend/datos.php`) mediante una solicitud POST usando AJAX.
- Archivo HTML: `src/login.html`
- Archivo JS: `src/scripts/post.js`
- Archivo PHP (SQL): `src/backend/datos.php`
- Archivo PHP (CONN): `src/backend/utils/connection.php`

El archivo `datos.php` recibe los datos, verifica su autenticidad y devuelve una respuesta en formato JSON. Si los datos son correctos, se redirige al usuario a una página de éxito (`src/success.html`). Si los datos no son correctos, devuelve un mensaje de error que se muestra en el formulario.

### 2. ¿Qué método elegiste: GET o POST? ¿Por qué?

Elegí el método **POST** porque es más seguro para enviar datos sensibles, como nombres de usuario y contraseñas. A diferencia de **GET**, que incluye los datos en la URL, **POST** oculta la información en el cuerpo de la solicitud, lo que ayuda a proteger los datos.

### 3. ¿Qué es un archivo JSON y cómo se utiliza en jQuery?

Un archivo **JSON** (JavaScript Object Notation) es un formato de texto ligero utilizado para intercambiar datos. Su estructura es fácil de leer tanto para los humanos como para las máquinas.

En jQuery, se puede usar el método `$.getJSON()` para cargar datos desde un archivo JSON de manera asíncrona. Este método permite realizar una petición al servidor y recibir los datos en formato JSON.

### 4. Crear un archivo JSON llamado `datos` que guarde los datos de una persona y mostrarlos en pantalla mediante AJAX

El archivo JSON llamado `datos.json` contiene información de una persona, como nombre, edad, y correo electrónico. A través de AJAX, los datos de este archivo se obtienen y se muestran en el navegador cuando se carga la página.

- Archivo JSON: `src/data/datos.json`
- Archivo JS: `src/scripts/get.js`

### 5. ¿Cómo se accede a los datos específicos dentro de un objeto JSON utilizando jQuery?

Para acceder a datos específicos dentro de un objeto JSON con jQuery, se puede utilizar la notación de punto o corchetes. Por ejemplo:

```javascript
$.getJSON("src/data/datos.json", function(data) {
    console.log(data.nombre);  // Accede al valor de la propiedad "nombre"
    console.log(data['edad']);  // Otra forma de acceder al valor de "edad"
});
```

### Capturas de funcionamiento
##### de la tarea: Conexión de Jquery con PHP

#### Formulario de Login

![Formulario de Login](https://i.imgur.com/vpo2jIW.png)

#### Mensaje de Error

![Mensaje de Error](https://i.imgur.com/lprFQW3.png)

#### Página de Éxito

![Página de Éxito](https://i.imgur.com/GSVjHZQ.png)

#### Datos JSON

![Datos JSON](https://i.imgur.com/u2xV2y9.png)

## Desarrollo de la Tarea: Conexión con Base de Datos
**Descripción del Proyecto**

La empresa **Vancouver S.A.** requiere un sistema para registrar usuarios, manejar el login, y ofrecer funcionalidad de carrito de compras en su sitio web. El sistema permite a los usuarios registrarse, iniciar sesión, agregar y eliminar productos del carrito, y simular compras mediante tarjeta de crédito.

### 1. Registro de Usuarios
 - Se creó un formulario de registro (`register.html`) para que los usuarios puedan crear una cuenta. Los datos se envían a `backend/register.php`, que se conecta a la base de datos PostgreSQL y guarda los datos del usuario en la tabla correspondiente.
 - Archivo PHP: `src/backend/register.php`
 - Archivo JS: `src/scripts/post.js`

### 2. Login Funcional con AJAX
 - El login se maneja con `login.html` y realiza una llamada AJAX a `backend/datos.php`. Este archivo PHP valida el usuario contra la base de datos y devuelve una respuesta en formato JSON indicando el éxito o fallo del inicio de sesión.
 - Archivo PHP: `src/backend/datos.php`
 - Archivo JS: `src/scripts/post.js`

### 3. Carrito de Compras
 - El carrito de compras permite a los usuarios agregar y eliminar productos. Esta funcionalidad está implementada en `cart.html`, con la lógica manejada por `cart.js` y `backend/cart.php`.
 - **Funcionalidades del Carrito:**
   - Agregar productos: Se envían solicitudes AJAX para agregar productos al carrito.
   - Eliminar productos: Se envían solicitudes AJAX para eliminar productos individualmente.
   - Archivo PHP: `src/backend/cart.php`
   - Archivo JS: `src/scripts/cart.js`

### 4. Simulación de Compras
1. **Formulario de Pago**: Dentro de la página del carrito (`cart.html`), se incluye un formulario para realizar el pago, el cual solo aparece cuando el usuario decide proceder con la compra:
```html
<div id="paymentForm" style="display:none;">
   <h2>Información de Pago</h2>
   <form>
      <div id="card-element"></div> <br>
      <div id="address-element"></div>
      <button type="submit">Pagar</button>
      <div id="payment-message" class="hidden"></div>
   </form>
</div>
```
Este formulario incluye dos campos importantes:
 - `card-element`: Campo para ingresar los datos de la tarjeta de crédito.
 - `address-element`: Campo para ingresar la dirección de envío.
2. **Interaccion con Stripe:** En `checkout.js` es donde se inicializa Stripe y se manejan los eventos del pago. Stripe se usa para procesar de manera segura los pagos y las direcciones de envío.
 - Primero, se inicializa Stripe con la clave pública de prueba:
```javascript
const stripe = Stripe('pk_test_...');
```
 - Cuando el usuario hace clic en el botón de Proceder al Pago, se calcula el total de la compra, se configura el formulario de Stripe, y se muestran los campos para la tarjeta y la dirección.
 - Después de que el formulario de Stripe es montado, el usuario puede ingresar los datos de su tarjeta y dirección. Al hacer clic en **Pagar**, el script envía esta información a Stripe para generar un token de pago seguro:
```javascript
stripe.createToken(card).then(function(result) {
    const token = result.token.id;
    const data = address.getValue();  // Obtener la dirección del usuario
});
```
 - Con este token, se hace una petición AJAX a checkout.php para crear una intención de pago (Payment Intent) en los servidores de Stripe.
3. **Creacion de la Intencion de Pago**: El archivo `checkout.php` gestiona las peticiones del frontend (lo que envía el script `checkout.js`). Este archivo realiza varias acciones, pero la más importante es la creación de la intención de pago con Stripe.
 - Primero, se carga la clave secreta de Stripe desde las variables de entorno para interactuar con la API de Stripe:
```php
$stripeSecretKey = $_ENV['STRIPE_SECRET'];
$stripe = new \Stripe\StripeClient($stripeSecretKey);
```
 - Luego, si la acción solicitada es crear una intención de pago, se envían los datos del total y el token de la tarjeta a Stripe:
```php
$paymentIntent = $stripe->paymentIntents->create([
    'payment_method_types' => ['card'],
    'amount' => $amount,
    'currency' => 'ars',
    'payment_method_data' => [
        'type' => 'card',
        'card' => [
            'token' => $token
        ]
    ],
]);
```
 - Stripe devuelve un `paymentIntent`, que es la intención de pago creada con éxito. Este objeto es necesario para confirmar el pago más adelante.
4. **Confirmación y Limpieza del Carrito**: Una vez que Stripe ha procesado el pago exitosamente, el backend envía una confirmación:
```php
$stripe->paymentIntents->confirm($_POST['paymentIntentId'], ...);
```
 - Al completarse la compra, se vacía el carrito del usuario eliminando los elementos de la tabla `order_items` en la base de datos:
```php
    $query = "DELETE FROM order_items WHERE order_id = $1";
    $result = pg_query_params($conn, $query, array($order_id));
```
 - Después de esto, también se elimina la orden del usuario de la tabla `orders`.
5. **Simulación con Tarjetas de Prueba de Stripe**: Para probar este flujo de pago sin realizar transacciones reales, Stripe proporciona una serie de **tarjetas de prueba** que puedes usar. Por ejemplo, puedes usar el siguiente número de tarjeta de prueba para simular un pago exitoso:
 - **Número de Tarjeta**: `4000 0003 2000 0021`
 - **Fecha de vencimiento**: Cualquier fecha válida en el futuro.
 - **Código CVC**: Cualquier código de 3 dígitos.

Stripe tiene diferentes tarjetas de prueba para simular respuestas variadas (éxito, fallos, autenticaciones requeridas, etc.). Puedes revisar la lista completa en su [documentación oficial](https://docs.stripe.com/testing).

#### Resumen Final
 - **Flujo de pago**: Cuando el usuario hace clic en pagar, se usa Stripe para manejar el pago de manera segura. Los datos de la tarjeta no se almacenan en la base de datos, sino que se envían a Stripe, api que genera un token seguro.
 - **Simulación**: El proceso de compra está completamente simulado con las tarjetas de prueba de Stripe. Esto te permite realizar pruebas sin preocuparte por pagos reales.
 - **Archivo PHP**: `src/backend/checkout.php`
 - **Archivo JS:** `src/scripts/checkout.js`

### Base de Datos
El esquema de la base de datos **PostgreSQL** utilizado para este proyecto sigue la siguiente estructura:

#### Diagrama del Esquema de la Base de Datos
#### Tablas

1. **users**: Almacena los datos de los usuarios registrados, solo se utiliza el email y la contraseña en el sistema.
   - `email`: Dirección de correo electrónico del usuario.
   - `password`: Contraseña encriptada con BCrypt.

2. **products**: Contiene información sobre los productos disponibles para la compra.
   - `name`: Nombre del producto.
   - `price`: Precio del producto.

3. **orders**: Guarda información sobre las órdenes realizadas por los usuarios.
   - `user_id`: Referencia al usuario que hizo la orden.
   - `created_at`: Fecha en la que se realizó la orden.

4. **order_items**: Relaciona los productos con las órdenes realizadas.
   - `order_id`: Referencia a la orden.
   - `product_id`: Referencia al producto.
   - `quantity`: Cantidad de productos en la orden.

5. **shipments**: Guarda información sobre la dirección de envío de las órdenes.
   - `order_id`: Referencia a la orden.
   - `line_1`: Dirección de envío.
   - `line_2`: Dirección adicional (opcional).
   - `city`: Ciudad de envío.
   - `state`: Provincia o estado de envío.
   - `zip_code`: Código postal de envío.