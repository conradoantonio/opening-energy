<form id="form-data" action="" onsubmit="return false;" enctype="multipart/form-data" method="POST" autocomplete="off" data-ajax-type="ajax-form" data-column="0" data-refresh="table" data-redirect="" data-table_id="example3" data-container_id="table-container" data-keepModal="true">
    <div class="form-group d-none">
        <label>ID</label>
        <input type="text" class="form-control" name="id">
    </div>
    <div class="form-row">
        <div class="form-group col-12">
            <label>Nombre</label>
            <input type="text" class="form-control not-empty" name="nombre" placeholder="Nombre" data-msg="Nombre" required>
        </div>
    </div>
    <div class="form-row">        
        <div class="form-group col-12">
            <label>Correo electrónico</label>
            <input type="email" id="email" name="email" data-msg="Correo electrónico" class="form-control not-empty email" required/>
        </div>        
    </div>

    <div class="form-row">        
        <div class="form-group col-md-6">
            <label>Contraseña</label>
            <input type="password" id="password" name="password" data-msg="Contraseña" class="form-control not-empty confirm" required/>
        </div>      
        <div class="form-group col-md-6">
            <label>Confirmar contraseña</label>
            <input type="password" id="password_confirm" name="password_confirm" data-msg="Confirmar contraseña" class="form-control" required/>
        </div>   
    </div>
</form>