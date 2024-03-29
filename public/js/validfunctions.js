/*Código para validar el formulario de datos del usuario*/
$(function(){
    var mb = 0;
    var max_size = 3;
    var imgExtension = ['jpg','jpeg','png','gif','svg'];
    var pdfExtension = ['pdf'];
    var excelExtension = ['xls','xlsx'];
    var wordExtension = ['docx'];
    var inputs = [];
    var msgError = '';
    //var re_email = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
    var re_email = /^(?:[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+.[a-zA-Z]{2,6})?$/;
    //var re_num_dec = /^[0-9]+([.][0-9]{1,2})?$/
    var re_num_dec = /^((\d+\.?|\.(?=\d))?\d{0,2})$/;
    var re_only_num = /^\d+(\.\d{1,2})?$/i;
    var regExprNombre = /^[a-z ñ áéíóúäëïöüâêîôûàèìòùç\d_\s .]{2,50}$/i;
    var regExprPass = /^[a-z ñ áéíóúäëïöüâêîôûàèìòùç\d_ .]{5,20}$/i;
    var regExprTexto = /^[a-z ñ # , : ; ¿ ? ! ¡ ' " _ @ ( ) áéíóúäëïöüâêîôûàèìòùç\d_\s \-.]{2,}$/i;
    var form = '';
    var btn_form = $(".save");
    var btn_form2 = $(".save2");
    var btn_form3 = $(".save3");



    $(".not-empty").blur(function() {
        if ( $(this).val() || $(this).val() != 0 ) {
            if ($(this).hasClass('select2') || $(this).hasClass('select2-js')) {//Si es un select2 se remueve un error especial
                $(this).parent().children('span.select2').removeClass("select-error");
            } else if($(this).hasClass('selectpicker')) {
                $(this).parent().children('button.dropdown-toggle').removeClass("select-error");
            } else {
                $(this).parent().removeClass('has-error');
            }
        } else {
            if ($(this).hasClass('select2') || $(this).hasClass('select2-js')) {//Si es un select2 se agrega un error especial
                $(this).parent().children('span.select2').addClass("select-error");
            } else if ($(this).hasClass('selectpicker')) {//Si es un selectpicker se agrega un error especial
                $(this).parent().children('button.dropdown-toggle').addClass("select-error");
            } else {
                $(this).parent().addClass('has-error');
            }
        }
    });

    $(".email").blur(function() {
        if(!$(this).val().match(re_email)) {
            if ( !$(this).parent().hasClass("has-error") ){
                $(this).parent().addClass('has-error')
            }
        } else {
            $(this).parent().removeClass('has-error')
        }
    });

    $(".decimal").blur(function() {
        if(!$(this).val().match(re_num_dec)) {
            if ( !$(this).parent().hasClass("has-error") ){
                $(this).parent().addClass('has-error')
            }
        } else {
            $(this).parent().removeClass('has-error')
        }
    });

    $(".numeric").blur(function() {
        if(!$(this).val().match(re_only_num)) {
            if ( !$(this).parent().hasClass("has-error") ){
                $(this).parent().addClass('has-error')
            }
        } else {
            $(this).parent().removeClass('has-error')
        }
    });

    $(".confirm").blur(function() {
        if(!$(this).val().match(re_only_num)) {
            if ( !$(this).parent().hasClass("has-error") ){
                $(this).parent().addClass('has-error')
            }
        } else {
            $(this).parent().removeClass('has-error')
        }
    });

    $('body').delegate('.file','change', function() {
    //$('.file').on('change', function () {
        if ( $(this).hasClass('avatar-file-picker') ) {
            if ( $(this)[0].files[0] ) {
                file = $(this).val();
                ext = file.split('.').pop().toLowerCase();
                //Image file
                if ( $.inArray(ext, imgExtension) != -1 ) {
                    target = $(this).data('target');
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('img'+target).attr('src', e.target.result);
                    };

                    reader.readAsDataURL($(this)[0].files[0]);
                }
            }
        }
    });

    btn_form.on('click', function() {
        inputs = [];
        msgError = '';
        form = $(this).data('target-id') ? $('form#'+$(this).data('target-id')) : $(this).closest('form');
        console.log(form);
        form.find('input, select, textarea').each(function(i,e) {
            if ( $(this).hasClass('not-empty') ) {//Required fields
                if ( !$(this).val() || $(this).val() == 0 ) {//If empty or nothing selected
                    if ($(this).hasClass('select2') || $(this).hasClass('select2-js')) {
                        $(this).parent().children('span.select2').addClass("select-error");
                    } else if ($(this).hasClass('selectpicker')) {//Si es un selectpicker se agrega un error especial
                        $(this).parent().children('button.dropdown-toggle').addClass("select-error");
                    } else if ($(this).hasClass('custom-file-input')) {//
                        $(this).parent().addClass("file-error");
                    } else {
                        $(this).parent().addClass('has-error');
                    }
                    inputs.push($(this).data('msg'));
                    msgError = msgError +"<li>"+$(this).data('msg')+": Campo vacío</li>";
                } else {
                    if ($(this).hasClass('select2') || $(this).hasClass('select2-js')) {
                        $(this).parent().children('span.select2').removeClass("select-error");
                    } else if ($(this).hasClass('selectpicker')) {
                        $(this).parent().children('button.dropdown-toggle').removeClass("select-error");
                    } else if ($(this).hasClass('custom-file-input')) {
                        $(this).parent().removeClass("file-error");
                    } else {
                        $(this).parent().removeClass('has-error');
                    }
                }
            }

            if ( $(this).hasClass('email') ) {
                if(!$(this).val().match(re_email)) {
                    /*if ( !$(this).parent().hasClass("has-error") ) {*///If has content but it is not the correct
                        $(this).parent().addClass('has-error');
                        inputs.push($(this).data('msg'));
                        msgError = msgError +"<li>"+$(this).data('msg')+": Correo inválido</li>";
                    /*}*/
                }
            }

            if ( $(this).hasClass('decimal') ) {
                if (!$(this).val().match(re_num_dec)) {
                    /*if ( !$(this).parent().hasClass("has-error") ){*/
                        $(this).parent().addClass('has-error');
                        inputs.push($(this).data('msg'));
                        msgError = msgError +"<li>"+$(this).data('msg')+": Valor inválido</li>";
                    /*}*/
                }
            }

            if ( $(this).hasClass('numeric') ) {
                if (!$(this).val().match(re_only_num)) {
                    if ( !$(this).parent().hasClass("has-error") ){
                        $(this).parent().addClass('has-error');
                        inputs.push($(this).data('msg'));
                        msgError = msgError +"<li>"+$(this).data('msg')+": Valor inválido</li>";
                    }
                }
            }

            if ( $(this).hasClass('confirm') ) {
                if ($(this).val() != "" && $(this).val() != $("#"+$(this).attr("id")+"_confirm").val()) {
                    if ( !$(this).parent().hasClass("has-error") ){
                        $(this).parent().addClass('has-error');
                        inputs.push($(this).data('msg'));
                        msgError = msgError +"<li>"+$(this).data('msg')+": Las contraseñas no coinciden</li>";
                    }
                }
            }

            if ( $(this).hasClass('file') ) {
                file = $(this).val();
                extension = file.split('.').pop().toLowerCase();
                var arr_extensions = [];
                var all_files = false;

                if ( $(this).hasClass('image') ) {
                    console.log("jeje");
                    arr_extensions = $.merge(arr_extensions, imgExtension);
                }

                if ( $(this).hasClass('excel') ) {
                    arr_extensions = $.merge(arr_extensions, excelExtension);
                }

                if ( $(this).hasClass('word') ) {
                    arr_extensions = $.merge(arr_extensions, wordExtension);
                }

                if ( $(this).hasClass('pdf') ) {
                    arr_extensions = $.merge(arr_extensions, pdfExtension);
                }

                if ( $(this).hasClass('all_files') ) {
                    all_files = true;
                }

                if ( $(this).val() ) {
                    kilobyte = ( $(this)[0].files[0].size / 1024 );
                    mb = kilobyte / 1024;
                    console.log(extension, arr_extensions);
                    if (!all_files && $.inArray(extension, arr_extensions) == -1 || mb > max_size) {
                        if ( $.inArray(extension, arr_extensions) == -1 ) {
                            type_error = "Extensiones permitidas: "+arr_extensions;
                        } else {
                            type_error = "El arhivo debe ser menor a "+max_size+" mb";
                        }
                        $(this).parent().addClass("file-error");
                        msgError = msgError +"<li>"+$(this).data('msg')+": "+type_error+"</li>";
                        inputs.push($(this).data('msg'));
                    } else {
                        $(this).parent().removeClass("file-error");
                    }
                }
            }
        });

        if (inputs.length == 0) {
            loadingMessage('Guardando...')

            ajaxType = form.data('ajax-type');
            config = {
                'redirect'        : form.data('redirect'),
                'refresh'         : form.data('refresh'),
                'column'          : form.data('column'),
                'table_class'     : form.data('table_class'),
                'container_class' : form.data('container_class'),
                'callback'        : form.data('callback'),
                'keep_modal'      : form.data('keep_modal'),
            }
            console.log(config);
            if (ajaxType == 'ajax-form') { ajaxForm(form.attr('id'), config); }
            else if (ajaxType == 'ajax-form-modal') { ajaxFormModal(form.attr('id'), config); }
        } else {
            swal({
                title: 'Verifique los siguientes campos: ',
                icon: 'error',
                content: {
                    element: "div",
                    attributes: {
                        innerHTML:"<ul class='error_list'>"+msgError+"</ul>"
                    },
                }
            }).catch(swal.noop);
            $(".guardar").prop( "disabled", false ).removeClass('disabled');
            return false;
        }
    });

    btn_form2.on('click', function() {
        inputs = [];
        msgError = '';
        form = $(this).data('target-id') ? $('form#'+$(this).data('target-id')) : $(this).closest('form');

        form.find('.tableProductos tbody').each(function(i,e) {
            if($(this).find("tr").length == 0) {
                inputs.push("Lista de productos");
                msgError = msgError +"<li>Lista de productos: vacío</li>";
            }
        });
        
        if (inputs.length == 0) {
            loadingMessage('Guardando...')

            ajaxType = form.data('ajax-type');
            config = {
                'redirect'        : form.data('redirect'),
                'refresh'         : form.data('refresh'),
                'column'          : form.data('column'),
                'table_class'     : form.data('table_class'),
                'container_class' : form.data('container_class'),
                'callback'        : form.data('callback'),
                'keep_modal'      : form.data('keep_modal'),
            }
            ajaxForm2(form.attr('id'), config);
        } else {
            swal({
                title: 'Verifique los siguientes campos: ',
                icon: 'error',
                content: {
                    element: "div",
                    attributes: {
                        innerHTML:"<ul class='error_list'>"+msgError+"</ul>"
                    },
                }
            }).catch(swal.noop);
            $(".guardar").prop( "disabled", false ).removeClass('disabled');
            return false;
        }
    });

    btn_form3.on('click', function() {
        inputs = [];
        msgError = '';
        form = $(this).data('target-id') ? $('form#'+$(this).data('target-id')) : $(this).closest('form');

        form.find('.tableDirecciones tbody').each(function(i,e) {
            if($(this).find("tr").length == 0) {
                inputs.push("Lista de direcciones");
                msgError = msgError +"<li>Lista de direcciones: vacío</li>";
            }
        });
        
        if (inputs.length == 0) {
            loadingMessage('Guardando...')

            ajaxType = form.data('ajax-type');
            config = {
                'redirect'        : form.data('redirect'),
                'refresh'         : form.data('refresh'),
                'column'          : form.data('column'),
                'table_class'     : form.data('table_class'),
                'container_class' : form.data('container_class'),
                'callback'        : form.data('callback'),
                'keep_modal'      : form.data('keep_modal'),
            }
            ajaxForm3(form.attr('id'), config);
        } else {
            swal({
                title: 'Verifique los siguientes campos: ',
                icon: 'error',
                content: {
                    element: "div",
                    attributes: {
                        innerHTML:"<ul class='error_list'>"+msgError+"</ul>"
                    },
                }
            }).catch(swal.noop);
            $(".guardar").prop( "disabled", false ).removeClass('disabled');
            return false;
        }
    });
});
/*Fin de código para validar el formulario de datos del usuario*/