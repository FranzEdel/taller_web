var tabla;

// Funcion que se ejecua al inicio
function init() {
    mostrarForm(false);
    listar();

    $("#formulario").on("submit", function(e) {
        guardaryeditar(e);
    });

    //Cargamos los items al select categoria
    $.post("../controllers/ArticuloController.php?op=selectCategoria", function(r) {
        $('#idcategoria').html(r);
        $('#idcategoria').selectpicker('refresh');
    });

    $('#imagenmuestra').hide();
}

//Funcion limpiar
function limpiar() {
    $("#idcategoria").val("");
    $("#idarticulo").val("");
    $('#idcategoria').selectpicker('refresh');
    $("#nombre").val("");
    $("#codigo").val("");
    $("#stock").val("");
    $("#descripcion").val("");

    $("#imagen").val("");
    $("#imagenactual").val("");
    $("#imagenmuestra").attr("src", "");

    $('#print').hide();
}

function mostrarForm(flag) {
    limpiar();
    if (flag) {
        $("#listado").hide();
        $("#formularioregistros").show();
        $("#btnGuardar").prop("disabled", false);
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
            url: '../controllers/ArticuloController.php?op=listar',
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
        url: "../controllers/ArticuloController.php?op=insertaryeditar",
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

function mostrar(idarticulo) {
    $.post("../controllers/ArticuloController.php?op=mostrar", { idarticulo: idarticulo }, function(data, status) {
        data = JSON.parse(data);
        mostrarForm(true);

        $("#idarticulo").val(data.idarticulo);

        $("#idcategoria").val(data.idcategoria);
        $("#idcategoria").selectpicker("refresh");

        $("#codigo").val(data.codigo);
        $("#nombre").val(data.nombre);
        $("#stock").val(data.stock);
        $("#descripcion").val(data.descripcion);

        $("#imagenmuestra").show();
        $("#imagenmuestra").attr("src", "../files/articulos/" + data.imagen);
        $("#imagenactual").val(data.imagen);

        generarbarcode()
    });
}

function desactivar(idarticulo) {
    bootbox.confirm("¿Esta seguro de Desactivar el Articulo..?", function(result) {
        if (result) {
            $.post("../controllers/ArticuloController.php?op=desactivar", { idarticulo: idarticulo }, function(e) {
                bootbox.alert(e);
                $("#tblistado").DataTable().ajax.reload();
            });
        }
    });
}


function activar(idarticulo) {
    bootbox.confirm("¿Esta seguro de Activar el Articulo..?", function(result) {
        if (result) {
            $.post("../controllers/ArticuloController.php?op=activar", { idarticulo: idarticulo }, function(e) {
                bootbox.alert(e);
                $("#tblistado").DataTable().ajax.reload();
            });
        }
    });
}

function generarbarcode() {
    codigo = $('#codigo').val()
    JsBarcode('#barcode', codigo);
    $('#print').show();
}

function imprimir() {
    $('#print').printArea();
}

init();