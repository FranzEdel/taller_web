var tabla;

// Funcion que se ejecua al inicio
function init() {
    listar();
}

//Funcion limpiar
function limpiar() {
    $("#idcategoria").val("");
    $("#nombre").val("");
    $("#descripcion").val("");
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

init();