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
php -S localhost:8000 -t /src
```

Después de iniciar el servidor, podrán acceder al formulario de login en 
`http://localhost:8000/login.html`

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
php -S localhost:8000 -t /src
```
4. Abre el navegador y ve a la dirección `http://localhost:8000/login.html`
para ver el formulario de inicio de sesion.

## Estructura

```CSS
.
├── src/
│   ├── backend/
│   │   ├── datos.php
│   │   └── utils/
│   │       ├── .env
│   │       └── connection.php
│   ├── data/
│   │   └── datos.json
│   ├── login.html
│   ├── success.html
│   └── scripts/
│       ├── post.js
│       └── get.js
```

## Desarrollo de la Tarea

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

#### Formulario de Login

![Formulario de Login](https://i.imgur.com/vpo2jIW.png)

#### Mensaje de Error

![Mensaje de Error](https://i.imgur.com/lprFQW3.png)

#### Página de Éxito

![Página de Éxito](https://i.imgur.com/GSVjHZQ.png)

#### Datos JSON

![Datos JSON](https://i.imgur.com/u2xV2y9.png)