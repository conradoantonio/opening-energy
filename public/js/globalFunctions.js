var refreshModal = true;
$(function() {
    $.blockUI.defaults.css = {
        padding:        "15px",
        margin:         0,
        width:          'auto',
        top:            '50%',
        left:           '50%',
        textAlign:      'center',
        color:          'inherit',
        border:         '1px solid #aaa',
        backgroundColor:'#fff',
        cursor:         'wait',
        borderRadius:   '0.25rem',
    };

    $(".select-special").each(function() {
        parent = $(this).data('parent');
        $(this).select2({
            dropdownParent: $('div'+parent)
        });
    });

    //Set up the ajax to include csrf token on header
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    //Fade in the containers
    setTimeout(function() {
        $('div.content-container, div.rows-container, div.row-fluid, div.form-container').fadeIn('low');
    }, 500);

    $('.data-table').DataTable({
        //DataTable Options
        colReorder: true,
        "aaSorting" : [],
    });

    /*toastr.options = {
        "positionClass": "toast-bottom-right",
    }*/

    //Verify if the button for delete multiple can be clickable
    $('body').delegate('.checkMultiple','click', function() {
        var ids_lenght = [];
        $("input.checkMultiple").each(function() {
            if ($(this).is(':checked')) {
                ids_lenght.push($(this).parent().parent().siblings("td:nth-child(2)").text());
            }
        });

        $('.delete-rows, .reject-rows, .disable-rows, .enable-rows').attr('disabled', ids_lenght.length > 0 ? false : true);
    });

    //Set up the tooltip element
    $('body').tooltip({
        selector: '[data-toggle=tooltip]'
    });

    //Set up the select 2 inputs
    $("select.select2").select2({
    });

    //Set up the timepicker inputs
    $(".timepicker").timepicker({
        showInputs: false,
        //defaultTime: false
    });

     //Set up the clockpicker inputs
    /*$('.clockpicker ').clockpicker({
        autoclose: true
    });*/

    $('.gallery').each(function() { // the containers for all your galleries
        $(this).magnificPopup({
            delegate: 'a', // the selector for gallery item
            type: 'image',
            removalDelay: 300,
            enableEscapeKey : false,
            gallery: {
              enabled:true
            }
        });
    });
    //$('.popup-image').magnificPopup({type:'image'});

    //Set up the datepiciker inputs
    $( ".date-picker" ).datepicker({
        autoclose: true,
        todayHighlight: true,
        format: "yyyy-mm-dd",
    });

    $('body').delegate('.refresh-content','click', function() {
        var url = $('div.general-info').data('url');
        var refresh = $('div.general-info').data('refresh');
        var element = $('div.general-info').data('el-loader');

        var config = {
            "element"         : element,
            "refresh"         : refresh,
            "method"          : 'get',
            "container_class" : "rows-container",
            "table_class"     : "data-table",
            "route"           : url,
            "callback"        : "fill_table",
        }

        blockElement(config);
        refreshTable(url);
        unBlockElement();
    });

    $('.cstm-switch-input').change(function() {
        id = $(this).data('row-id');
        el_class = 'checkbox'+$(this).data('row-id');
        url = $('div.general-info').data('url');
        
        var config = {
            "id"        : id,
            "activo"    : $(this).is(":checked") ? 1 : 0,
            "route"     : url.concat('/change-status'),
            "callback"  : 'checkbox_listener',
            "el_class"  : el_class,
        }

        $('.'+el_class).parent().parent().block({
            message:''
        });
        
        ajaxSimple(config);
    });

    //Open a modal in a form for a new row
    $('body').delegate('.new-row', 'click', function() {
        var route = $('div.general-info').data('url');
        var target = $(this).data('target');
        var callback = $(this).data('callback');
        if ( callback ) { /*console.warn(callback);*/ window[callback](); }
        $('div'+target+' img').attr('src', baseUrl.concat('/img/no-image.png'));
        $('div'+target+' form').get(0).setAttribute('action', route.concat('/save'));
        $('div'+target).modal();
    });

    $('body').delegate('.new-row2', 'click', function() {
        var route = $('div.general-info').data('url');
        var target = $(this).data('target');
        var callback = $(this).data('callback');
        if ( callback ) { /*console.warn(callback);*/ window[callback](); }
        $(target).find("#password").addClass("not-empty");
        $('div'+target+' img').attr('src', baseUrl.concat('/img/no-image.png'));
        $('div'+target+' form').get(0).setAttribute('action', route.concat('/save'));
        $('div'+target).modal();
    });

    //Set up the button to download the excel file
    $('body').delegate('.export-rows', 'click', function() {
        var url = $('div.general-info').data('url')+'/excel/export?';
        var config = {
            "container_id" : "rows-container",
            "table_class"  : "data-table",
            "route"        : url.concat('/filter'),
            "callback"     : "fillTable",
        }

        var filters = $('div.filter-section');

        filters.find('input, select, textarea').each(function(i,e) {
            val = $(this).val();
            name = $(this).attr('name');
            console.log(name,val);

            /*Atribute name must exist*/
            if ( name !== undefined ) {
                if ( i == 0 ) {//First iteration
                    url = url.concat(name+'='+val);
                } else {
                    url = url.concat('&'+name+'='+val);
                }
            }
        });
        window.location.href = url;
    });

    //Configure the modal and form properties to upload files
    $('body').delegate('.upload-content','click', function() {
        var row_id = $(this).data('row-id');
        var path = $(this).data('path');
        var rename = $(this).data('rename');
        var resize = $(this).data('resize');
        var action = $(this).data('route-action');

        //console.info('Ruta: '+path, '\nRenombrar: '+rename, '\nDimensiones: '+resize, '\nRuta: '+action);
        var myDropzone = Dropzone.forElement(".myDropzone");

        if (typeof $(this).data('resize') !== 'undefined') {
            $('#rule-container').find('p').removeClass('d-none');
            $('#rule-container').children('p').find('strong').text(resize.width+'x'+resize.height+ ' px');
        }

        myDropzone.options.url = action;
        console.log(row_id);
        $('form#dropzone-form').find('input#row_id').val(row_id);
        $('form#dropzone-form').find('input#path').val(path);
        $('form#dropzone-form').find('input#rename').val(rename);
        $('form#dropzone-form').find('input#resize').val(JSON.stringify(resize));
        /*myDropzone.on("queuecomplete", function(file) {
            if (typeof $('button.upload-content').data('refresh') !== 'undefined') {
                refreshGalery(window.location.href)
            }
        });*/
    });

    //Configure the modal to clean the files and reload the galery if neccesary when this is closed by the user
    $('body').delegate('div#modal-upload-content','hidden.bs.modal', function() {
        var myDropzone = Dropzone.forElement(".myDropzone");
        var route = $('.upload-content').data('reload-url') ? $('.upload-content').data('reload-url') : $('div.general-info').data('url');
        //First check if files where uploaded, if so, refresh the galery
        if ( typeof $('.upload-content').data('refresh') !== 'undefined' ) {
            if ( myDropzone.files.length > 0 ) {
                if ( $('.upload-content').data('refresh') == 'table' ) {
                    refreshTable( route );
                } else if ( $('.upload-content').data('refresh') == 'content' ) {
                    refreshGalery( route );
                } else if ( $('.upload-content').data('refresh') == 'galery' ) {
                    refreshGalery( route );
                }
            }
        }

        //Clear dropzone files
        myDropzone.removeAllFiles();
        $('#rule-container').find('p').addClass('d-none');
        $(this).find('input.form-control').val('');
    });

    //Configure the modal and form properties to import with excel
    $('body').delegate('.import-excel','click', function() {
        var action = $('div.general-info').data('url')+'/excel/import';
        var fields = $(this).data('fields');
        $('form#form-import').get(0).setAttribute('action', action);
        $('form#form-import').find('strong#fields').text(fields);
    });

    //Clear modal inputs
    $('div.modal').on('hidden.bs.modal', function (e) {
        if (refreshModal) {
            $(this).find('div.form-group').removeClass('has-error');
            $(this).find("input.form-control").val('');
            $(this).find("input.custom-control-input").prop("checked", false);
            $(this).find("textarea.form-control").val('');
            $(this).find("select.form-control").val(0);
            $(this).find("select.select2, select.select-special").select2("val", "0");
        }
        /*$('#foto_perfil').croppie('destroy');
        $('.upload-cr-pic').croppie('destroy');*/
    });

    //Clear button
    $(".clear-filters").on('click',function(){
        $('div.filter-section').find("input.form-control").val('');
        $('div.filter-section').find("select.form-control").val("");
    })

    //Send a request for disable/enable a row
    $('body').delegate('.disable-rows, .enable-rows','click', function() {
        var route = $('div.general-info').data('url')+'/change-status';
        var refresh = $('div.general-info').data('refresh');
        if ($(this).data('text_msg')){//Custom message in swal
            var swal_msg = $(this).data('text_msg');
        } else {
            var swal_msg = change_to == 1 ? 'habilitarán' : 'inhabilitarán';
        }
        var reload_url = $(this).data('reload-url');
        var ids_array = [];
        var change_to = $(this).data('change-to');

        $("input.checkMultiple").each(function() {
            if ($(this).is(':checked')) {
                ids_array.push($(this).parent().parent().siblings("td:nth-child(2)").text());
            }
        });
        if (ids_array.length > 0) {
            swal({
                title: 'Se '+swal_msg+ ' '+ids_array.length+' registro(s), ¿Está seguro de continuar?',
                icon: 'warning',
                buttons:["Cancelar", "Aceptar"],
                dangerMode: true,
            }).then((accept) => {
                if (accept) {
                    config = {
                        'route'     : route,
                        'ids'       : ids_array,
                        'refresh'   : refresh,
                        'change_to' : change_to,
                    }
                    if (reload_url !== undefined) {//If required, we can manipulate the reload url
                        config["reload_url"] = reload_url;
                    }
                    loadingMessage();
                    ajaxSimple(config);
                }
            }).catch(swal.noop);
        }
    });
    

    //Send a request for a single delete
    $('body').delegate('.enable-row, .disable-row','click', function() {
        var route = $('div.general-info').data('url')+'/change-status';
        var refresh = $('div.general-info').data('refresh');
        var ids_array = [];
        var row_id = $(this).hasClass('special-row') ? $(this).data('row-id') : $(this).parent().siblings("td:nth-child(1)").text();
        var row_name = $(this).hasClass('special-row') ? $(this).data('row-name') : $(this).parent().siblings("td:nth-child(2)").text();
        var change_to = $(this).data('change-to');
        var swal_msg = change_to == 1 ? 'habilitado' : 'inhabilitado';
        var reload_url = $(this).data('reload-url');
        ids_array.push(row_id);

        swal({
            title: 'Se marcará el registro '+row_name+' con el status de "'+swal_msg+'" ¿Está seguro de continuar?',
            icon: 'warning',
            buttons:["Cancelar", "Aceptar"],
            dangerMode: true,
        }).then((accept) => {
            if (accept){
                config = {
                    'route'     : route,
                    'ids'       : ids_array,
                    'change_to' : change_to,
                    'refresh'   : refresh,
                }
                if ( reload_url !== undefined ) {//If required, we can manipulate the reload url
                    config["reload_url"] = reload_url;
                }
                loadingMessage();
                ajaxSimple(config);
            }
        }).catch(swal.noop);
    });

    //Send a request for a single delete
    $('body').delegate('.delete-row','click', function() {
        var route = $('div.general-info').data('url')+'/delete';
        var refresh = $('div.general-info').data('refresh');
        var ids_array = [];
        var row_id = $(this).hasClass('special-row') ? $(this).data('row-id') : $(this).parent().siblings("td:nth-child(1)").text();
        ids_array.push(row_id);

        swal({
            title: 'Se dará de baja el registro con el ID '+row_id+', ¿Está seguro de continuar?',
            icon: 'warning',
            buttons:["Cancelar", "Aceptar"],
            dangerMode: true,
        }).then((accept) => {
            if (accept){
                config = {
                    'route'     : route,
                    'ids'       : ids_array,
                    'refresh'   : refresh,
                }
                loadingMessage();
                ajaxSimple(config);
            }
        }).catch(swal.noop);
    });

    //Send a request for delete a galery
    $('body').delegate('.delete-galery','click', function() {
        var route = $('div.general-info').data('url')+'/delete';
        var refresh = $('div.general-info').data('refresh');
        var ids_array = [];
        var row_id = $(this).parent().attr('id');
        ids_array.push(row_id);

        swal({
            title: 'Se eliminará la imagen con el ID '+row_id+', ¿Está seguro de continuar?',
            icon: 'warning',
            buttons:["Cancelar", "Aceptar"],
            dangerMode: true,
        }).then((accept) => {
            if (accept){
                config = {
                    'route'     : route,
                    'ids'       : ids_array,
                    'refresh'   : refresh,
                }
                loadingMessage();
                ajaxSimple(config);
            }
        }).catch(swal.noop);
    });
        
    //Send a request for multiple delete
    $('body').delegate('.delete-rows','click', function() {
        var route = $('div.general-info').data('url')+'/delete';
        var refresh = $('div.general-info').data('refresh');
        var ids_array = [];
        $("input.checkMultiple").each(function() {
            if($(this).is(':checked')) {
                ids_array.push($(this).parent().parent().siblings("td:nth-child(2)").text());
            }
        });
        if (ids_array.length > 0) {
            
            swal({
                title: 'Se dará de baja '+ids_array.length+' registro(s), ¿Está seguro de continuar?',
                icon: 'warning',
                buttons:["Cancelar", "Aceptar"],
                dangerMode: true,
            }).then((accept) => {
                if (accept) {
                    config = {
                        'route'     : route,
                        'ids'       : ids_array,
                        'refresh'   : refresh,
                    }
                    loadingMessage();
                    ajaxSimple(config);
                }
            }).catch(swal.noop);
        }
    });

    //For cancellations
    $('body').delegate('.cancel-row', 'click', function() {
        id = $(this).data('row-id');
        url = $('div.general-info').data('url');
        $('div#modal-cancell-order form input[name=row_id]').val(id);
        $('div#modal-cancell-order').modal();
    });

    //For refund an order
    $('body').delegate('.refund-row', 'click', function() {
        id = $(this).data('row-id');
        url = $('div.general-info').data('url');
        $('div#modal-refund-order form input[name=row_id]').val(id);
        $('div#modal-refund-order').modal();
    });

    //Filter functions
    $('body').delegate('.filter-rows', 'click', function() {
        var url = $('div.general-info').data('url');
        var config = {
            "container_id" : "rows-container",
            "table_class"  : "data-table",
            "route"        : url.concat('/filter'),
            "callback"     : "fillTable",
        }

        var filters = $('div.filter-section');

        filters.find('input, select, textarea').each(function(i,e) {
            name = $(this).attr('name');
            //Name must exist
            if ( name !== undefined ) {
                config[name] = $(this).val();
            }
        });

        loadingMessage();
        ajaxSimple(config);
    });

    //Pusher code, it verifies if is neccesary to reload some page content.
    /*Pusher.logToConsole = false;

    var pusher = new Pusher('899b26aeff40ad874297', {
        cluster: 'us2',
        forceTLS: true
    });

    var channel = pusher.subscribe('refresh-channel');
    channel.bind('refresh-event', function(e) {
        console.log(e);
        if ( e.data.url == window.location.href ) {
            if ( e.data.refresh == 'table' ) {
                refreshTable( e.data.url );
                if ( e.data.toastr ) {
                    toastr.info('Tienes un nuevo pedido por atender');
                }
            } 
            //Maybe add toastr to notify :D
        } else {
            console.info(e.data);
            console.log('There is not any element to reload \nURL:' +e.data.url);
        }
    });*/
});

/*Callback for refresh table*/
function fillTable(response, config)
{
    refreshHtml(response, config.container_id, config.table_class);
    id_rows = [];
    $('.counter').text(id_rows.length);
    $('.delete-content, .save-list, .generate-report, .new-history-expo').addClass('disabled');
}

/*Callback for refresh galery*/
function fillGalery(response, config) 
{
    //Reset array of photos
    id_photos = [];
    $('.delete-content').addClass('disabled');
    refreshGalery(response.url);
}

/*Help to set inputs of a modal form*/
function setForm(row, target, prefix = false) {
    //clear ? $( ".fill-container" ).addClass('hide') : '';
    var keyNames = Object.keys(row);

    for ( var i in keyNames ) {
        propertyName = keyNames[i];
        propertyValue = row[propertyName];
        if ( propertyValue ) {
            elementName = prefix ? prefix + propertyName : propertyName;
            var input = $(target).find('[name='+elementName+']');
            //Element is input or textarea
            //if ( elementName == "created_at" ) { console.log((target+'[name='+elementName+']')); }
            if ( input.is("input") || input.is("textarea") ) {
                if ( input.hasClass('avatar-file-picker') ) {//Element is an file picker for img
                    imgTarget = input.data('target');
                    $('img'+imgTarget).attr('src', propertyValue);
                } else {//Normal input/textarea
                    if(input.attr('type') == "checkbox") {
                        input.prop("checked", propertyValue);
                    } else {
                        input.val(propertyValue);
                    }                    
                }
            } 
            //Element is select
            else if ( input.is("select") ) {
                if ( input["multiple"] ) {//Multiple attribute enabled
                    
                } else if ( input.hasClass("selec2") || input.hasClass("select-special") ) {
                    console.log(propertyValue);
                    input.select2("val", propertyValue.toString());
                    input.trigger("change");
                } else {//Normal select
                    input.val(propertyValue);
                }
            }
            //$( ".data-fill" ).find( "."+elementName ).closest('.fill-container').removeClass('hide');
        }
    }
    /*if ( target ) {
        $('div'+target).modal();
    }*/
}

function addProduct(row) {
    var tipoPrecio = {
        precio_manual: "Tipo Manual",
        precio_a: "Precio A",
        precio_b: "Precio B",
        precio_c: "Precio C",
        precio_d: "Precio D",
        precio_e: "Precio E"
    }

    var htmlAdd =   '<tr data-row='+"'"+JSON.stringify(row)+"'"+'>'+
                        '<th>'+row.producto.nombre+'</th>'+
                        '<td>'+tipoPrecio[row.tipo_precio]+'</td>'+
                        '<td>'+row.precio+'</td>'+
                        '<td class="text-center align-middle">'+
                            //'<button class="btn btn-dark btn-sm edit-row-product" data-toggle="tooltip" title="Editar"><i class="mdi mdi-square-edit-outline"></i></button>'+
                            '<button class="btn btn-danger btn-sm delete-row-product" data-toggle="tooltip" title="Eliminar"><i class="mdi mdi-trash-can"></i></button>'+
                        '</td>'+
                    '</tr>';
    $("#productosEdit .tableProductos tbody").append(htmlAdd);
}

function numberWithCommas(x) {
    var aux = x.toString().split(".");
    if(aux.length > 1) {
        return aux[0].toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")+'.'+aux[1];
    } else {
        return aux[0].toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }        
}

function addDireccion(row) {
    var direccionHtml = row.calle+" "+row.numero_exterior;
    if(row.numero_interior) {
        direccionHtml+= " Int. "+row.numero_interior;
    }
    direccionHtml+= " - Col. "+row.colonia+" - "+row.municipio+", "+row.estado+'. C.P: '+row.codigo_postal;
    var uid = Date.now()+"-"+$("#direccionesEdit .tableDirecciones tbody .tr-direccion").length;
    var htmlAdd =   '<tr class="tr-direccion" data-uid='+'"'+uid+'"'+' data-row='+"'"+JSON.stringify(row)+"'"+'>'+
                        '<th>'+direccionHtml+'</th>'+
                        '<th>'+(row.flete ? row.flete : 'Sin flete')+' - $'+numberWithCommas(parseFloat(row.importe_flete).toFixed(4))+'</th>'+
                        '<td class="text-center align-middle">'+
                            '<button class="btn btn-dark btn-sm edit-row-direc" data-toggle="tooltip" title="Editar"><i class="mdi mdi-square-edit-outline"></i></button>'+
                            '<button class="btn btn-danger btn-sm delete-row-direc" data-toggle="tooltip" title="Eliminar"><i class="mdi mdi-trash-can"></i></button>'+
                        '</td>'+
                    '</tr>';
    $("#direccionesEdit .tableDirecciones tbody").append(htmlAdd);
    $("#estado,#municipio,#codigo_postal,#colonia,#calle,#numero_exterior,#numero_interior").val("");
}

function editDireccion(row, uid) {
    var direccionHtml = row.calle+" "+row.numero_exterior;
    if(row.numero_interior) {
        direccionHtml+= " Int. "+row.numero_interior;
    }
    direccionHtml+= " - Col. "+row.colonia+" - "+row.municipio+", "+row.estado+'. C.P: '+row.codigo_postal;
    var element = $("#direccionesEdit .tableDirecciones tbody tr[data-uid="+uid+"]");
    element.data("row", row);
    var htmlAdd =   '<th>'+direccionHtml+'</th>'+
                    '<th>'+(row.flete ? row.flete : 'Sin flete')+' - $'+numberWithCommas(parseFloat(row.importe_flete).toFixed(4))+'</th>'+
                    '<td class="text-center align-middle">'+
                        '<button class="btn btn-dark btn-sm edit-row-direc" data-toggle="tooltip" title="Editar"><i class="mdi mdi-square-edit-outline"></i></button>'+
                        '<button class="btn btn-danger btn-sm delete-row-direc" data-toggle="tooltip" title="Eliminar"><i class="mdi mdi-trash-can"></i></button>'+
                    '</td>';
    element.html(htmlAdd);
    $("#cancelEditDireccion").trigger("click");
}

function setFormProductos(row, target, prefix = false) {
    $(target).find(".modal-title").text('Productos del cliente: ' + row.nombre);
    $(target).find("#is_precio_especifico").prop("checked", false);
    $(target).find(".not_precio_especifico").show();
    $(target).find(".precio_especifico").hide();
    $(target).find(".tableProductos tbody").html("");
    $(target).find("#id").val(row.id);
    $.each(row.productos, function(index, value ){
        addProduct(value);
    });
}

function setFormDirecciones(row, target, prefix = false) {
    $(target).find(".modal-title").text('Direcciones del cliente: ' + row.nombre);
    $(target).find("#estado,#municipio,#codigo_postal,#colonia,#calle,#numero_exterior,#numero_interior").val("");
    $(target).find(".tableDirecciones tbody").html("");
    $(target).find("#id").val(row.id);
    $.each(row.direcciones, function(index, value ){
        addDireccion(value);
    });
}

function setFormDocumentacion(row, target, prefix = false, tipo = 1) {
    console.log(row);
    if(tipo == 1) {
        $(target).find('.d-file').hide();
        $(target).find('.modal-title').text('Completar documentación del pedido - '+row.id);
    } else {
        $(target).find('.modal-title').text('Ver documentación del pedido - '+row.id);
        $(target).find('.d-file').show();
    }
    $(target).find('input[name=id]').val(row.id);
    $(target).find('input[name=confirmacion_precio]').val(row.productos[0].costo.toFixed(4));
    $(target).find('input[name=folio_carta_porte], input[name=tracking], input[name=fecha_factura], input[name=folio_factura], input[name=complemento_factura],'+
                   'input[name=pdf_factura], input[name=folio_nota_credito], input[name=complemento_nota_credito], input[name=pdf_nota_credito], input[name=bol_carga],'+
                   'input[name=observaciones_facturacion], input[name=operador], input[name=tractor], input[name=tanque],'+
                   'input[name=densidad], input[name=bascula], input[name=veeder], input[name=observaciones_descarga],'+
                   'input[name=litros_totales], input[name=total_factura], input[name=litros_totales_nc], input[name=total_nota_credito]').val(null);
    $(target).find('.btn-d-file').data('file', "");
    if(row.documentacion) {
        var docu = row.documentacion;
        $(target).find('input[name=folio_carta_porte]').val(docu.folio_carta_porte);
        $(target).find('input[name=tracking]').val(docu.tracking);
        $(target).find('input[name=fecha_factura]').val(docu.fecha_factura);
        $(target).find('input[name=folio_factura]').val(docu.folio_factura);
        $(target).find('input[name=complemento_factura]').val(docu.complemento_factura);
        if(docu.pdf_factura) {
            $(target).find('.d-file_pdf_factura').show();
            $(target).find('.d-file_pdf_factura .btn-d-file').data('file', docu.pdf_factura);
        }
        $(target).find('input[name=folio_nota_credito]').val(docu.folio_nota_credito);
        $(target).find('input[name=complemento_nota_credito]').val(docu.complemento_nota_credito);
        if(docu.pdf_nota_credito) {
            $(target).find('.d-file_pdf_nota_credito').show();
            $(target).find('.d-file_pdf_nota_credito .btn-d-file').data('file', docu.pdf_nota_credito);
        }
        if(docu.bol_carga) {
            $(target).find('.d-file_bol_carga').show();
            $(target).find('.d-file_bol_carga .btn-d-file').data('file', docu.bol_carga);
        }
        $(target).find('input[name=observaciones_facturacion]').val(docu.observaciones_facturacion);
        $(target).find('input[name=operador]').val(docu.operador);
        $(target).find('input[name=tractor]').val(docu.tractor);
        $(target).find('input[name=tanque]').val(docu.tanque);
        $(target).find('input[name=densidad]').val(docu.densidad);
        if(docu.bascula) {
            $(target).find('.d-file_bascula').show();
            $(target).find('.d-file_bascula .btn-d-file').data('file', docu.bascula);
        }
        if(docu.veeder) {
            $(target).find('.d-file_veeder').show();
            $(target).find('.d-file_veeder .btn-d-file').data('file', docu.veeder);
        }
        $(target).find('input[name=observaciones_descarga]').val(docu.observaciones_descarga);
        $(target).find('input[name=litros_totales]').val(docu.litros_totales);
        $(target).find('input[name=total_factura]').val(docu.total_factura);
        $(target).find('input[name=litros_totales_nc]').val(docu.litros_totales_nc);
        $(target).find('input[name=total_nota_credito]').val(docu.total_nota_credito);
    }
}

function blockElement(config) {
    elem = config.element ? config.element : 'card';
    msg = config.msg ? config.msg : 'Por favor, espere...'
    $("."+elem).block({
        /*timeout:   2000,*/
        message:'<div class="spinner-grow spinner-grow-sm" role="status">\n' +
        '  <span class="sr-only">Cargando...</span>\n' +
        '</div> <span class="ml-2">'+msg+'</span>'
    });
}

function unBlockElement(element_class) {
    element_class ? $("div."+element_class).unblock() : $("div.card").unblock();
}

//Shows the loading swal
function loadingMessage(msg = null) {
    swal({
        title: msg ? msg : 'Espere un momento porfavor',
        buttons: false,
        closeOnEsc: false,
        closeOnClickOutside: false,
        content: {
            element: "div",
            attributes: {
                innerHTML:"<i class='mdi mdi-48px mdi-spin mdi-loading'></i>"
            },
        }
    }).catch(swal.noop);
}

//Reload a table, then initializes it as datatable
function refreshTable(url, column, table_class, container_class) {
    $('.delete-rows, .disable-rows, .reject-rows, .enable-rows').attr('disabled', true);
    var table = table_class ? $("table."+table_class).DataTable() : $("table.data-table").DataTable();
    var container = container_class ? $("div."+container_class) : $('div.rows-container');
    table.destroy();
    container.fadeOut();
    container.empty();
    container.load(url, function() {
        container.fadeIn();
        $(table_class ? "table."+table_class : "table.data-table").DataTable({
            colReorder: true,
            "aaSorting": [],
            //"aaSorting": [[ column ? column : 0, "desc" ]]
        });
        $('#example3_wrapper .dataTables_filter input').addClass("input-medium form-control");
        $('#example3_wrapper .dataTables_length select').addClass("select2-wrapper span12 form-control"); 
    });
    container.addClass('table-responsive');
}

//Reload an html section
function refreshHtml(html, container_class, table_class = false, column = false) {
    var container = container_class ? $("div."+container_class) : $('div.content-container');
    container.fadeOut();
    container.empty();
    container.html(html);

    if ( table_class ) {
        $(table_class ? "table."+table_class : "table.data-table").DataTable({
            colReorder: true,
            "aaSorting": [],
            //"aaSorting": [[ column ? column : 0, "desc" ]]
        });
    }
    container.fadeIn();
}

//Reload a galery module
function refreshGalery(url, container_class) {
    var container = container_class ? $("div."+container_class) : $('div.galery-container');
    container.fadeOut();
    container.empty();
    container.load(url, function() {
        container.fadeIn();
    });
}

//Reload a galery module
function refreshContent(url, container_class) {
    var container = container_class ? $("div."+container_class) : $('div.content-container');
    container.fadeOut();
    container.empty();
    container.load(url, function() {
        container.fadeIn();
    });
}

//Change the src of a img label
function readURL(input) {
    console.log('crea una imagen')
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('.cr-image').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

function checkbox_listener(data, config) {
    $('.'+config.el_class).parent().parent().unblock();
}
