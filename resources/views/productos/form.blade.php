<form id="form-data" action="" onsubmit="return false;" enctype="multipart/form-data" method="POST" autocomplete="off" data-ajax-type="ajax-form" data-column="0" data-refresh="table" data-redirect="" data-table_id="example3" data-container_id="table-container" data-keepModal="true">
    <div class="form-group d-none">
        <label>ID</label>
        <input type="text" class="form-control" name="id">
    </div>
    <div class="form-row">
        <div class="form-group col-md-12">
            <label>Nombre</label>
            <input type="text" class="form-control not-empty" name="nombre" placeholder="Nombre" data-msg="Nombre" required>
        </div>
    </div>
    <div class="form-row">        
        <div class="form-group col-md-6">
            <label>Precio base</label>
            <input type="number" id="precio_base" name="precio_base" data-msg="Precio base" class="form-control not-empty fixed4" required/>
        </div>        
    </div>

    <div class="form-row align-items-end">        
        <div class="form-group col subtitle-text">
            Precios extras
        </div>
        <div class="form-group col-auto">
            <button type="button" class="btn btn-primary" id="calcularPrecios">Calcular precios</button>
        </div>
    </div>

    <div class="form-row">        
        <div class="form-group col-md-6">
            <label>Precio A</label>
            <input type="number" id="precio_a" value="0" name="precio_a" data-msg="Precio A" class="form-control not-empty fixed4" required/>
        </div>
        <div class="form-group col-md-6">
            <label>Precio B</label>
            <input type="number" id="precio_b" value="0" name="precio_b" data-msg="Precio B" class="form-control not-empty fixed4" required/>
        </div>
        <div class="form-group col-md-6">
            <label>Precio C</label>
            <input type="number" id="precio_c" value="0" name="precio_c" data-msg="Precio C" class="form-control not-empty fixed4" required/>
        </div>
        <div class="form-group col-md-6">
            <label>Precio D</label>
            <input type="number" id="precio_d" value="0" name="precio_d" data-msg="Precio D" class="form-control not-empty fixed4" required/>
        </div>
        <div class="form-group col-md-6">
            <label>Precio E</label>
            <input type="number" id="precio_e" value="0" name="precio_e" data-msg="Precio E" class="form-control not-empty fixed4" required/>
        </div>        
    </div>
</form>