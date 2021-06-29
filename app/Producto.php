<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{

    use SoftDeletes;
    protected $dates = ['deleted_at'];
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'productos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'nombre', 'precio_base', 'precio_a', 'precio_b', 'precio_c', 'precio_d', 'precio_e'
	];

    public function user()
    {
        return $this->hasOne(UserProducto::class)->where('user_id', Auth::user()->id);
    }
}
