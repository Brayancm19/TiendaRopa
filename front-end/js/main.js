// Función para realizar una petición AJAX
function ajaxRequest(method, url, data, successCallback, errorCallback) {
    $.ajax({
        type: method,
        url: url,
        data: JSON.stringify(data),
        contentType: "application/json",
        success: function(response) {
            successCallback(response);
        },
        error: function(error) {
            if (errorCallback) {
                errorCallback(error);
            } else {
                console.log("Error:", error);
            }
        }
    });
}

// Función para mostrar un mensaje de alerta
function showAlert(message, type) {
    const alertBox = $('<div class="alert alert-' + type + ' alert-dismissible" role="alert">' + message + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
    $(".container").prepend(alertBox);
    setTimeout(function() {
        alertBox.alert('close');
    }, 3000);
}

// Función para limpiar los campos del formulario
function clearForm(formId) {
    $(formId)[0].reset();
    $(formId).find("input[type=hidden]").val('');
}

// Función para preparar el formulario para agregar una nueva entrada
function prepareAddForm(formId, formTitleId, formTitle) {
    clearForm(formId);
    $(formTitleId).text(formTitle);
    $(formId + ' button[type=submit]').text('Guardar');
    $(formId + ' #cancelButton').hide();
}

// Función para preparar el formulario para actualizar una entrada
function prepareUpdateForm(formId, formTitleId, formTitle, data) {
    clearForm(formId);
    $(formTitleId).text(formTitle);
    for (const key in data) {
        $(formId + ' #' + key).val(data[key]);
    }
    $(formId + ' button[type=submit]').text('Actualizar');
    $(formId + ' #cancelButton').show();
}

// Función para llenar una tabla con datos
function populateTable(tableBodyId, data, rowRenderer) {
    const tableBody = $(tableBodyId);
    tableBody.empty();

    if (!Array.isArray(data)) {
        console.error("Data is not an array:", data);
        return;
    }

    data.forEach(function(item) {
        const row = rowRenderer(item);
        tableBody.append(row);
    });
}
