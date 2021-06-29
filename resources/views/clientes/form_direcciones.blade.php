<form id="form-data-direcciones" action="" onsubmit="return false;" enctype="multipart/form-data" method="POST" autocomplete="off" data-ajax-type="ajax-form" data-column="0" data-refresh="table" data-redirect="" data-table_id="example3" data-container_id="table-container" data-keepModal="true">
    <div class="form-row align-items-end">
        <div class="form-group col col-md-6">
            <label class="estado">Estado</label>
            <input type="text" id="estado" name="estado" data-msg="Estado" class="form-control not-empty" required/>
        </div>
        <div class="form-group col col-md-6">
            <label class="municipio">Municipio</label>
            <input type="text" id="municipio" name="municipio" data-msg="Municipio" class="form-control not-empty" required/>
        </div>
    </div>
    <div class="form-row align-items-end">
        <div class="form-group d-none">
            <label>ID</label>
            <input type="text" class="form-control" name="id" id="id">
        </div>
        <div class="form-group d-none">
            <label>uid</label>
            <input type="text" class="form-control" name="uid" id="uid">
        </div>
        <div class="form-group col col-md-6">
            <label class="codigo_postal">Código postal</label>
            <input type="number" id="codigo_postal" name="codigo_postal" data-msg="Código postal" class="form-control not-empty" required/>
        </div>
        <div class="form-group col col-md-6">
            <label class="colonia">Colonia</label>
            <input type="text" id="colonia" name="colonia" data-msg="Colonia" class="form-control not-empty" required/>
        </div>
        <!--<div class="form-group col-auto">
            <button type="button" class="btn btn-primary" id="buscarCodigo">Buscar</button>
        </div>-->
    </div>
    <div class="form-row align-items-end">        
        <div class="form-group col">
            <label class="calle">Calle</label>
            <input type="text" id="calle" name="calle" data-msg="Calle" class="form-control not-empty" required/>
        </div>
    </div>
    <div class="form-row align-items-end">
        <div class="form-group col col-md-6">
            <label class="numero_exterior">Número exterior</label>
            <input type="text" id="numero_exterior" name="numero_exterior" data-msg="Número exterior" class="form-control not-empty" required/>
        </div>
        <div class="form-group col col-md-6">
            <label class="numero_interior">Número interior</label>
            <input type="text" id="numero_interior" name="numero_interior" data-msg="Número interior" class="form-control"/>
        </div>
    </div>
    <div class="form-row align-items-end">
        <div class="form-group col col-md-6">
            <label class="flete">Flete</label>
            <input type="text" id="flete" name="flete" data-msg="Flete" class="form-control not-empty" required/>
        </div>
        <div class="form-group col col-md-6">
            <label class="importe_flete">Importe de flete</label>
            <input type="number" id="importe_flete" name="importe_flete" data-msg="Importe de flete" class="form-control not-empty fixed4"/>
        </div>
    </div>
    <div class="form-row align-items-end">
        <div class="form-group col">
        </div>
        <div class="form-group col-auto edit-form-direc">
            <button type="button" class="btn btn-secondary" id="cancelEditDireccion">Cancelar</button>
        </div>
        <div class="form-group col-auto edit-form-direc">
            <button type="button" class="btn btn-primary" id="editDireccion">Actualizar</button>
        </div>
        <div class="form-group col-auto add-form-direc">
            <button type="button" class="btn btn-primary" id="agregarDireccion">Agregar</button>
        </div>
    </div>
    
    <div class="form-row align-items-end">        
        <div class="form-group col-12 subtitle-text">
            Lista de direcciones
        </div>
    </div>

    <div class="form-row align-items-end">
        <div class="form-group col-12">
            <table class="table table-bordered tableDirecciones">
                <thead>
                    <tr>
                        <th scope="col">Dirección</th>
                        <th scope="col">Flete</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
        
</form>