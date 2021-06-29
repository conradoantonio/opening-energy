<form id="form-data-productos" action="" onsubmit="return false;" enctype="multipart/form-data" method="POST" autocomplete="off" data-ajax-type="ajax-form" data-column="0" data-refresh="table" data-redirect="" data-table_id="example3" data-container_id="table-container" data-keepModal="true">
    <div class="form-row align-items-end">
        <div class="form-group d-none">
            <label>ID</label>
            <input type="text" class="form-control" name="id" id="id">
        </div>
        <div class="form-group col-md">
            <label>Producto</label>
            <select class="custom-select" name="producto_id" id="producto_id" data-msg="Producto">
                @foreach($productos as $producto)
                    <option data-row="{{$producto}}" value="{{$producto->id}}">{{$producto->nombre}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" name="is_precio_especifico" id="is_precio_especifico">
                <label class="custom-control-label" for="is_precio_especifico">Precio especifico</label>
            </div>
            <label class="not_precio_especifico">Precio</label>
            <select class="custom-select not_precio_especifico" name="tipo_precio" id="tipo_precio" data-msg="Producto">
                <option value="precio_a">Precio A</option>
                <option value="precio_b">Precio B</option>
                <option value="precio_c">Precio C</option>
                <option value="precio_d">Precio D</option>
                <option value="precio_e">Precio E</option>
            </select>
            <label class="precio_especifico">Precio</label>
            <input type="number" id="precio_especifico" name="precio_especifico" data-msg="Precio especifico" class="form-control not-empty fixed4 precio_especifico" required/>
        </div>
        <div class="form-group col-md-auto">
            <button type="button" class="btn btn-primary" id="agregarProducto">Agregar</button>
        </div>
    </div>

    <div class="form-row align-items-end">        
        <div class="form-group col-12 subtitle-text">
            Lista de productos
        </div>
    </div>

    <div class="form-row align-items-end">
        <div class="form-group col-12">
            <table class="table table-bordered tableProductos">
                <thead>
                    <tr>
                    <th scope="col">Producto</th>
                    <th scope="col">Tipo de precio</th>
                    <th scope="col">Precio</th>
                    <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
        
</form>