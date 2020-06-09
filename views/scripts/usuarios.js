var tabla;

// Funcion que se ejecutara al inicio
function init() {
    mostrarForm(false);
    listar();

    $("#formulario").on("submit", function(e) {
        guardaryeditar(e);
    });

    $('#imagenmuestra').hide();

    //Mostrar los permisos
    $.post("../controllers/UsuarioController.php?op=permisos&id=", function(r) {
        $("#permisos").html(r);
    });
}

// Funcion limpiar
function limpiar() {
    $("#idusuario").val("");
    $("#nombre").val("");
    $("#num_documento").val("");
    $("#telefono").val("");
    $("#direccion").val("");
    $("#email").val("");
    $("#cargo").val("");
    $("#login").val("");
    $("#clave").val("");

    $("#imagen").val("");
    $("#imagenactual").val("");
    $("#imagenmuestra").attr("src", "");

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
            url: '../controllers/UsuarioController.php?op=listar',
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
        url: "../controllers/UsuarioController.php?op=guardaryeditar",
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

function mostrar(idusuario) {
    $.post("../controllers/UsuarioController.php?op=mostrar", { idusuario: idusuario }, function(data, status) {
        data = JSON.parse(data);
        mostrarForm(true);

        $("#idusuario").val(data.idusuario);
        $("#nombre").val(data.nombre);

        $("#tipo_documento").val(data.tipo_documento);
        $("#tipo_documento").selectpicker('refresh');

        $("#num_documento").val(data.num_documento);
        $("#telefono").val(data.telefono);
        $("#direccion").val(data.direccion);
        $("#email").val(data.email);
        $("#cargo").val(data.cargo);
        $("#login").val(data.login);
        $("#clave").val(data.clave);

        $("#imagenmuestra").show();
        $("#imagenmuestra").attr("src", "../files/usuarios/" + data.imagen);
        $("#imagenactual").val(data.imagen);

    });
    $.post("../controllers/UsuarioController.php?op=permisos&id=" + idusuario, function(r) {
        $("#permisos").html(r);
    });
}

// Funcion para desactivar registros
function desactivar(idusuario) {
    bootbox.confirm("¿Está seguro de desactivar el Usuario..?", function(result) {
        if (result) {
            $.post("../controllers/UsuarioController.php?op=desactivar", { idusuario: idusuario }, function(e) {
                bootbox.alert(e);
                $('#tblistado').DataTable().ajax.reload();
            });
        }
    });
}

// Funcion para activar registros
function activar(idusuario) {
    bootbox.confirm("¿Está seguro de activar el Usuario..?", function(result) {
        if (result) {
            $.post("../controllers/UsuarioController.php?op=activar", { idusuario: idusuario }, function(e) {
                bootbox.alert(e);
                $('#tblistado').DataTable().ajax.reload();
            });
        }
    });
}

init();