var tabla;

// Funcion que se ejecutara al inicio
function init() {
    mostrarForm(false);
    listar();

    $("#formulario").on("submit", function(e) {
        guardaryeditar(e);
    });
}

// Funcion limpiar
function limpiar() {
    $("#idpersona").val("");
    $("#nombre").val("");
    $("#num_documento").val("");
    $("#direccion").val("");
    $("#telefono").val("");
    $("#email").val("");
    $("#tipo_documento").selectpicker('refresh');
}

// Funcion mostrar formulario
function mostrarForm(flag) {
    limpiar();
    if (flag) {
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#btnGuardar").prop("disabled", false);
    } else {
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
    }
}

// Funcion cancelarform
function cancelarForm() {
    limpiar();
    mostrarForm(false);
}

// funcion listar
function listar() {
    tabla = $('#tblistado').dataTable({
        "aProcessing": true, //Activamos el procesamiento del datatables
        "aServerSide": true, //Paginacion y filtrado realizados por el servidor
        dom: "Bfrtip", //definimos los elementos del control de tabla
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdf'
        ],
        "ajax": {
            url: '../controllers/PersonaController.php?op=listarp',
            type: 'get',
            dataType: 'json',
            error: function(e) {
                console.log(e.responseText);
            }
        },
        "bDestroy": true,
        "iDisplayLength": 5, //Paginacion
        "order": [
            [0, "desc"]
        ]
    }).dataTable();
}

// Funcion para guardar y editar
function guardaryeditar(e) {
    e.preventDefault(); // No se activa la accion predeterminada del evento
    $("#btnGuardar").prop("disabled", true);
    var formData = new FormData($("#formulario")[0]);

    $.ajax({
        url: "../controllers/PersonaController.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function(datos) {
            bootbox.alert(datos);
            mostrarForm(false);
            $('#tblistado').DataTable().ajax.reload();
        }
    });
    limpiar();
}

function mostrar(idpersona) {
    $.post("../controllers/PersonaController.php?op=mostrar", { idpersona: idpersona }, function(data, status) {
        data = JSON.parse(data);
        mostrarForm(true);

        $("#idpersona").val(data.idpersona);
        $("#nombre").val(data.nombre);

        $("#tipo_documento").val(data.tipo_documento);
        $("#tipo_documento").selectpicker('refresh');

        $("#num_documento").val(data.num_documento);
        $("#direccion").val(data.direccion);
        $("#telefono").val(data.telefono);
        $("#email").val(data.email);

    });
}

// Funcion para eliminar registros
function eliminar(idpersona) {
    bootbox.confirm("¿Está seguro de eliminar el Proveedor..?", function(result) {
        if (result) {
            $.post("../controllers/PersonaController.php?op=eliminar", { idpersona: idpersona }, function(e) {
                bootbox.alert(e);
                $('#tblistado').DataTable().ajax.reload();
            });
        }
    });
}

init();