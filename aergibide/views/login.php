<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aergibide</title>

    <link rel="stylesheet" href="styles/style_general.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>

<?php require __DIR__ . '/layout/header.php'; ?>

<h1>Login</h1>

<input type="email" id="email" placeholder="Email">
<input type="password" id="password" placeholder="Contraseña">
<button id="boton">Entrar</button>

<p id="mensaje"></p>

<script>

const inputEmail = document.querySelector('#email');
const inputPassword = document.querySelector('#password');
const boton = document.querySelector('#boton');
const mensaje = document.querySelector('#mensaje');

boton.addEventListener('click', hacerLogin);


async function hacerLogin() {

    const email = inputEmail.value;
    const password = inputPassword.value;

    

    const datos = { email: email, password: password };
    const datosEnTexto = JSON.stringify(datos);

    const respuesta = await fetch('index.php?controller=UsuarioController&accion=login', {
        method: 'POST',
        body: datosEnTexto
    });

    const resultado = await respuesta.json();

    if (resultado.ok == true) {
        window.location.href = 'index.php?controller=UsuarioController';
        alert('Bienvenido');
    } else {
        mensaje.textContent = 'Email o contraseña incorrectos';
        alert('Email o contraseña incorrectos');
    }
}


</script>

<?php require __DIR__ . '/layout/footer.php'; ?>