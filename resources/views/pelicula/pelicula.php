<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Películas</title>
    <link rel="stylesheet" href="/css/pelicula.css">
</head>
<body>
    <main>
        <h1>Películas</h1>

        <form id="filtro-genero" action="/peliculas/buscargenero" method="GET">
            <div>
                <label for="genero">Género</label>
                <input
                    type="text"
                    id="genero"
                    name="genero"
                    value="<?= htmlspecialchars($genero) ?>"
                    placeholder="Ejemplo: acción"
                    required
                >
            </div>
            <button type="submit">Buscar</button>
            <button type="button" id="mostrar-todas">Mostrar todas</button>
        </form>

        <p id="mensaje" role="status"></p>

        <section id="resultados">
            <?php if ($genero !== ''): ?>
                <h2>Resultados para: <?= htmlspecialchars($genero) ?></h2>
            <?php endif; ?>

            <?php if ($peliculas->isEmpty()): ?>
                <?php if ($genero !== ''): ?>
                    <p>No se encontraron películas para este género.</p>
                <?php endif; ?>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Director</th>
                            <th>Año</th>
                            <th>Género</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($peliculas as $pelicula): ?>
                            <tr>
                                <td><?= htmlspecialchars($pelicula->titulo) ?></td>
                                <td><?= htmlspecialchars($pelicula->director) ?></td>
                                <td><?= htmlspecialchars($pelicula->anio) ?></td>
                                <td><?= htmlspecialchars($pelicula->genero) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </section>

    <script>
        const formulario = document.getElementById('filtro-genero');
        const resultados = document.getElementById('resultados');
        const mensaje = document.getElementById('mensaje');
        const mostrarTodas = document.getElementById('mostrar-todas');

        mostrarTodas.addEventListener('click', async function () {
            mensaje.textContent = 'Cargando todas las películas...';

            try {
                const respuesta = await fetch('/peliculas/todas', {
                    headers: { 'Accept': 'text/html' }
                });

                if (!respuesta.ok) {
                    throw new Error('No se pudieron cargar todas las películas.');
                }

                const html = await respuesta.text();
                const documento = new DOMParser().parseFromString(html, 'text/html');
                resultados.innerHTML =
                    documento.getElementById('resultados').innerHTML;
                mensaje.textContent = '';
                window.history.pushState({}, '', '/peliculas/todas');
            } catch (error) {
                mensaje.textContent = error.message;
            }
        });

        formulario.addEventListener('submit', async function (event) {
            event.preventDefault();
            mensaje.textContent = 'Buscando...';

            const parametros = new URLSearchParams(new FormData(formulario));

            try {
                const respuesta = await fetch(
                    formulario.action + '?' + parametros,
                    { headers: { 'Accept': 'text/html' } }
                );

                if (!respuesta.ok) {
                    throw new Error('La búsqueda no pudo completarse.');
                }

                const html = await respuesta.text();
                const documento = new DOMParser().parseFromString(html, 'text/html');
                resultados.innerHTML =
                    documento.getElementById('resultados').innerHTML;
                mensaje.textContent = '';
                window.history.pushState(
                    {},
                    '',
                    formulario.action + '?' + parametros
                );
            } catch (error) {
                mensaje.textContent = error.message;
            }
        });
    </script>
    </main>
</body>
</html>
