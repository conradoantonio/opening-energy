<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PedidoDocumentacion extends Model
{

    protected $primaryKey = 'pedido_id';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pedidos_documentacion';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'pedido_id', 'folio_carta_porte', 'tracking', 'fecha_factura', 'folio_factura', 'complemento_factura',
        'pdf_factura', 'folio_nota_credito', 'complemento_nota_credito', 'pdf_nota_credito', 'bol_carga', 
        'observaciones_facturacion', 'operador', 'tractor', 'tanque', 'densidad', 'bascula', 'veeder',
        'observaciones_descarga', 'litros_totales', 'total_factura', 'litros_totales_nc', 'total_nota_credito'
	];

}
