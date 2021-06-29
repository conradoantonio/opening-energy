<?php

namespace App\Http\Controllers;

use Excel;
use Auth;
use \App\Configuracion;

use Illuminate\Http\Request;

class ConfiguracionController extends Controller
{
	/**
     * Show the main view.
     *
     */
    public function index(Request $req)
    {   
        if (auth()->check()) {
            $title = $menu = "Encuesta de servicios";
            $item = Configuracion::where('tipo', 'encuesta')->first();

            if(Auth::user()->tipo_usuario == 1) {     
                if ( $req->ajax() ) {
                    return view('configuracion.table', compact('items'));
                }
                return view('configuracion.index', compact('item', 'menu' , 'title'));
            } else {                
                return view('encuesta.index', compact('item', 'menu' , 'title'));
            }
        } else {
            return redirect()->to('/login');
        }        
    }


    /**
     * Edit a resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req)
    {
        if (auth()->check()) {
            $item = Configuracion::where('tipo', 'encuesta')->first();
            
            if (! $item ) { return response(['msg' => 'No se encontró el registro a editar', 'status' => 'error', 'url' => url('encuesta')], 404); }

            $item->valor      = $req->valor;

            $item->save();

            return response(['msg' => 'Registro actualizado correctamente', 'url' => url('encuesta'), 'status' => 'success'], 200);
        } else { 
            return response(['msg' => 'Es necesario estar logueado', 'status' => 'error', 'url' => url('encuesta')], 404); 
        }
    }
}
