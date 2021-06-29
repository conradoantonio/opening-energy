<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductoPedido extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'productos_pedido';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'pedido_id', 'producto', 'cantidad', 'costo', 'total'
	];

}
