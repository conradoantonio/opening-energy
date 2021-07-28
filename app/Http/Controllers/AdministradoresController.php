<?php

namespace App\Http\Controllers;

use \App\User;

use Illuminate\Http\Request;

class AdministradoresController extends Controller
{
    /**
     * Show the main view.
     *
     */
    public function index(Request $req)
    {   
        if ( auth()->check() ) {
            if( auth()->user()->tipo_usuario == 1 ) {
                $title    = $menu = "Administradores";
                $items    = User::where('tipo_usuario', 1)->where('id', '!=', auth()->user()->id)->orderBy('id', 'desc')->get();

                if ( $req->ajax() ) {
                    return view('admins.table', compact('items'));
                }
                return view('admins.index', compact('items', 'menu' , 'title'));
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
        if( isset($req->registro) ) {
            if( $req->registro == "si" ) {
                $vlCont = true;
            }
        }

        if ( auth()->check() || $vlCont ) {
            $validated = $req->validate([
                'email' => 'required|unique:users',
            ]);
            $item = New User;

            $item->nombre       = $req->nombre;
            $item->email        = $req->email;
            $item->password     = bcrypt($req->password);
            $item->telefono     = '';     
            $item->tipo_usuario = 1; 

            $item->save();

            if( $vlCont ) {
                auth()->attempt(['email' => $req->email, 'password' => $req->password]);
                return response(['msg' => 'Registrado correctamente', 'url' => url('realizar-pedido'), 'status' => 'success'], 200);
            } else {
                return response(['msg' => 'Registro guardado correctamente', 'url' => url('administradores'), 'status' => 'success'], 200);
            }            
        } else { 
            return response(['msg' => 'Es necesario estar logueado', 'status' => 'error', 'url' => url('administradores')], 404); 
        }
    }

    /**
     * Edit a resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req)
    {
        if ( auth()->check() ) {
            $validated = $req->validate([
                'email' => 'required|unique:users,email,'.$req->id,
            ]);
            $item = User::where('id', $req->id)->where('tipo_usuario', 1)->first();
            
            if (! $item ) { return response(['msg' => 'No se encontró el registro a editar', 'status' => 'error', 'url' => url('administradores')], 404); }

            $item->nombre       = $req->nombre;
            $item->email        = $req->email;

            if( $req->password != "" ) {
                $item->password     = bcrypt($req->password);
            }

            $item->telefono     = '';

            $item->save();

            return response(['msg' => 'Registro actualizado correctamente', 'url' => url('administradores'), 'status' => 'success'], 200);
        } else { 
            return response(['msg' => 'Es necesario estar logueado', 'status' => 'error', 'url' => url('administradores')], 404); 
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
            $item = User::where('id', $req->ids[0])->where('tipo_usuario', 1)->first();
            // $item = User::find($req->ids[0]);

            if (! $item ) { return response(['msg' => 'No se encontró el registro a eliminar', 'status' => 'error', 'url' => url('administradores')], 404); }

            $item->delete();

            return response(['msg' => 'Éxito eliminando '.$msg, 'url' => url('administradores'), 'status' => 'success'], 200);
        } else { 
            return response(['msg' => 'Es necesario estar logueado', 'status' => 'error', 'url' => url('administradores')], 404); 
        }
    }
}
