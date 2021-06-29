<!-- Modal -->
<div class="modal fade modal-slide-right" id="productosEdit" tabindex="-1" role="dialog" aria-labelledby="slideRightModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="slideRightModalLabel">Productos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
            	@include('clientes.form_productos')
        	</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
			    <button type="submit" class="btn btn-success save2" data-target-id="form-data-productos">Guardar</button>
            </div>
        </div>
    </div>
</div>