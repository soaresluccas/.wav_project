document.addEventListener('DOMContentLoaded', function() {
    const filterButton = document.getElementById('filter');
    const filtroContainer = document.getElementById('filtro_container');

    filterButton.addEventListener('click', function() {
        filtroContainer.classList.toggle('active');
    });
});