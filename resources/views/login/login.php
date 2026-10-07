<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f2f2f2;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }
</style>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
</head>
<body>
    <h1>Login</h1>
    <form id="login-form" method="POST" action="/auth/login">
    <label for="email">Correo electrónico:</label>
    <input
        type="email"
        id="email"
        name="email"
        required
    >

    <label for="password">Contraseña:</label>
    <input
        type="password"
        id="password"
        name="password"
        required
    >

    <button type="submit">Iniciar sesión</button>

    <p id="mensaje"></p>
</form>
</body>
</html>

<script>
    document.getElementById('login-form').addEventListener('submit', async function(event) {
        event.preventDefault();

        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;

        try {
            const response = await fetch('/auth/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ email, password })
            });

            if (response.ok) {
                // Redirigir a la página de películas
                window.location.href = '/peliculas';
            } else {
                const data = await response.json();
                document.getElementById('mensaje').textContent = data.error || 'Error al iniciar sesión';
            }
        } catch (error) {
            console.error('Error:', error);
            document.getElementById('mensaje').textContent = 'Error al iniciar sesión';
        }
    });
</script>
