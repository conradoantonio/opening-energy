<form id="form-data" action="" onsubmit="return false;" enctype="multipart/form-data" method="POST" autocomplete="off" data-ajax-type="ajax-form" data-column="0" data-refresh="table" data-redirect="" data-table_id="example3" data-container_id="table-container" data-keepModal="true">
    <div class="form-group d-none">
        <label>ID</label>
        <input type="text" class="form-control" name="id">
    </div>
    @if (Auth::user()->tipo_usuario === 1)
    <div class="form-row">        
        <div class="form-group col-md-6">
            <label>Confirmación de precio ($)</label>
            <input type="number" id="confirmacion_precio" value="0" name="confirmacion_precio" data-msg="Confirmación de precio" class="form-control not-empty fixed4" required/>
        </div>
    </div>
    @endif
    <div class="form-row">
        <div class="form-group col-md-6">
            <label>Folio carta porte</label>
            <input type="text" class="form-control" {{Auth::user()->tipo_usuario === 1 ? '' : 'disabled'}} name="folio_carta_porte" placeholder="Folio carta porte" data-msg="Folio carta porte" >
        </div>
        <div class="form-group col-md-6">
            <label>Tracking</label>
            <input type="text" class="form-control" {{Auth::user()->tipo_usuario === 1 ? '' : 'disabled'}} name="tracking" placeholder="Tracking" data-msg="Tracking" >
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label>Fecha factura</label>
            <input type="date" class="form-control" {{Auth::user()->tipo_usuario === 1 ? '' : 'disabled'}} name="fecha_factura" placeholder="Fecha factura" data-msg="Fecha factura" >
        </div>
        <div class="form-group col-md-6">
            <label>Folio factura</label>
            <input type="text" class="form-control" {{Auth::user()->tipo_usuario === 1 ? '' : 'disabled'}} name="folio_factura" placeholder="Folio factura" data-msg="Folio factura" >
        </div>
        <div class="form-group col-md-12">
            <label>Factura complemento</label>
            <input type="text" class="form-control" {{Auth::user()->tipo_usuario === 1 ? '' : 'disabled'}} name="complemento_factura" placeholder="Factura complemento" data-msg="Factura complemento" >
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label>Litros totales</label>
            <input type="number" class="form-control fixed4" {{Auth::user()->tipo_usuario === 1 ? '' : 'disabled'}} name="litros_totales" placeholder="Litros totales" data-msg="Litros totales" >
        </div>
        <div class="form-group col-md-6">
            <label>Total de la factura ($)</label>
            <input type="number" class="form-control fixed4" {{Auth::user()->tipo_usuario === 1 ? '' : 'disabled'}} name="total_factura" placeholder="Total de la factura" data-msg="Total de la factura" >
        </div>
    </div>
    <div class="form-row align-items-end">
        @if (Auth::user()->tipo_usuario === 1)
        <div class="form-group col">
            <label>Pdf factura</label>
            <input type="file" accept=".pdf" class="form-control file pdf" name="pdf_factura" placeholder="Pdf factura" data-msg="Pdf factura" >
        </div>
        @endif
        <div class="form-group col-auto d-file d-file_pdf_factura">
            @if (Auth::user()->tipo_usuario === 2)
            <label>Pdf factura</label><br>
            @endif
            <button type="button" class="btn btn-secondary btn-d-file" file="" data-toggle="tooltip" data-placement="top" title="Descargar pdf factura">{{Auth::user()->tipo_usuario === 2 ? 'Descargar pdf factura' : ''}} <i class="mdi mdi-file-download"></i></button>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-12">
            <label>Folio nota de crédito</label>
            <input type="text" class="form-control" {{Auth::user()->tipo_usuario === 1 ? '' : 'disabled'}} name="folio_nota_credito" placeholder="Folio nota de crédito" data-msg="Folio nota de crédito">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-12">
            <label>Nota de crédito complemento</label>
            <input type="text" class="form-control" {{Auth::user()->tipo_usuario === 1 ? '' : 'disabled'}} name="complemento_nota_credito" placeholder="Nota de crédito complemento" data-msg="Nota de crédito complemento">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label>Litros totales NC</label>
            <input type="number" class="form-control fixed4" {{Auth::user()->tipo_usuario === 1 ? '' : 'disabled'}} name="litros_totales_nc" placeholder="Litros totales NC" data-msg="Litros totales NC" >
        </div>
        <div class="form-group col-md-6">
            <label>Total nota de crédito ($)</label>
            <input type="number" class="form-control fixed4" {{Auth::user()->tipo_usuario === 1 ? '' : 'disabled'}} name="total_nota_credito" placeholder="Total nota de crédito" data-msg="Total nota de crédito" >
        </div>
    </div>
    <div class="form-row align-items-end">
        @if (Auth::user()->tipo_usuario === 1)
        <div class="form-group col">
            <label>Pdf nota de crédito</label>
            <input type="file" accept=".pdf" class="form-control pdf" name="pdf_nota_credito" placeholder="Pdf nota de crédito" data-msg="Pdf nota de crédito">
        </div>
        @endif
        <div class="form-group col-auto d-file d-file_pdf_nota_credito">
            @if (Auth::user()->tipo_usuario === 2)
            <label>Pdf nota de crédito</label><br>
            @endif
            <button type="button" class="btn btn-secondary btn-d-file" file="" data-toggle="tooltip" data-placement="top" title="Descargar pdf nota de crédito">{{Auth::user()->tipo_usuario === 2 ? 'Descargar pdf nota de crédito' : ''}} <i class="mdi mdi-file-download"></i></button>
        </div>
    </div>    
    <div class="form-row align-items-end">
        @if (Auth::user()->tipo_usuario === 1)
        <div class="form-group col">
            <label>Bol de carga</label>
            <input type="file" class="form-control file all_files" name="bol_carga" placeholder="Bol de carga" data-msg="Bol de carga" >
        </div>
        @endif
        <div class="form-group col-auto d-file d-file_bol_carga">
            @if (Auth::user()->tipo_usuario === 2)
            <label>Bol de carga</label><br>
            @endif
            <button type="button" class="btn btn-secondary btn-d-file" file="" data-toggle="tooltip" data-placement="top" title="Descargar bol de carga">{{Auth::user()->tipo_usuario === 2 ? 'Descargar bol de carga' : ''}} <i class="mdi mdi-file-download"></i></button>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-12">
            <label>Observaciones de facturación</label>
            <textarea type="text" class="form-control" {{Auth::user()->tipo_usuario === 1 ? '' : 'disabled'}}  data-msg="Observaciones de facturación" name="observaciones_facturacion" id="observaciones_facturacion" placeholder="Observaciones de facturación" rows="4" style="resize: none;"></textarea>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label>Operador</label>
            <input type="text" class="form-control" {{Auth::user()->tipo_usuario === 1 ? '' : 'disabled'}} name="operador" placeholder="Operador" data-msg="Operador" >
        </div>
        <div class="form-group col-md-6">
            <label>Tractor</label>
            <input type="text" class="form-control" {{Auth::user()->tipo_usuario === 1 ? '' : 'disabled'}} name="tractor" placeholder="Tractor" data-msg="Tractor" >
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label>Tanque</label>
            <input type="text" class="form-control" {{Auth::user()->tipo_usuario === 1 ? '' : 'disabled'}} name="tanque" placeholder="Tanque" data-msg="Tanque" >
        </div>
        <div class="form-group col-md-6">
            <label>Densidad</label>
            <input type="text" class="form-control" {{Auth::user()->tipo_usuario === 1 ? '' : 'disabled'}} name="densidad" placeholder="Densidad" data-msg="Densidad" >
        </div>
    </div>
    <div class="form-row align-items-end">
        @if (Auth::user()->tipo_usuario === 1)
        <div class="form-group col">
            <label>Bascula</label>
            <input type="file" accept="image/*" class="form-control file image" name="bascula" placeholder="Bascula" data-msg="Bascula" >
        </div>
        @endif
        <div class="form-group col-auto d-file d-file_bascula">
            @if (Auth::user()->tipo_usuario === 2)
            <label>Bascula</label><br>
            @endif
            <button type="button" class="btn btn-secondary btn-d-file" file="" data-toggle="tooltip" data-placement="top" title="Descargar bascula">{{Auth::user()->tipo_usuario === 2 ? 'Descargar bascula' : ''}} <i class="mdi mdi-file-download"></i></button>
        </div>
    </div>
    <div class="form-row align-items-end">
        @if (Auth::user()->tipo_usuario === 1)
        <div class="form-group col">
            <label>Veeder/Evidencia</label>
            <input type="file" accept="pdf/image/*" class="form-control file pdf image" name="veeder" placeholder="Veeder" data-msg="Veeder" >
        </div>
        @endif
        <div class="form-group col-auto d-file d-file_veeder">
            @if (Auth::user()->tipo_usuario === 2)
            <label>Veeder/Evidencia</label><br>
            @endif
            <button type="button" class="btn btn-secondary btn-d-file" file="" data-toggle="tooltip" data-placement="top" title="Descargar veeder">{{Auth::user()->tipo_usuario === 2 ? 'Descargar veeder' : ''}} <i class="mdi mdi-file-download"></i></button>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-12">
            <label>Observaciones de descarga</label>
            <textarea type="text" class="form-control" {{Auth::user()->tipo_usuario === 1 ? '' : 'disabled'}} data-msg="Observaciones de descarga" name="observaciones_descarga" id="observaciones_descarga" placeholder="Observaciones de descarga" rows="4" style="resize: none;"></textarea>
        </div>
    </div>
</form>