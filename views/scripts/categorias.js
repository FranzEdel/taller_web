var tabla;

// Funcion que se ejecua al inicio
function init() {
    mostrarForm(false);
    listar();

    $("#formulario").on("submit", function(e) {
        guardaryeditar(e);
    });
}

//Funcion limpiar
function limpiar() {
    $("#idcategoria").val("");
    $("#nombre").val("");
    $("#descripcion").val("");
}

function mostrarForm(flag) {
    limpiar();
    if (flag) {
        $("#listado").hide();
        $("#formularioregistros").show();
        //$("#btnGuardar").prop("disabled", false);
    } else {
        $("#listado").show();
        $("#formularioregistros").hide();
    }
}

function cancelarForm() {
    limpiar();
    mostrarForm(false);
}

function listar() {
    tabla = $('#tblistado').dataTable({
        "aProcessing": true, //activa el dataTable
        "aServerSide": true, // Paginacion y filtrado
        dom: "Bfrtip", // Elementos de control
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdf'
        ],
        "ajax": {
            url: '../controllers/CategoriaController.php?op=listar',
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

function guardaryeditar(e) {
    e.preventDefault(); //No se activa la accion predeterminada del evento
    $("#btnGuardar").prop("disabled", true);
    var formData = new FormData($("#formulario")[0]);

    $.ajax({
        url: "../controllers/CategoriaController.php?op=insertaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function(datos) {
            bootbox.alert(datos);
            mostrarForm(false);
            $("#tblistado").DataTable().ajax.reload();
        }
    });
}

init();