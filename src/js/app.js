document.addEventListener('DOMContentLoaded', function() {

    eventListeners();

    darkMode();

    galeriaImagenes();
});

document.addEventListener('DOMContentLoaded', function() {
    const tipoPropiedad = document.getElementById('tipo_propiedad');
    const camposRelevantes = document.getElementById('campos-relevantes');

    if (tipoPropiedad) {
        tipoPropiedad.addEventListener('change', mostrarCamposRelevantes);

        // Inicializar la visibilidad de los campos al cargar la página
        mostrarCamposRelevantes();
    }
});

function mostrarCamposRelevantes() {
    const tipoPropiedad = document.getElementById('tipo_propiedad').value;
    const camposRelevantes = document.getElementById('campos-relevantes');
    const campoHabitaciones = document.getElementById('campo-habitaciones');

    if (tipoPropiedad === '3') { // Verificar si el valor es '3' para ocultar todos los campos
        camposRelevantes.style.display = 'none';
    } else {
        camposRelevantes.style.display = 'block';
    }

    if (tipoPropiedad === '4' || tipoPropiedad === '5') { // Verificar si el valor es '4' o '5' para ocultar el campo habitaciones
        campoHabitaciones.style.display = 'none';
        inputHabitaciones.value = 1; // Establecer el valor a 1
    } else {
        campoHabitaciones.style.display = 'block';
    }
}

function darkMode() {

    const prefiereDarkMode = window.matchMedia('(prefers-color-scheme: dark)');

    // console.log(prefiereDarkMode.matches);

    if(prefiereDarkMode.matches) {
        document.body.classList.add('dark-mode');
    } else {
        document.body.classList.remove('dark-mode');
    }

    prefiereDarkMode.addEventListener('change', function() {
        if(prefiereDarkMode.matches) {
            document.body.classList.add('dark-mode');
        } else {
            document.body.classList.remove('dark-mode');
        }
    });

    const botonDarkMode = document.querySelector('.dark-mode-boton');
    botonDarkMode.addEventListener('click', function() {
        document.body.classList.toggle('dark-mode');
    });
}

function eventListeners() {
    const mobileMenu = document.querySelector('.mobile-menu');

    mobileMenu.addEventListener('click', navegacionResponsive);

    //mostrar campos condicionales en el formulario de contacto
    const metodoContacto= document.querySelectorAll('input[name="contacto[contacto]"]');

    metodoContacto.forEach(input => input.addEventListener('click', mostrarMetodosContacto))
}

function navegacionResponsive() {
    const navegacion = document.querySelector('.navegacion');

    navegacion.classList.toggle('mostrar')
}

function mostrarMetodosContacto(e){
    const contactoDiv = document.querySelector('#contacto')

   if(e.target.value === 'telefono'){
        contactoDiv.innerHTML = `
         <label for="telefono">Número de teléfono</label>
                <input type="tel" placeholder="Tu Teléfono" id="telefono" name="contacto[telefono]" >

                <p>Elija la fecha y la hora para la llamada</p>

                <label for="fecha">Fecha:</label>
                <input type="date" id="fecha" name="contacto[fecha]">

                <label for="hora">Hora:</label>
                <input type="time" id="hora" min="09:00" max="18:00" name="contacto[hora]">
        `;
   }else {
    contactoDiv.innerHTML = `
     <label for="email">E-mail</label>
                <input type="email" placeholder="Tu Email" id="email" name="contacto[email]" >

     `;
   }
}
function galeriaImagenes() {
    const miniaturas = document.querySelectorAll('.miniatura');
    const imagenAmpliada = document.getElementById('imagen-ampliada');
    const imagenAmpliadaContenido = document.getElementById('imagen-ampliada-contenido');
    const cerrar = document.querySelector('.cerrar');
    const prev = document.getElementById('prev');
    const next = document.getElementById('next');
    let currentIndex = 0;

    miniaturas.forEach(miniatura => {
        miniatura.addEventListener('click', function() {
            currentIndex = parseInt(this.getAttribute('data-index'));
            mostrarImagenAmpliada(currentIndex);
        });
    });

    cerrar.addEventListener('click', function() {
        imagenAmpliada.style.display = 'none';
    });

    prev.addEventListener('click', function() {
        currentIndex = (currentIndex === 0) ? miniaturas.length - 1 : currentIndex - 1;
        mostrarImagenAmpliada(currentIndex);
    });

    next.addEventListener('click', function() {
        currentIndex = (currentIndex === miniaturas.length - 1) ? 0 : currentIndex + 1;
        mostrarImagenAmpliada(currentIndex);
    });

    imagenAmpliada.addEventListener('click', function(event) {
        if (event.target === imagenAmpliada) {
            imagenAmpliada.style.display = 'none';
        }
    });

    function mostrarImagenAmpliada(index) {
        imagenAmpliada.style.display = 'block';
        imagenAmpliadaContenido.src = miniaturas[index].src;
    }
}
