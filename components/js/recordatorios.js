document.addEventListener("DOMContentLoaded", function() {
    const agregarRecordatorio = document.getElementById('agregarRecordatorio');
    const formularioRecordatorio = document.getElementById('formularioRecordatorio');

    // Función para mostrar u ocultar el formulario de recordatorio
    agregarRecordatorio.addEventListener('click', function() {
        agregarRecordatorio.style.display = 'none';
        formularioRecordatorio.style.display = 'block';
    });

    // Función para cerrar el formulario de recordatorio si se hace clic fuera de él
    document.addEventListener('click', function(event) {
        if (!formularioRecordatorio.contains(event.target) && event.target !== agregarRecordatorio) {
            agregarRecordatorio.style.display = 'block';
            formularioRecordatorio.style.display = 'none';
        }
    });

    // Ajustar dinámicamente la altura del textarea del recordatorio al cambiar su contenido
    const textareaRecordatorio = document.getElementById('contenidoRecordatorio');
    textareaRecordatorio.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });
});
