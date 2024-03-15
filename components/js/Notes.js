document.addEventListener("DOMContentLoaded", function() {
    const agregarNota = document.getElementById('agregarNota');
    const formulario = document.getElementById('formulario');
    const menuItems = document.querySelectorAll('.menu a');

    // Función para mostrar u ocultar el formulario
    agregarNota.addEventListener('click', function() {
        agregarNota.style.display = 'none';
        formulario.style.display = 'block';
    });

    // Función para cerrar el formulario si se hace clic fuera de él
    document.addEventListener('click', function(event) {
        if (!formulario.contains(event.target) && !agregarNota.contains(event.target)) {
            agregarNota.style.display = 'block';
            formulario.style.display = 'none';
        }
    });

    // Manejar clics en los botones del menú y resaltar la opción seleccionada
    menuItems.forEach(item => {
        item.addEventListener('click', function() {
            // Eliminar la clase activa de todas las opciones del menú
            menuItems.forEach(item => {
                item.classList.remove('active');
            });
            // Agregar la clase activa solo a la opción seleccionada
            this.classList.add('active');
        });
    });

    // Ajustar dinámicamente la altura del textarea al cambiar su contenido
    const textarea = document.getElementById('contenido');
    textarea.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });
});

