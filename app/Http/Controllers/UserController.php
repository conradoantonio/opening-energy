<?php

namespace App\Http\Controllers;

use Excel;
use Auth;
use \App\User;
use \App\Producto;
use \App\UserProducto;
use \App\Direcciones;

use Illuminate\Http\Request;

class UserController extends Controller
{
	/**
     * Show the main view.
     *
     */
    public function index(Request $req)
    {   
        if (auth()->check()) {
            if(Auth::user()->tipo_usuario == 1) {
                $title     = $menu = "Clientes";
                $items     = User::where("tipo_usuario", 2)->orderBy('id', 'desc')->with("productos")->with("direcciones")->get();
                $productos = Producto::orderBy('id', 'desc')->get();

                if ( $req->ajax() ) {
                    return view('clientes.table', compact('items'));
                }
                return view('clientes.index', compact('items', 'productos', 'menu' , 'title'));

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
        $vlCont = false;
        if(isset($req->registro)) {
            if($req->registro == "si") {
                $vlCont = true;
            }
        }

        if (auth()->check() || $vlCont) {
            $validated = $req->validate([
                'email' => 'required|unique:users',
            ]);
            $item = New User;

            $item->nombre       = $req->nombre;
            $item->email        = $req->email;
            $item->password     = bcrypt($req->password);
            $item->telefono     = $req->telefono;     
            $item->tipo_usuario = 2; 

            $item->save();

            if($vlCont) {
                auth()->attempt(['email' => $req->email, 'password' => $req->password]);
                return response(['msg' => 'Registrado correctamente', 'url' => url('realizar-pedido'), 'status' => 'success'], 200);
            } else {
                return response(['msg' => 'Registro guardado correctamente', 'url' => url('clientes'), 'status' => 'success'], 200);
            }            
        } else { 
            return response(['msg' => 'Es necesario estar logueado', 'status' => 'error', 'url' => url('clientes')], 404); 
        }
    }

    /**
     * Save a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function direcciones(Request $req)
    {
        if (auth()->check()) {
            $items = Direcciones::where("user_id", $req->user_id)->delete();
            foreach ($req->direcciones as $direccion) {
                $item = New Direcciones;

                $item->user_id         = $req->user_id;
                $item->codigo_postal   = $direccion['codigo_postal'];
                $item->estado          = $direccion['estado'];
                $item->municipio       = $direccion['municipio'];
                $item->colonia         = $direccion['colonia'];
                $item->calle           = $direccion['calle'];
                $item->numero_exterior = $direccion['numero_exterior'];
                $item->numero_interior = $direccion['numero_interior'];
                $item->flete           = $direccion['flete'];
                $item->importe_flete   = $direccion['importe_flete'];

                $item->save();
            }
            

            return response(['msg' => 'Registro guardado correctamente', 'url' => url('clientes'), 'status' => 'success'], 200);
        } else { 
            return response(['msg' => 'Es necesario estar logueado', 'status' => 'error', 'url' => url('clientes')], 404); 
        }
    }

    public function productos(Request $req)
    {
        if (auth()->check()) {
            $items = UserProducto::where("user_id", $req->user_id)->delete();
            foreach ($req->productos as $producto) {
                $item = New UserProducto;

                $item->user_id      = $req->user_id;
                $item->producto_id  = $producto['producto_id'];
                $item->tipo_precio  = $producto['tipo_precio'];
                $item->precio       = $producto['precio'];

                $item->save();
            }
            

            return response(['msg' => 'Registro guardado correctamente', 'url' => url('clientes'), 'status' => 'success'], 200);
        } else { 
            return response(['msg' => 'Es necesario estar logueado', 'status' => 'error', 'url' => url('clientes')], 404); 
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
            $validated = $req->validate([
                'email' => 'required|unique:users,email,'.$req->id,
            ]);
            $item = User::find($req->id);
            
            if (! $item ) { return response(['msg' => 'No se encontró el registro a editar', 'status' => 'error', 'url' => url('clientes')], 404); }

            $item->nombre       = $req->nombre;
            $item->email        = $req->email;
            if($req->password != "") {
                $item->password     = bcrypt($req->password);
            }            
            $item->telefono     = $req->telefono;     

            $item->save();

            return response(['msg' => 'Registro actualizado correctamente', 'url' => url('clientes'), 'status' => 'success'], 200);
        } else { 
            return response(['msg' => 'Es necesario estar logueado', 'status' => 'error', 'url' => url('clientes')], 404); 
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
            $item = User::find($req->ids[0]);

            if (! $item ) { return response(['msg' => 'No se encontró el registro a eliminar', 'status' => 'error', 'url' => url('clientes')], 404); }

            $item->delete();

            return response(['msg' => 'Éxito eliminando '.$msg, 'url' => url('clientes'), 'status' => 'success'], 200);
        } else { 
            return response(['msg' => 'Es necesario estar logueado', 'status' => 'error', 'url' => url('clientes')], 404); 
        }
    }
}
