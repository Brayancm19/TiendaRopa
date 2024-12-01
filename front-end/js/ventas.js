$(document).ready(function() {
    // Cargar todas las ventas al cargar la página
    loadVentas();

    // Manejar el formulario de ventas
    $('#ventaForm').submit(function(event) {
        event.preventDefault();
        const id = $('#ventaId').val();
        const prenda_id = $('#ventaPrendaId').val();
        const cantidad = $('#ventaCantidad').val();
        const fecha = $('#ventaFecha').val();
        if (id) {
            updateVenta(id, prenda_id, cantidad, fecha);
        } else {
            createVenta(prenda_id, cantidad, fecha);
        }
    });

    // Manejar el botón de cancelar
    $('#cancelButton').click(function() {
        prepareAddForm('#ventaForm', '#formTitle', 'Agregar Nueva Venta');
    });
});

// Función para cargar todas las ventas
function loadVentas() {
    ajaxRequest('GET', 'php/ventas.php', null, function(response) {
        const ventas = JSON.parse(response);
        populateTable('#ventasTableBody', ventas, renderVentaRow);
    });
}

// Función para crear una nueva venta
function createVenta(prenda_id, cantidad, fecha) {
    const data = { prenda_id: prenda_id, cantidad: cantidad, fecha: fecha };
    ajaxRequest('POST', 'php/ventas.php', data, function(response) {
        showAlert('Venta creada exitosamente', 'success');
        loadVentas();
        prepareAddForm('#ventaForm', '#formTitle', 'Agregar Nueva Venta');
    }, function(error) {
        showAlert('Error al crear la venta', 'danger');
    });
}

// Función para actualizar una venta existente
function updateVenta(id, prenda_id, cantidad, fecha) {
    const data = { id: id, prenda_id: prenda_id, cantidad: cantidad, fecha: fecha };
    ajaxRequest('PUT', 'php/ventas.php', data, function(response) {
        showAlert('Venta actualizada exitosamente', 'success');
        loadVentas();
        prepareAddForm('#ventaForm', '#formTitle', 'Agregar Nueva Venta');
    }, function(error) {
        showAlert('Error al actualizar la venta', 'danger');
    });
}

// Función para eliminar una venta
function deleteVenta(id) {
    if (confirm('¿Estás seguro de que deseas eliminar esta venta?')) {
        const data = { id: id };
        ajaxRequest('DELETE', 'php/ventas.php', data, function(response) {
            showAlert('Venta eliminada exitosamente', 'success');
            loadVentas();
        }, function(error) {
            showAlert('Error al eliminar la venta', 'danger');
        });
    }
}

// Función para renderizar una fila de la tabla de ventas
function renderVentaRow(venta) {
    return `
        <tr>
            <td>${venta.id}</td>
            <td>${venta.prenda_id}</td>
            <td>${venta.cantidad}</td>
            <td>${venta.fecha}</td>
            <td>
                <button class="btn btn-primary btn-sm" onclick="editVenta(${venta.id}, ${venta.prenda_id}, ${venta.cantidad}, '${venta.fecha}')">Editar</button>
                <button class="btn btn-danger btn-sm" onclick="deleteVenta(${venta.id})">Eliminar</button>
            </td>
        </tr>
    `;
}

// Función para preparar el formulario para editar una venta
function editVenta(id, prenda_id, cantidad, fecha) {
    const data = { id: id, prenda_id: prenda_id, cantidad: cantidad, fecha: fecha };
    prepareUpdateForm('#ventaForm', '#formTitle', 'Actualizar Venta', data);
}
