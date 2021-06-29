<!-- Modal -->
<div class="modal fade modal-slide-right" id="contForm" tabindex="-1" role="dialog" aria-labelledby="slideRightModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="slideRightModalLabel">Formulario de pedido</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="form-data" action="" onsubmit="return false;" enctype="multipart/form-data" method="POST" autocomplete="off" data-ajax-type="ajax-form" data-column="0" data-refresh="table" data-redirect="" data-table_id="example3" data-container_id="table-container" data-keepModal="true">
                    <div id="first-view">
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label>Nombre</label><br>
                                <label>{{auth()->user()->nombre}}</label>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label>Correo electrónico</label><br>
                                <label>{{auth()->user()->email}}</label>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label>Teléfono</label><br>
                                <label>{{auth()->user()->telefono}}</label>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label>Dirección</label><br>
                                <select  class="form-control js-select2 not-empty" data-msg="Dirección" name="direccion_id" id="selectDirecciones">
                                    
                                </select>
                            </div>
                        </div>       
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label>Flete</label><br>
                                <label id="lblFlete">Sin flete</label>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label>Fecha de entrega</label><br>
                                <input type="date" class="form-control not-empty" data-msg="Fecha de entrega" name="fecha_entrega" id="fecha_entrega" placeholder="Fecha de entrega" rows="4" style="resize: none;"></input>
                            </div>
                        </div>                     
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label>Observaciones</label><br>
                                <textarea type="text" class="form-control"  data-msg="Observaciones" name="observaciones" id="observaciones" placeholder="Observaciones" rows="4" style="resize: none;"></textarea>
                            </div>
                        </div> 
                    </div>
                    <div id="second-view">
                        <div class="pedido-header">
                            <div class="row align-items-start mb-3">
                                <div class="col">
                                    <img class="admin-brand-logo" src="{{ asset('img/logo.jpeg') }}" width="100" alt="Logo">
                                </div>
                            </div>
                            <div class="row align-items-start">
                                <div class="col-auto font-weight-bold pr-0" style="width: 120px;">
                                    Nombre:
                                </div>
                                <div class="col pl-0" id="pedido-nombre">
                                </div>
                            </div>
                            <div class="row align-items-start">
                                <div class="col-auto font-weight-bold pr-0" style="width: 120px;">
                                    Teléfono:
                                </div>
                                <div class="col pl-0" id="pedido-telefono">
                                </div>
                            </div>
                            <div class="row align-items-start">
                                <div class="col-auto font-weight-bold pr-0" style="width: 120px;">
                                    Email:
                                </div>
                                <div class="col pl-0" id="pedido-email">
                                </div>
                            </div>
                            <div class="row align-items-start">
                                <div class="col-auto font-weight-bold pr-0" style="width: 120px;">
                                    Dirección:
                                </div>
                                <div class="col pl-0" id="pedido-direccion">
                                </div>
                            </div>   
                            <div class="row align-items-start">
                                <div class="col-auto font-weight-bold pr-0" style="width: 120px;">
                                    Flete:
                                </div>
                                <div class="col pl-0" id="pedido-flete">
                                </div>
                            </div>        
                            <div class="row align-items-end">
                                <div class="col-auto font-weight-bold pr-0" style="width: 120px;">
                                    Fecha de entrega:
                                </div>
                                <div class="col pl-0" id="pedido-fecha-entrega">
                                </div>
                            </div>
                            <div class="row align-items-start">
                                <div class="col-auto font-weight-bold pr-0" style="width: 120px;">
                                    Observaciones:
                                </div>
                                <div class="col pl-0" id="pedido-observaciones">
                                </div>
                            </div>                                
                        </div>
                        <div id="pedido-content">
                                
                        </div>
                        <div class="content-product"  style="padding: 14px 0 32px;">
                            <div class="row align-items-center">
                                <div class="col-12 text-right">
                                    <span class="font-weight-bold float-right" style="font-size: 20px;">Flete: $<span id="flete-total"></span></span>
                                </div>
                                <div class="col-12 text-right">
                                    <span class="font-weight-bold float-right" style="font-size: 22px;">Total: $<span id="pedido-total"></span></span><br><br>
                                    <small class="">Costo aproximado.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="first-back" data-dismiss="modal">Regresar</button>
                <button type="button" class="btn btn-secondary" id="second-back">Regresar</button>
                <button id="cont-pedido-modal" type="button" class="btn btn-success" data-target-id="form-data">Continuar con el pedido</button>
                <button id="env-pedido" type="submit" class="btn btn-success" data-target-id="form-data">Confirmar pedido</button>
            </div>
        </div>
    </div>
</div>