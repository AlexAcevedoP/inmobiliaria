document.addEventListener('DOMContentLoaded', function() {

    eventListeners();

    darkMode();
});

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
