$(document).ready(function() {
    // Cargar todas las ventas al cargar la página
    loadVentas();
    loadPrendas(); // Cargar las prendas disponibles para seleccionar en el formulario de ventas

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
        $('#ventaModal').modal('hide'); // Cerrar el modal después de enviar
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

// Función para cargar todas las prendas
function loadPrendas() {
    ajaxRequest('GET', 'php/prendas.php', null, function(response) {
        const prendas = JSON.parse(response);
        populatePrendaOptions(prendas);
    });
}

// Función para poblar las opciones de prenda
function populatePrendaOptions(prendas) {
    const select = $('#ventaPrendaId');
    select.empty();
    prendas.forEach(function(prenda) {
        select.append(new Option(prenda.nombre, prenda.id)); // Mostrar nombre pero enviar ID
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
    $('#ventaId').val(id);
    $('#ventaPrendaId').val(prenda_id); // Asegurarse de que el ID de la prenda se seleccione correctamente
    $('#ventaCantidad').val(cantidad);
    $('#ventaFecha').val(fecha);
    $('#formTitle').text('Actualizar Venta');
    $('#cancelButton').show(); // Mostrar el botón de cancelar
    $('#ventaModal').modal('show'); // Mostrar el modal de venta
}

// Función para resetear el formulario
function prepareAddForm(formSelector, titleSelector, titleText) {
    $(formSelector)[0].reset();
    $('#ventaId').val('');
    $(titleSelector).text(titleText);
    $('#cancelButton').hide(); // Ocultar el botón de cancelar
    $('#ventaModal').modal('show'); // Mostrar el modal de venta
}

// Función para realizar solicitudes AJAX
function ajaxRequest(method, url, data, successCallback, errorCallback) {
    $.ajax({
        type: method,
        url: url,
        data: JSON.stringify(data),
        contentType: 'application/json',
        success: successCallback,
        error: errorCallback
    });
}

// Función para mostrar alertas
function showAlert(message, type) {
    const alertHtml = `<div class="alert alert-${type} alert-dismissible fade show" role="alert">
        ${message}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>`;
    $('.container').prepend(alertHtml);
    setTimeout(() => {
        $('.alert').alert('close');
    }, 3000);
}
