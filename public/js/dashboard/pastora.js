/**

 *

 *

 */

function formActions(block)

{

    $('input, select, button, a, textarea, checkbox').each(function () {

        $(this).attr('disabled', block);

    });

}



/**

 *

 *

 */

function blockForm()

{

    formActions(true);

}



/**

 *

 *

 */

function unblockForm()

{

    formActions(false);

}

/**
 *
 * @param message string. Contains the message to display
 */
function modalMessage(message)
{
    bootbox.alert(message, function () {});
}

/**
 *
 * @param errors array
 */
function modalErrors(errors)
{
    var message;

    message = "<h4>¡Error!</h4><p>Haz cometido los siguientes errores:</p><ul>";



    for(var k in errors){

        message += "<li>" + errors[k] + "</li>";

    }



    message += "</ul>";

    modalMessage(message);
}

/**
 *
 * @type {{sProcessing: string, sLengthMenu: string, sZeroRecords: string, sEmptyTable: string, sInfo: string, sInfoEmpty: string, sInfoFiltered: string, sInfoPostFix: string, sSearch: string, sUrl: string, sInfoThousands: string, sLoadingRecords: string, oPaginate: {sFirst: string, sLast: string, sNext: string, sPrevious: string}, oAria: {sSortAscending: string, sSortDescending: string}}}
 */
var datatTableSpanish = {
    "sProcessing":     "Procesando...",
    "sLengthMenu":     "Mostrar _MENU_ registros",
    "sZeroRecords":    "No se encontraron resultados",
    "sEmptyTable":     "Ningún dato disponible en esta tabla",
    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
    "sInfoPostFix":    "",
    "sSearch":         "Buscar:",
    "sUrl":            "",
    "sInfoThousands":  ",",
    "sLoadingRecords": "Cargando...",
    "oPaginate": {
        "sFirst":    "Primero",
        "sLast":     "Último",
        "sNext":     "Siguiente",
        "sPrevious": "Anterior"
    },
    "oAria": {
        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
    }
}
