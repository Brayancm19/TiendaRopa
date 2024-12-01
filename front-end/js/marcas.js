$(document).ready(function() {
    // Cargar todas las marcas al cargar la página
    loadMarcas();

    // Manejar el formulario de marcas
    $('#marcaForm').submit(function(event) {
        event.preventDefault();
        const id = $('#marcaId').val();
        const nombre = $('#marcaNombre').val();
        console.log('Formulario enviado:', { id, nombre });
        if (id) {
            updateMarca(id, nombre);
        } else {
            createMarca(nombre);
        }
        $('#marcaModal').modal('hide'); // Cerrar el modal después de enviar
    });

    // Función para cargar todas las marcas
    function loadMarcas() {
        ajaxRequest('GET', 'php/marcas.php', null, function(response) {
            const marcas = JSON.parse(response);
            populateTable('#marcasTableBody', marcas, renderMarcaRow);
        });
    }

    // Función para crear una nueva marca
    function createMarca(nombre) {
        console.log('Creando marca:', nombre);
        const data = { nombre: nombre };
        ajaxRequest('POST', 'php/marcas.php', data, function(response) {
            console.log('Respuesta del servidor:', response);
            showAlert('Marca creada exitosamente', 'success');
            loadMarcas(); // Asegurarse de recargar las marcas después de crear una nueva
        }, function(error) {
            showAlert('Error al crear la marca', 'danger');
        });
    }

    // Función para actualizar una marca existente
    function updateMarca(id, nombre) {
        console.log('Actualizando marca:', { id, nombre });
        const data = { id: id, nombre: nombre };
        ajaxRequest('PUT', 'php/marcas.php', data, function(response) {
            console.log('Respuesta del servidor:', response);
            showAlert('Marca actualizada exitosamente', 'success');
            loadMarcas(); // Asegurarse de recargar las marcas después de actualizar
        }, function(error) {
            showAlert('Error al actualizar la marca', 'danger');
        });
    }

    // Función para eliminar una marca
    window.deleteMarca = function(id) {
        console.log('Eliminando marca:', id);
        if (confirm('¿Estás seguro de que deseas eliminar esta marca?')) {
            const data = { id: id };
            ajaxRequest('DELETE', 'php/marcas.php', data, function(response) {
                console.log('Respuesta del servidor:', response);
                showAlert('Marca eliminada exitosamente', 'success');
                loadMarcas();
            }, function(error) {
                showAlert('Error al eliminar la marca', 'danger');
            });
        }
    };

    // Función para renderizar una fila de la tabla de marcas
    function renderMarcaRow(marca) {
        return `
            <tr>
                <td>${marca.id}</td>
                <td>${marca.nombre}</td>
                <td>
                    <button class="btn btn-primary btn-sm" onclick="editMarca(${marca.id}, '${marca.nombre}')">Editar</button>
                    <button class="btn btn-danger btn-sm" onclick="deleteMarca(${marca.id})">Eliminar</button>
                </td>
            </tr>
        `;
    }

    // Función para preparar el formulario para editar una marca
    window.editMarca = function(id, nombre) {
        console.log('Editando marca:', { id, nombre });
        $('#marcaId').val(id);
        $('#marcaNombre').val(nombre);
        $('#modalTitle').text('Actualizar Marca');
        $('#marcaModal').modal('show');
    };
});
