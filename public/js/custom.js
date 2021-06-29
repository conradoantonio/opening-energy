/*Set configurations when dom is ready*/
$(function() {

});

/*Jquery events*/
//Modal details
$('body').delegate('.info-row', 'click', function() {
    id = $(this).data('row-id');
    url = $('div.general-info').data('url');
    var config = {
        "id"        : id,
        "modal_id"  : "modal-info",
        "route"     : url.concat('/show-info'),
        "callback"  : 'loadInfo',
        "keepModal" : true,
    }
    
    loadingMessage('Espere un momento porfavor...');

    ajaxSimple(config);
});

//Verify if the button for delete multiple can be clickable
$('body').delegate('.check-multiple','click', function() {
    if ( $(this).is(':checked') ) {
        id_rows.push($(this).data('row-id'));
    } else {
        var index = id_rows.indexOf($(this).data('row-id'));
        if ( index > -1 ) {
          id_rows.splice(index, 1);
        }
    }

    $('.delete-content').attr('disabled', id_rows.length > 0 ? false : true);
    
    if ( id_rows.length > 0 ) {
        $('.delete-content, .save-list, .generate-report, .new-history-expo').removeClass('disabled');
    } else {
        $('.delete-content, .save-list, .generate-report, .new-history-expo').addClass('disabled');
    }

    $('.counter').text(id_rows.length);
});

//Checa si el campo de 
$('body').delegate('select[name=id_status_pago]','click', function() {
    //Pagada en n%
    if ( $(this).val() == 3 ) {
        $('input[name=porcentaje_compartido]').parent().removeClass('d-none');
        $('input[name=porcentaje_compartido]').addClass('not-empty');
    } else {
        $('input[name=porcentaje_compartido]').parent().addClass('d-none');
        $('input[name=porcentaje_compartido]').removeClass('not-empty');
    }
});

//Si se trata de una edición, deben solitarse el número de obras a crear, en caso contrario sólo será una
$('select[name=id_tipo_edicion]').change(function() {
    if ( $(this).val() == '1' ) {
        /*Edición: Se van a mostrar los campos número de ediciones, prefijo (ap) y número de ediciones para el AP*/
        $('input[name=total_ediciones]').parent().removeClass('d-none');
        $('input[name=total_ediciones]').addClass('not-empty');
        $('input[name=total_ediciones_prefijo]').parent().removeClass('d-none');
        $('input[name=total_ediciones_prefijo]').addClass('not-empty');
        $('input[name=prefijo_extra]').parent().removeClass('d-none');
        $('input[name=prefijo_extra]').addClass('not-empty');
    } else {
        /*ÚnicaSe van a ocultar los campos número de ediciones, prefijo (ap) y número de ediciones para el AP*/
        $('input[name=total_ediciones]').parent().addClass('d-none');
        $('input[name=total_ediciones]').removeClass('not-empty');
        $('input[name=total_ediciones_prefijo]').parent().addClass('d-none');
        $('input[name=total_ediciones_prefijo]').removeClass('not-empty');
        $('input[name=prefijo_extra]').parent().addClass('d-none');
        $('input[name=prefijo_extra]').removeClass('not-empty');
    }
});

//Si se trata de una edición, deben solitarse el número de obras a crear, en caso contrario sólo será una
$('select[name=id_tipo_dimension]').change(function() {
    if ( $(this).val() == 4 ) {//Nota
        $('input[name=dimension_alto], input[name=dimension_largo], input[name=dimension_profundo]').removeClass('not-empty');
        $('input[name=dimension_alto], input[name=dimension_largo], input[name=dimension_profundo]').parent().addClass('d-none');

        $('input[name=dimension_nota]').addClass('not-empty');
        $('input[name=dimension_nota]').parent().removeClass('d-none');
    } else if( $(this).val() == 0 ) {//Reset select
        $('input[name=dimension_alto], input[name=dimension_largo], input[name=dimension_profundo], input[name=dimension_nota]').removeClass('not-empty');
        $('input[name=dimension_alto], input[name=dimension_largo], input[name=dimension_profundo], input[name=dimension_nota]').parent().addClass('d-none');
    } else {//Dimensiones normales
        $('input[name=dimension_nota]').removeClass('not-empty');
        $('input[name=dimension_nota]').parent().addClass('d-none');

        $('input[name=dimension_alto], input[name=dimension_largo], input[name=dimension_profundo]').addClass('not-empty');
        $('input[name=dimension_alto], input[name=dimension_largo], input[name=dimension_profundo]').parent().removeClass('d-none');
    }
});

/*Functions*/
//Checa si el contacto debe ser guardado por nombre o institución
function verifyShowBySelect(val) {
    if ( val == "nombre") {
        $('input[name=nombre], input[name=apellido]').addClass('not-empty');
        $('input[name=institucion]').removeClass('not-empty');
    } else if ( val == "institucion" ) {
        $('input[name=institucion]').addClass('not-empty');
        $('input[name=nombre], input[name=apellido]').removeClass('not-empty');
    }
}
//Revisa si el número de ediciones debe mostrarse si se trata de un nuevo registro
function verifyEditionTypeSelect(val = "New", id_tipo_dimension = null) {
    if ( val == "New") {
        $('select[name=id_tipo_edicion]').addClass('not-empty');
        $('select[name=id_tipo_edicion]').parent().removeClass('d-none');
        $('input[name=total_ediciones]').removeClass('not-empty');
        $('input[name=total_ediciones]').parent().addClass('d-none');
        $('input[name=prefijo_extra]').removeClass('not-empty');
        $('input[name=prefijo_extra]').parent().addClass('d-none');
        $('input[name=total_ediciones_prefijo]').removeClass('not-empty');
        $('input[name=total_ediciones_prefijo]').parent().addClass('d-none');
        //Sólo es informativo cuando está actualizado
        $('input[name=created_at]').parent().addClass('d-none');
        //Campos para las dimensiones
        $('input[name=dimension_alto], input[name=dimension_largo], input[name=dimension_profundo], input[name=dimension_nota]').removeClass('not-empty');
        $('input[name=dimension_alto], input[name=dimension_largo], input[name=dimension_profundo], input[name=dimension_nota]').parent().addClass('d-none');
    } else {
        //Tipo de edición y número de ediciones no son requeridos
        $('select[name=id_tipo_edicion]').parent().addClass('d-none');
        $('input[name=total_ediciones]').parent().addClass('d-none');
        $('input[name=prefijo_extra]').parent().addClass('d-none');
        $('input[name=total_ediciones_prefijo]').parent().addClass('d-none');
        $('select[name=id_tipo_edicion]').removeClass('not-empty');
        $('input[name=total_ediciones]').removeClass('not-empty');
        $('input[name=prefijo_extra]').removeClass('not-empty');
        $('input[name=total_ediciones_prefijo]').removeClass('not-empty');
        //Sólo es informativo cuando está actualizado
        $('input[name=created_at]').parent().removeClass('d-none');
        //Campos para las dimensiones
        if ( id_tipo_dimension == 4 ) {//Nota
            $('input[name=dimension_alto], input[name=dimension_largo], input[name=dimension_profundo]').removeClass('not-empty');
            $('input[name=dimension_alto], input[name=dimension_largo], input[name=dimension_profundo]').parent().addClass('d-none');

            $('input[name=dimension_nota]').addClass('not-empty');
            $('input[name=dimension_nota]').parent().removeClass('d-none');
        } else {//Dimensiones normales
            $('input[name=dimension_nota]').removeClass('not-empty');
            $('input[name=dimension_nota]').parent().addClass('d-none');

            $('input[name=dimension_alto], input[name=dimension_largo], input[name=dimension_profundo]').addClass('not-empty');
            $('input[name=dimension_alto], input[name=dimension_largo], input[name=dimension_profundo]').parent().removeClass('d-none');
        }
    }
}

//Función para setear el contacto
function setContact(contacto) {
    return ( contacto ? ( contacto.mostrar_por == 'nombre' ? contacto.nombre+' '+contacto.apellido : contacto.institucion ) : '' );
}

//Función para setear las dimensiones de la obra
function setDimensions(item) {
    return ( item ? ( item.tipo_dimension && item.tipo_dimension.descripcion == 'nota' ? item.dimension_nota : item.dimension_largo+' x '+item.dimension_alto+' x '+item.dimension_profundo+' '+item.tipo_dimension.descripcion ) : '' );
}

function verifyFinanceFields(val = "New", status_pago = 0) {
    if ( val == "New") {
        $('input[name=porcentaje_compartido]').parent().addClass('d-none');
        $('input[name=porcentaje_compartido]').removeClass('not-empty');
    } else {
        //Pagada en n%
        if ( status_pago == 3 ) {
            $('input[name=porcentaje_compartido]').parent().removeClass('d-none');
            $('input[name=porcentaje_compartido]').addClass('not-empty');
        } else {
            $('input[name=porcentaje_compartido]').parent().addClass('d-none');
            $('input[name=porcentaje_compartido]').removeClass('not-empty');
        }
    }
}

function reloadSelectList(data, config = null) {
    $('select[name=id_listas]').select2('destroy');
    fillSelect(data.data.rows, '[name=id_listas]', 'Lista (Todas)', false, true);
}

function fillSelect(items, target, textFirst = false, disabled = false, select2 = false) {
    $('select'+target).children('option').remove();

    $('select'+target).append('<option value="0" '+(disabled ? 'disabled' : '')+'>'+(textFirst ? textFirst : 'Seleccione una opción')+'</option>');
    
    items.forEach(function (option) {
        $('select'+target).append('<option value="'+option.id+'">'+option.descripcion+'</option>');
    });

    if ( select2 ) {
        $('select'+target).select2();
    }
    //$('.counter').text(items.length);
}

//Fill order data
function loadInfo(response, config) {
    $('div#'+config.modal_id).modal();

    $("table#table-exposiciones tbody").children().remove();
    $("table#table-ofertas tbody").children().remove();
    $('span.status').children().remove();
    $('span.obra_locacioninfo').text("");
    $('span.obra_vendidoinfo').text("");
    $('span.obra_dimensionesInfo').text("");
    $('span.obra_dimensionesInfo, span.obra_vendido_a, span.obra_fecha_venta_formated').text('');
    $('.ul-image-list').addClass('d-none');
    $('.ul-exposiciones').addClass('d-none');
    $('.ul-ofertas').addClass('d-none');
    //General data
    fill_text(response, null, 'obra_');

    if ( response.anio ) {
        $('span.obra_titulo').text(response.titulo+', '+response.anio);
    }

    $('img.obra_imagen_portada').attr('src', baseUrl.concat('/'+response.imagen_portada));

    if ( response.tipo_dimension ) {
        $('span.obra_dimensionesInfo').text(setDimensions(response));
        $('span.obra_dimensionesInfo').parent().parent().removeClass('d-none');
    }

    if ( response.tipo_edicion ) {
        edicion = ( response.tipo_edicion.descripcion == 'Edición' ? 'Edition of '+response.total_ediciones : 'Unique' );

        prefix = ( response.tipo_edicion.descripcion == 'Edición' && response.prefijo ? ' with '+response.total_ediciones_prefijo+' '+response.prefijo+( response.num_edicion ? ' ('+response.num_edicion+'/'+response.total_ediciones+')' : '' ) : '' )
        
        $('.obra_id_tipo_edicion').text(edicion.concat(prefix));
    }

    if ( response.artista ) {
        fill_text(response.artista, null, 'artista_', false);
    }

    if ( response.tipo ) {
        fill_text(response.tipo, null, 'tipo_', false);
    }

    if ( response.subtipo ) {
        fill_text(response.subtipo, null, 'subtipo_', false);
    }

    if ( response.precio ) {
        texto_moneda = '';
        texto_moneda = response.precio;
        if ( response.moneda ) { texto_moneda = response.moneda.simbolo+response.precio+' '+response.moneda.abreviacion; }
        $('span.obra_precio_custom').text(texto_moneda);
        $('span.obra_precio_custom').parent().parent().removeClass('d-none');
    }

    if ( response.costo_empaque ) {
        texto_moneda = '';
        texto_moneda = response.costo_empaque;
        if ( response.moneda ) { texto_moneda = response.moneda.simbolo+response.costo_empaque+' '+response.moneda.abreviacion; }
        $('span.obra_costo_empaque_custom').text(texto_moneda);
        $('span.obra_costo_empaque_custom').parent().parent().removeClass('d-none');
    }

    if ( response.costo_produccion ) {
        texto_moneda = '';
        texto_moneda = response.costo_produccion;
        if ( response.moneda ) { texto_moneda = response.moneda.simbolo+response.costo_produccion+' '+response.moneda.abreviacion; }
        $('span.obra_costo_produccion_custom').text(texto_moneda);
        $('span.obra_costo_produccion_custom').parent().parent().removeClass('d-none');
    }

    if ( response.costo_seguro ) {
        texto_moneda = '';
        texto_moneda = response.costo_seguro;
        if ( response.moneda ) { texto_moneda = response.moneda.simbolo+response.costo_seguro+' '+response.moneda.abreviacion; }
        $('span.obra_costo_seguro_custom').text(texto_moneda);
        $('span.obra_costo_seguro_custom').parent().parent().removeClass('d-none');
    }

    if ( response.status ) {
        $('span.status').parent().parent().removeClass('d-none');
        $('span.status').append('<span class="badge badge-soft-'+response.status.class+'">'+response.status.descripcion+'</span>'); 
    }

    if ( response.locacion_info ) {
        $('span.obra_locacioninfo').parent().parent().removeClass('d-none');
        $('span.obra_locacioninfo').append(setContact(response.locacion_info)); 
    }

    if ( response.vendido ) {
        $('span.obra_vendidoinfo').parent().parent().removeClass('d-none');
        $('span.obra_vendidoinfo').append(setContact(response.vendido)); 
    }

    //Imágenes
    if ( response.imagenes.length ) {
        $('.ul-image-list .image-list').children().remove();
        $('.ul-image-list').removeClass('d-none');
        items = response.imagenes;
        for ( var key in items ) {
            if ( items.hasOwnProperty( key ) ) {
                $('.ul-image-list .image-list').append(
                    '<div class="col-md-4 text-center" id="id_detail'+items[key].id+'">'+
                        '<a href="'+items[key].imagen+'" class=""><img src="'+baseUrl.concat('/'+items[key].imagen)+'" class="img-thumbnail property-img" alt="Imágen num. '+( parseFloat(key) + 1 )+'" /></a>'+
                        ( userRole != 'Invitado' ? '<button class="btn btn-danger m-b-15 btn-sm detele-row-detail" data-url="/obras/delete-content" data-parent="div.image-list" data-row-id="'+items[key].id+'" data-row-descripcion="'+items[key].id+'" data-toggle="tooltip" data-placement="top" title="Eliminar"><i class="mdi mdi-trash-can"></i></button>' : '' ) +
                    '</div>'
                )
            }
        }
    }

    //Historial de exposiciones
    if ( response.historial_exposiciones.length ) {
        $('.ul-exposiciones').removeClass('d-none');
        items = response.historial_exposiciones;
        for ( var key in items ) {
            if ( items.hasOwnProperty( key ) ) {
                $("table#table-exposiciones tbody").append(
                    '<tr class="" id="id_detail'+items[key].pivot.id+'">'+
                        '<td class="table-bordered">'+items[key].descripcion+'</td>'+
                        '<td class="table-bordered">'+( items[key].created_at_formated )+'</td>'+
                        ( userRole != 'Invitado' ? '<td class="table-bordered"><button class="btn btn-danger btn-sm detele-row-detail" data-url="/historial-exposiciones/delete-detail" data-parent="table#table-exposiciones" data-row-id="'+items[key].pivot.id+'" data-row-descripcion="'+items[key].descripcion+'" data-toggle="tooltip" data-placement="top" title="Eliminar"><i class="mdi mdi-trash-can"></i></button></td>' : '' ) +
                    '</tr>'
                );
            }
        }
    }

    //Lista de ofertados
    if ( response.ofertas.length ) {
        $('.ul-ofertas').removeClass('d-none');
        items = response.ofertas;
        for ( var key in items ) {
            if ( items.hasOwnProperty( key ) ) {
                contacto = setContact(items[key].ofertado);
                $("table#table-ofertas tbody").append(
                    '<tr class="" id="id_detail'+items[key].id+'">'+
                        '<td class="table-bordered">'+contacto+'</td>'+
                        '<td class="table-bordered">'+( items[key].created_at_formated )+'</td>'+
                        ( userRole != 'Invitado' ? '<td class="table-bordered"><button class="btn btn-danger btn-sm detele-row-detail" data-url="/ofertas/delete" data-parent="table#table-ofertas" data-row-id="'+items[key].id+'" data-row-descripcion="'+contacto+'" data-toggle="tooltip" data-placement="top" title="Eliminar"><i class="mdi mdi-trash-can"></i></button></td>' : '' ) +
                    '</tr>'
                );
            }
        }
    }
}
