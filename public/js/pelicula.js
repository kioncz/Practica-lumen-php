class busquedaTotalPelicula {
    constructor() {
        document.getElementById('busqueda').addEventListener('submit', (event) => {
            event.preventDefault();
            this.EnviarFormulario();
        });
    }

    buscarPelicula() {
        return document.getElementById('genero').value.trim();
    }

    async EnviarFormulario() {
        const genero = this.buscarPelicula();
        const url = `/peliculas/buscargenero?genero=${encodeURIComponent(genero)}`;

        try {
            const respuesta = await fetch(url, {
                headers: {
                    Accept: 'application/json',
                },
            });

            if (!respuesta.ok) {
                throw new Error(`Error HTTP: ${respuesta.status}`);
            }

            this.mostrarPeliculas(await respuesta.json());
        } catch (error) {
            console.error('Error al buscar películas:', error);
        }
    }

    mostrarPeliculas(peliculas) {
        const cuerpoTabla = document.querySelector('#peliculas-list tbody');
        cuerpoTabla.innerHTML = peliculas.map((pelicula) => `
            <tr>
                <td>${pelicula.id}</td>
                <td>${pelicula.titulo}</td>
                <td>${pelicula.genero}</td>
                <td>${pelicula.anio}</td>
                <td>${pelicula.actores.map((actor) => `${actor.nombre}<br>`).join('')}</td>
                <td>${pelicula.actores
                    .flatMap((actor) => actor.personajes)
                    .map((personaje) => `${personaje.nombre}: ${personaje.descripcion}<br>`)
                    .join('')}</td>
            </tr>
        `).join('');
    }
}

document.addEventListener('DOMContentLoaded', () => {
    new busquedaTotalPelicula();
});