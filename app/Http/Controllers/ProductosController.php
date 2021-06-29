<?php

namespace App\Http\Controllers;

use Excel;
use Auth;
use \App\Producto;
use \App\Unidad;

use Illuminate\Http\Request;

class ProductosController extends Controller
{
	/**
     * Show the main view.
     *
     */
    public function index(Request $req)
    {   
        if (auth()->check()) {
            if(Auth::user()->tipo_usuario == 1) {
                $title    = $menu = "Productos";
                $items    = Producto::orderBy('id', 'desc')->get();

                if ( $req->ajax() ) {
                    return view('productos.table', compact('items'));
                }
                return view('productos.index', compact('items', 'menu' , 'title'));
            } else {
                return redirect()->to('/realizar-pedido');
            }
        } else {
            return redirect()->to('/login');
        }
        
    }

    /**
     * Show the main view.
     *
     */
    public function welcome(Request $req)
    {   

        if (auth()->check()) {
            if(Auth::user()->tipo_usuario == 1) {
                return redirect()->to('/productos');
            } else {
                return redirect()->to('/realizar-pedido');
            }
        } else {
            return redirect()->to('/login');
        }
        
    }
    
    /**
     * Save a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function save(Request $req)
    {
        if (auth()->check()) {
            $item = New Producto;

            $item->nombre      = $req->nombre;
            $item->precio_base = $req->precio_base;
            $item->precio_a    = $req->precio_a;
            $item->precio_b    = $req->precio_b;
            $item->precio_c    = $req->precio_c;
            $item->precio_d    = $req->precio_d;
            $item->precio_e    = $req->precio_e;            

            $item->save();

            return response(['msg' => 'Registro guardado correctamente', 'url' => url('productos'), 'status' => 'success'], 200);
        } else { 
            return response(['msg' => 'Es necesario estar logueado', 'status' => 'error', 'url' => url('productos')], 404); 
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
            $item = Producto::find($req->id);
            
            if (! $item ) { return response(['msg' => 'No se encontró el registro a editar', 'status' => 'error', 'url' => url('productos')], 404); }

            $item->nombre    = $req->nombre;
            $item->precio_base = $req->precio_base;
            $item->precio_a    = $req->precio_a;
            $item->precio_b    = $req->precio_b;
            $item->precio_c    = $req->precio_c;
            $item->precio_d    = $req->precio_d;
            $item->precio_e    = $req->precio_e;

            $item->save();

            return response(['msg' => 'Registro actualizado correctamente', 'url' => url('productos'), 'status' => 'success'], 200);
        } else { 
            return response(['msg' => 'Es necesario estar logueado', 'status' => 'error', 'url' => url('productos')], 404); 
        }
    }

    /**
     * Change the status of the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $req)
    {
        if (auth()->check()) {
            $msg = 'el registro';
            $item = Producto::find($req->ids[0]);

            if (! $item ) { return response(['msg' => 'No se encontró el registro a eliminar', 'status' => 'error', 'url' => url('productos')], 404); }

            $item->delete();

            return response(['msg' => 'Éxito eliminando '.$msg, 'url' => url('productos'), 'status' => 'success'], 200);
        } else { 
            return response(['msg' => 'Es necesario estar logueado', 'status' => 'error', 'url' => url('productos')], 404); 
        }
    }
}
