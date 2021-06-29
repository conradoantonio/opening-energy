<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Direcciones extends Model
{

    use SoftDeletes;
    protected $dates = ['deleted_at'];
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'direcciones';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'user_id', 'codigo_postal', 'estado', 'municipio', 'colonia', 'calle', 'numero_exterior', 'numero_interior', 'flete', 'importe_flete'
	];

    public function user()
    {
        return $this->hasOne(UserProducto::class)->where('user_id', Auth::user()->id);
    }
}
