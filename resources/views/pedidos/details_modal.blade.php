<!-- Modal -->
<div class="modal fade modal-slide-right" id="detailsForm" tabindex="-1" role="dialog" aria-labelledby="slideRightModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="slideRightModalLabel">Completar documentación del pedido - </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
            	@include('pedidos.form_details')
        	</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                @if (Auth::user()->tipo_usuario === 1)
			    <button type="submit" class="btn btn-success save" data-target-id="form-data">Guardar</button>
                @endif
            </div>
        </div>
    </div>
</div>