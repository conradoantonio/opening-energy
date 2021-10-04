<!-- Modal -->
<div class="modal fade modal-slide-right" id="viewForm" tabindex="-1" role="dialog" aria-labelledby="slideRightModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="slideRightModalLabel">Detalle del pedido - <span id="idPedido"></span></h5>
                <button type="button" class="close close-btn" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body" id="printableArea" style="overflow: auto;">
            	
        	</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close-btn">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="label-title" id="modal-cambiar-direccion">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="label-title">Cambiar dirección</h4>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group col-md-12 d-none">
                        <label>ID pedido</label>
                        <input type="text" class="form-control" name="pedido_id" data-msg="ID Pedido">
                    </div>

                    <div class="form-group col-md-12">
                        <label>Folio</label>
                        <input type="text" class="form-control" disabled name="pedido_folio" data-msg="Folio">
                    </div>
                    <div class="form-group col-md-12 div-clientes" style="text-align: left;">
                        <label>Direcciones</label>
                        <select id="direccion_id" name="direccion_id" class="form-control not-empty" style="width: 100%;" data-msg="Dirección">
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-success btn-generar-excel">Modificar dirección</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->