$(document).ready(function() {
    // Cargar todos los reportes al cargar la página
    loadMarcasConVentas();
    loadPrendasVendidas();
    loadTop5Marcas();

    // Función para cargar el reporte de marcas con ventas
    function loadMarcasConVentas() {
        ajaxRequest('GET', 'php/reportes.php?tipo=marcasConVentas', null, function(response) {
            const marcasConVentas = JSON.parse(response);
            populateTable('#marcasConVentasTableBody', marcasConVentas, renderMarcaConVentasRow);
        });
    }

    // Función para cargar el reporte de prendas vendidas
    function loadPrendasVendidas() {
        ajaxRequest('GET', 'php/reportes.php?tipo=prendasVendidas', null, function(response) {
            const prendasVendidas = JSON.parse(response);
            populateTable('#prendasVendidasTableBody', prendasVendidas, renderPrendaVendidaRow);
        });
    }

    // Función para cargar el reporte de top 5 marcas más vendidas
    function loadTop5Marcas() {
        ajaxRequest('GET', 'php/reportes.php?tipo=top5Marcas', null, function(response) {
            const top5Marcas = JSON.parse(response);
            populateTable('#top5MarcasTableBody', top5Marcas, renderTop5MarcaRow);
        });
    }

    // Función para renderizar una fila de la tabla de marcas con ventas
    function renderMarcaConVentasRow(marca) {
        return `
            <tr>
                <td>${marca.nombre}</td>
            </tr>
        `;
    }

    // Función para renderizar una fila de la tabla de prendas vendidas
    function renderPrendaVendidaRow(prenda) {
        return `
            <tr>
                <td>${prenda.nombre}</td>
                <td>${prenda.cantidad_vendida}</td>
                <td>${prenda.cantidad_stock}</td>
            </tr>
        `;
    }

    // Función para renderizar una fila de la tabla de top 5 marcas más vendidas
    function renderTop5MarcaRow(marca) {
        return `
            <tr>
                <td>${marca.nombre}</td>
                <td>${marca.total_ventas}</td>
            </tr>
        `;
    }
});
