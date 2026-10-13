class busquedaTotalPelicula {
    constructor() {
        document.getElementById('busqueda').addEventListener('submit', (event) => {
            event.preventDefault();
            this.EnviarFormulario();
        });
    }

    buscarPelicula() {
        return {
            genero: document.getElementById('genero').value.trim(),
            titulo: document.getElementById('titulo').value.trim(),
        };
    }

    async EnviarFormulario() {
        const { genero, titulo } = this.buscarPelicula();

        if (!genero && !titulo) {
            window.location.reload();
            return;
        }

        const parametros = new URLSearchParams();
        let ruta = '/peliculas/buscargenero';

        if (genero) {
            parametros.set('genero', genero);
        } else if (titulo) {
            ruta = '/peliculas/buscarnombre';
            parametros.set('nombre', titulo);
        }

        const url = `${ruta}?${parametros.toString()}`;
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
            <td>${pelicula.id ?? ''}</td>
            <td>${pelicula.titulo ?? ''}</td>
            <td>${pelicula.genero ?? ''}</td>
            <td>${pelicula.anio ?? ''}</td>
            <td>
                ${(pelicula.actores ?? [])
                    .map((actor) => `${actor.nombre ?? ''}<br>`)
                    .join('')}
            </td>
            <td>
                ${(pelicula.actores ?? [])
                    .flatMap((actor) => actor.personajes ?? [])
                    .map((personaje) =>
                        `${personaje.nombre ?? ''}: ${personaje.descripcion ?? ''}<br>`
                    )
                    .join('')}
            </td>
        </tr>
    `).join('');
    }
}

document.addEventListener('DOMContentLoaded', () => {
    new busquedaTotalPelicula();
});