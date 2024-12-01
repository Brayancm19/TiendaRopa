$(document).ready(function() {
    // Cargar todas las prendas al cargar la página
    loadPrendas();
    loadMarcas(); // Cargar las marcas disponibles

    // Manejar el formulario de prendas
    $('#prendaForm').submit(function(event) {
        event.preventDefault();
        const id = $('#prendaId').val();
        const nombre = $('#prendaNombre').val();
        const talla = $('#prendaTalla').val();
        const cantidad_stock = $('#prendaCantidadStock').val();
        const marca_id = $('#prendaMarcaId').val();
        console.log('Formulario enviado:', { id, nombre, talla, cantidad_stock, marca_id });
        if (id) {
            updatePrenda(id, nombre, talla, cantidad_stock, marca_id);
        } else {
            createPrenda(nombre, talla, cantidad_stock, marca_id);
        }
        $('#prendaModal').modal('hide'); // Cerrar el modal después de enviar
    });

    // Función para cargar todas las prendas
    function loadPrendas() {
        ajaxRequest('GET', 'php/prendas.php', null, function(response) {
            const prendas = JSON.parse(response);
            populateTable('#prendasTableBody', prendas, renderPrendaRow);
        });
    }

    // Función para cargar todas las marcas
    function loadMarcas() {
        ajaxRequest('GET', 'php/marcas.php', null, function(response) {
            const marcas = JSON.parse(response);
            populateMarcaOptions(marcas);
        });
    }

    // Función para poblar las opciones de marca
    function populateMarcaOptions(marcas) {
        const select = $('#prendaMarcaId');
        select.empty();
        marcas.forEach(function(marca) {
            select.append(new Option(marca.nombre, marca.id));
        });
    }

    // Función para crear una nueva prenda
    function createPrenda(nombre, talla, cantidad_stock, marca_id) {
        console.log('Creando prenda:', { nombre, talla, cantidad_stock, marca_id });
        const data = { nombre: nombre, talla: talla, cantidad_stock: cantidad_stock, marca_id: marca_id };
        ajaxRequest('POST', 'php/prendas.php', data, function(response) {
            const res = JSON.parse(response);
            console.log('Respuesta del servidor:', response);
            if (res.status === 1) {
                showAlert('Prenda creada exitosamente', 'success');
                loadPrendas(); // Asegurarse de recargar las prendas después de crear una nueva
            } else {
                showAlert('Error: ' + res.status_message, 'danger');
            }
        }, function(error) {
            showAlert('Error al crear la prenda', 'danger');
        });
    }

    // Función para actualizar una prenda existente
    function updatePrenda(id, nombre, talla, cantidad_stock, marca_id) {
        console.log('Actualizando prenda:', { id, nombre, talla, cantidad_stock, marca_id });
        const data = { id: id, nombre: nombre, talla: talla, cantidad_stock: cantidad_stock, marca_id: marca_id };
        ajaxRequest('PUT', 'php/prendas.php', data, function(response) {
            const res = JSON.parse(response);
            console.log('Respuesta del servidor:', response);
            if (res.status === 1) {
                showAlert('Prenda actualizada exitosamente', 'success');
                loadPrendas(); // Asegurarse de recargar las prendas después de actualizar
            } else {
                showAlert('Error: ' + res.status_message, 'danger');
            }
        }, function(error) {
            showAlert('Error al actualizar la prenda', 'danger');
        });
    }

    // Función para eliminar una prenda
    window.deletePrenda = function(id) {
        console.log('Eliminando prenda:', id);
        if (confirm('¿Estás seguro de que deseas eliminar esta prenda?')) {
            const data = { id: id };
            ajaxRequest('DELETE', 'php/prendas.php', data, function(response) {
                try {
                    const res = JSON.parse(response);
                    console.log('Respuesta del servidor:', response);
                    if (res.status === 1) {
                        showAlert('Prenda eliminada exitosamente', 'success');
                        loadPrendas();
                    } else {
                        showAlert('Error: ' + res.status_message, 'danger');
                    }
                } catch (e) {
                    showAlert('Error al procesar la respuesta del servidor.', 'danger');
                }
            }, function(error) {
                showAlert('Error al eliminar la prenda', 'danger');
            });
        }
    };

    // Función para renderizar una fila de la tabla de prendas
    function renderPrendaRow(prenda) {
        return `
            <tr>
                <td>${prenda.id}</td>
                <td>${prenda.nombre}</td>
                <td>${prenda.talla}</td>
                <td>${prenda.cantidad_stock}</td>
                <td>${prenda.marca_id}</td>
                <td>
                    <button class="btn btn-primary btn-sm" onclick="editPrenda(${prenda.id}, '${prenda.nombre}', '${prenda.talla}', ${prenda.cantidad_stock}, ${prenda.marca_id})">Editar</button>
                    <button class="btn btn-danger btn-sm" onclick="deletePrenda(${prenda.id})">Eliminar</button>
                </td>
            </tr>
        `;
    }

    // Función para preparar el formulario para editar una prenda
    window.editPrenda = function(id, nombre, talla, cantidad_stock, marca_id) {
        console.log('Editando prenda:', { id, nombre, talla, cantidad_stock, marca_id });
        $('#prendaId').val(id);
        $('#prendaNombre').val(nombre);
        $('#prendaTalla').val(talla);
        $('#prendaCantidadStock').val(cantidad_stock);
        $('#prendaMarcaId').val(marca_id).prop('disabled', true); // Deshabilitar el campo Marca ID
        $('#modalTitle').text('Actualizar Prenda');
        $('#prendaModal').modal('show');
    };

    // Código para habilitar el campo Marca ID al agregar una nueva prenda
    $('#prendaForm').on('reset', function() {
        $('#prendaMarcaId').prop('disabled', false); // Habilitar el campo Marca ID
    });

    // Función para realizar solicitudes AJAX
    function ajaxRequest(method, url, data, successCallback, errorCallback) {
        $.ajax({
            type: method,
            url: url,
            data: JSON.stringify(data),
            contentType: 'application/json',
            success: successCallback,
            error: function(xhr, status, error) {
                const errorMessage = `Error: ${status} - ${error}`;
                showAlert(errorMessage, 'danger');
            }
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
});
