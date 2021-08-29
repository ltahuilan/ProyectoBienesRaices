document.addEventListener('DOMContentLoaded', function() {
    eventsListeners();
    darkMode();
});

function eventsListeners() {
    const menu = document.querySelector('.mobil-menu');
    menu.addEventListener('click', function() {
        const navegacion = document.querySelector('.navegacion');

        if(navegacion.classList.contains('mostrar')) {
            navegacion.classList.remove('mostrar')
        }else {
            navegacion.classList.add('mostrar');
        };

        /**Modo corto con el método toggle */
        // navegacion.classList.toggle('mostrar');
    });
};

function darkMode() {
    const darkMode = document.querySelector('.dark-mode-boton');

    darkMode.addEventListener('click', function () {
        document.body.classList.toggle('dark-mode');
    });
};