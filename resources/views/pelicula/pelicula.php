<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Películas</title>
    <link rel="stylesheet" href="/css/pelicula.css">
    <script src="/js/pelicula.js"></script>
</head>
<body>
    <div class="container">
        <h1>Películas</h1>

        <div class = 'boton-busqueda'>
            <form id="busqueda">
                <label for="genero">Buscar por género:</label>
                <input type="text" id="genero" name="genero">
                <button type="submit">Buscar</button>
            </form>
        </div>
        <div id="peliculas-list">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Género</th>
                        <th>Año</th>
                        <th>Actores</th>
                        <th>Personajes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($peliculas as $pelicula): ?>
                        <tr>
                            <td><?= $pelicula['id'] ?></td>
                            <td><?= $pelicula['titulo'] ?></td>
                            <td><?= $pelicula['genero'] ?></td>
                            <td><?= $pelicula['anio'] ?></td>
                            <td>
                                <?php foreach ($pelicula->actores as $actor): ?>
                                    <?= $actor->nombre ?><br>
                                <?php endforeach; ?>
                            </td>
                            <td>
                                <?php foreach ($pelicula->actores as $actor): ?>
                                    <?php foreach ($actor->personajes as $personaje): ?>
                                        <?= $personaje->nombre ?>: <?= $personaje->descripcion ?><br>
                                    <?php endforeach; ?>
                                <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
        </div>
    </div>  
</body>
</html>
