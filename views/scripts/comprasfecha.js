var tabla;

// Funcion que se ejecua al inicio
function init() {
    listar();
    $('#fecha_inicio').change(listar());
    $('#fecha_fin').change(listar());
}  

function listar() {
    var fecha_inicio = $('#fecha_inicio').val();
    var fecha_fin = $('#fecha_fin').val();   

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
            url: '../controllers/ConsultasController.php?op=comprasFecha',
            data: {fecha_inicio:fecha_inicio, fecha_fin:fecha_fin},
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