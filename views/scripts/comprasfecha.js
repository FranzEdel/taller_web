var tabla;

// Funcion que se ejecua al inicio
function init() {
    listar($('#fecha_inicio').val(),$('#fecha_fin').val());
}  
$('#fecha_inicio').change(function(){
    var fecha_inicio = $(this).val();
    var fecha_fin = $('#fecha_fin').val();
    listar(fecha_inicio,fecha_fin);
});

$('#fecha_fin').change(function(){
    var fecha_fin = $(this).val();
    var fecha_inicio = $('#fecha_inicio').val();
    listar(fecha_inicio,fecha_fin);
});
  

function listar(fecha_inicio,fecha_fin) {

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