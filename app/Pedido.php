<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pedido extends Model
{

    use SoftDeletes;
    protected $dates = ['deleted_at'];
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pedidos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'id', 'user_id', 'direccion', 'fecha_entrega', 'observaciones', 'total', 'status', 'flete', 'importe_flete', 'total_flete'
	];

    public function productos()
    {
        return $this->hasMany(ProductoPedido::class);
    }

    public function user()
    {
        return $this->hasOne(User::class, "id", "user_id");
    }

    public function documentacion()
    {
        return $this->hasOne(PedidoDocumentacion::class);
    }

    public function direccion_table()
    {
        return $this->hasOne(Direcciones::class, 'id', 'direccion_id');
    }
}
