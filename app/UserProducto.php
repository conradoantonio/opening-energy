<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserProducto extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_producto';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'user_id', 'producto_id', 'tipo_precio', 'precio'
	];

    public function producto()
    {
        return $this->belongsTo(Producto::Class);
    }
}
