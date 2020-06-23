$('#frmAcceso').on('submit', function(e){
    e.preventDefault();
    logina = $('#logina').val();
    clavea = $('#clavea').val();

    $.post("../controllers/UsuarioController.php?op=verificar",{"logina":logina,"clavea":clavea},function(data){
        if(data != "null")
        {
            $(location).attr('href','escritorio.php');
            //bootbox.alert('OK');
            //console.log(data);
        } else {
            console.log(data);
            bootbox.alert('Usuario y/o Password incorrectos');
        }
    });
})