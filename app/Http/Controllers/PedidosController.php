<?php

namespace App\Http\Controllers;

use File;
use Mail;
use Auth;

use \App\Pedido;
use \App\Producto;
use \App\Unidad;
use \App\ProductoPedido;
use \App\Direcciones;
use \App\UserProducto;
use \App\PedidoDocumentacion;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use App\Exports\PedidosExport;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Http\Request;
use Response;

class PedidosController extends Controller
{
	/**
     * Show the main view.
     *
     */
    public function index(Request $req)
    {   
        if (auth()->check()) {
            $title = $menu = "Pedidos";
            #$items = Pedido::orderBy('id', 'desc')->with("productos")->get();
            $items = Pedido::orderBy('id', 'desc')->with("productos")->with("user")->with('documentacion')->with('direccion_table');
            if(Auth::user()->tipo_usuario != 1) {
                $items = $items->where("user_id", Auth::user()->id);
            }

            if(isset($req->estado)) {
                if($req->estado != "todos") {
                    $items = $items->where("status", $req->estado);
                }
            }

            if(isset($req->fecha_ini)) {
                $items = $items->where("fecha_entrega", ">=", $req->fecha_ini);
            }

            if(isset($req->fecha_fin)) {
                $items = $items->where("fecha_entrega", "<=", $req->fecha_fin);
            }

            if(!isset($req->estado) && !isset($req->fecha_ini) && !isset($req->fecha_fin)) {
                $items = $items->limit(100);
            }

            $items = $items->get();
            
            if ( $req->ajax() ) {
                return view('pedidos.table', compact('items'));
            }
            return view('pedidos.index', compact('items', 'menu' , 'title'));
        } else {
            return redirect()->to('/login');
        }    
    }

    public function realizarPedido(Request $req)
    {
        if (auth()->check()) {
            if(Auth::user()->tipo_usuario != 1) {
                $title       = $menu = "Realizar pedido";
                $productos   = Producto::orderBy('nombre')->with('user')->get();
                $direcciones = Direcciones::where('user_id', Auth::user()->id)->get();

                return view('realizar_pedido.index', compact('productos', 'direcciones', 'menu' , 'title'));

            } else {
                return redirect()->to('/productos');
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
        DB::beginTransaction();
        $direc = Direcciones::where('id', $req->direccion_id)->first();
        $item = New Pedido;

        $item->user_id       = Auth::user()->id;
        $item->direccion_id  = $req->direccion_id;   
        $item->direccion     = $req->direccion;        
        $item->fecha_entrega = $req->fecha_entrega;
        $item->observaciones = $req->observaciones;
        $item->status        = 'pendiente';
        $item->flete         = $direc->flete;
        $item->importe_flete = $direc->importe_flete;

        $totalPedi = 0;
        $totalFlete = 0;
        $req->productos = json_decode($req->productos);
        
        foreach ($req->productos as $producto) {
            $prod = Producto::where('id', $producto->producto_id)->with("user")->first();            
            $costo = $prod->precio_base;
            if ($prod) {
                $costo = $prod->precio_base;
                if($prod->user) {
                    if($prod->user->tipo_precio != "precio_manual") {
                        $costo = $prod[$prod->user->tipo_precio];
                    } else {
                        $costo = $prod->user->precio;
                    }
                }
                $totalPedi = $totalPedi + ($costo * $producto->cantidad);
                if($direc) {
                    $totalFlete = $totalFlete + ($direc->importe_flete * $producto->cantidad);
                }                
            }        
        }

        $item->total_flete  = $totalFlete;
        $item->total        = $totalPedi + $totalFlete;

        $item->save();
        $productArray = [];
        foreach ($req->productos as $producto) {
            $prod = Producto::find($producto->producto_id);
            $itemProd = New ProductoPedido;

            $itemProd->pedido_id   = $item->id;
            $itemProd->producto    = $prod->nombre;
            $itemProd->cantidad    = $producto->cantidad;
            if ($prod) {
                $costo = $prod->precio_base;
                if($prod->user) {
                    if($prod->user->tipo_precio != "precio_manual") {
                        $costo = $prod[$prod->user->tipo_precio];
                    } else {
                        $costo = $prod->user->precio;
                    }
                }
                $itemProd->costo       = $costo;
                $itemProd->total       = $costo * $producto->cantidad;
            } else {
                $itemProd->costo       = 0;
                $itemProd->total       = 0;
            }

            $itemProd->save();

            $productArray [] = $itemProd;
        }

        $item = $item->load('user');

        $params['subject'] = 'Compra en Energy Opening';
        $params['pedido'] = $item;
        $params['productos'] = $productArray;
        $params['direccion'] = $direc;
        $params['email'] = explode(",", $item->user->email);

        

        /*Mail::send('mails.pedido', ['content' => $params], function ($message) use($params)
        {
            $message->to($params['email']);
            $message->from(env('MAIL_USERNAME'), 'ENERGY OPENING');
            $message->subject('ENERGY OPENING | '.$params['subject']);
        });

        $params['email'] = explode(",", 'pedidos@energyopening.mx');

        Mail::send('mails.pedido', ['content' => $params], function ($message) use($params)
        {
            $message->to($params['email']);
            $message->from(env('MAIL_USERNAME'), 'ENERGY OPENING');
            $message->subject('ENERGY OPENING | '.$params['subject']);
        });*/

        DB::commit();
        return response(['msg' => 'Registro enviado correctamente', 'url' => url('pedidos'), 'status' => 'success'], 200);
    }

    /**
     * Edit a resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req)
    {
        if (auth()->check()) {
            DB::beginTransaction();
            $item = Pedido::find($req->id);
            if (! $item ) { return response(['msg' => 'No se encontró el registro a editar', 'status' => 'error', 'url' => url('pedidos')], 404); }

            $item->fecha_entrega = $req->fecha_entrega;

            $totalPedi  = 0;
            $totalFlete = 0;
            $req->productos = json_decode($req->productos);
            foreach ($req->productos as $producto) {
                $totalPedi = $totalPedi + ($producto->costo * $producto->cantidad);
                $totalFlete = $totalFlete + ($item->importe_flete * $producto->cantidad);  
            }

            $item->total_flete  = $totalFlete;
            $item->total        = $totalPedi + $totalFlete;

            $item->save();

            $prodPed = ProductoPedido::where("pedido_id", $req->id);
            
            $prodPed->delete();

            foreach ($req->productos as $producto) {
                $itemProd = New ProductoPedido;
                $itemProd->pedido_id   = $item->id;
                $itemProd->producto    = $producto->nombre;
                $itemProd->cantidad    = $producto->cantidad;
                $itemProd->costo       = $producto->costo;
                $itemProd->total       = $producto->costo * $producto->cantidad;

                $itemProd->save();
            }
            DB::commit();
            $items = Pedido::where("id", $req->id)->with("productos")->with("user")->with('direccion_table')->get();

            return response(['msg' => 'Registro actualizado correctamente', 'url' => url('pedidos'), 'status' => 'success', 'item' => $items], 200);
        } else { 
            return response(['msg' => 'Es necesario estar logueado', 'status' => 'error', 'url' => url('pedidos')], 404); 
        }
    }

    public function updateDocumentacion(Request $req)
    {
        if (auth()->check()) {
            DB::beginTransaction();
            $item = Pedido::find($req->id);
            if (! $item ) { return response(['msg' => 'No se encontró el registro a editar', 'status' => 'error', 'url' => url('pedidos')], 404); }

            $prodPed = ProductoPedido::where("pedido_id", $req->id)->get();

            $totalPedi = 0;
            $totalFlete = 0;
            foreach ($prodPed as $producto) {
                $producto->costo = $req->confirmacion_precio;
                $producto->total = ($producto->costo * $producto->cantidad);
                $producto->save();
                $totalPedi = $totalPedi + $producto->total;
                $totalFlete = $totalFlete + ($item->importe_flete * $producto->cantidad);
                
            }
            
            $item->total_flete  = $totalFlete;
            $item->total        = $totalPedi + $totalFlete;

            $item->save();

            $docPed = PedidoDocumentacion::where("pedido_id", $req->id)->first();
            if(!$docPed) {
                $docPed = new PedidoDocumentacion;
                $docPed->pedido_id =  $req->id;
            }

            $docPed->folio_carta_porte          = $req->folio_carta_porte;
            $docPed->tracking                   = $req->tracking;
            $docPed->fecha_factura              = $req->fecha_factura;
            $docPed->folio_factura              = $req->folio_factura;
            $docPed->litros_totales             = $req->litros_totales;
            $docPed->total_factura              = $req->total_factura;
            
            /* Subir pdf_factura */
            if($req->pdf_factura) {
                $fileNameAux = 'pdf_factura.'.$req->pdf_factura->getClientOriginalExtension();
                $req->pdf_factura->move(public_path('documentacion/'.$req->id), $fileNameAux);
                $docPed->pdf_factura        = 'documentacion/'.$req->id.'/'.$fileNameAux;
            }            
            
            $docPed->folio_nota_credito         = $req->folio_nota_credito;
            $docPed->litros_totales_nc          = $req->litros_totales_nc;
            $docPed->total_nota_credito         = $req->total_nota_credito;

            /* Subir pdf_nota_credito */
            if($req->pdf_nota_credito) {
                $fileNameAux = 'pdf_nota_credito.'.$req->pdf_nota_credito->getClientOriginalExtension();
                $req->pdf_nota_credito->move(public_path('documentacion/'.$req->id), $fileNameAux);
                $docPed->pdf_nota_credito = 'documentacion/'.$req->id.'/'.$fileNameAux;
            }   

            /* Subir bol_carga */
            if($req->bol_carga) {
                $fileNameAux = 'bol_carga.'.$req->bol_carga->getClientOriginalExtension();
                $req->bol_carga->move(public_path('documentacion/'.$req->id), $fileNameAux);
                $docPed->bol_carga = 'documentacion/'.$req->id.'/'.$fileNameAux;
            }   

            $docPed->observaciones_facturacion  = $req->observaciones_facturacion;
            $docPed->operador                   = $req->operador;
            $docPed->tractor                    = $req->tractor;
            $docPed->tanque                     = $req->tanque;
            $docPed->densidad                   = $req->densidad;

            /* Subir bascula */
            if($req->bascula) {
                $fileNameAux = 'bascula.'.$req->bascula->getClientOriginalExtension();
                $req->bascula->move(public_path('documentacion/'.$req->id), $fileNameAux);
                $docPed->bascula = 'documentacion/'.$req->id.'/'.$fileNameAux;
            }   

            /* Subir veeder */
            if($req->veeder) {
                $fileNameAux = 'veeder.'.$req->veeder->getClientOriginalExtension();
                $req->veeder->move(public_path('documentacion/'.$req->id), $fileNameAux);
                $docPed->veeder = 'documentacion/'.$req->id.'/'.$fileNameAux;
            }

            $docPed->observaciones_descarga     = $req->observaciones_descarga;

            $docPed->save();
            DB::commit();
            $items = Pedido::where("id", $req->id)->with("productos")->with("user")->get();

            return response(['msg' => 'Registro actualizado correctamente', 'url' => url('pedidos'), 'status' => 'success', 'item' => $items], 200);
        } else { 
            return response(['msg' => 'Es necesario estar logueado', 'status' => 'error', 'url' => url('pedidos')], 404); 
        }
    }

    public function downloadDocumentacion(Request $req)
    {
        if (auth()->check()) {
            DB::beginTransaction();
            $item = PedidoDocumentacion::where("pedido_id", $req->id)->first();
            if (! $item ) { return response(['msg' => 'No se encontró el registro a descargar', 'status' => 'error', 'url' => url('pedidos')], 404); }            

            DB::commit();
            return Response::download(public_path($req->file), 'your_file_name_when_downloaded.pdf');
        } else { 
            return response(['msg' => 'Es necesario estar logueado', 'status' => 'error', 'url' => url('pedidos')], 404); 
        }
    }

    public function status(Request $req)
    {
        if (auth()->check()) {
            DB::beginTransaction();
            $item = Pedido::find($req->id);
            if (! $item ) { return response(['msg' => 'No se encontró el registro a editar', 'status' => 'error', 'url' => url('pedidos')], 404); }

            $item->status = 'atendido';

            $item->save();

            DB::commit();
            $items = Pedido::where("id", $req->id)->with("productos")->with("user")->get();

            return response(['msg' => 'Éxito actualizando el pedido', 'url' => url('pedidos'), 'status' => 'success'], 200);
        } else { 
            return response(['msg' => 'Es necesario estar logueado', 'status' => 'error', 'url' => url('pedidos')], 404); 
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
            $msg = 'el pedido';
            $item = Pedido::find($req->ids[0]);

            if (! $item ) { return response(['msg' => 'No se encontró el registro a eliminar', 'status' => 'error', 'url' => url('pedidos')], 404); }

            $item->delete();

            $productoPedido = ProductoPedido::where('pedido_id', $req->ids[0]);

            $productoPedido->delete();

            return response(['msg' => 'Éxito eliminando '.$msg, 'url' => url('pedidos'), 'status' => 'success'], 200);
        } else { 
            return response(['msg' => 'Es necesario estar logueado', 'status' => 'error', 'url' => url('pedidos')], 404); 
        }
    }

    /**
     * Use Excel instance to export all products at once.
     *
     * @return \Illuminate\Http\Response
     */
    public function downloadExcel( Request $req )
    {   
        if (auth()->check()) {
            $items = Pedido::orderBy('id', 'desc')->with("productos")->with("user")->with('documentacion');
            if(Auth::user()->tipo_usuario != 1) {
                $items = $items->where("user_id", Auth::user()->id);
            }

            if(isset($req->estado)) {
                if($req->estado != "todos") {
                    $items = $items->where("status", $req->estado);
                }
            }

            if(isset($req->fecha_ini)) {
                $items = $items->where("fecha_entrega", ">=", $req->fecha_ini);
            }

            if(isset($req->fecha_fin)) {
                $items = $items->where("fecha_entrega", "<=", $req->fecha_fin);
            }

            if(!isset($req->estado) && !isset($req->fecha_ini) && !isset($req->fecha_fin)) {
                $items = $items->limit(100);
            }

            $items = $items->get();

            $rows = array();
            $titulos     = array();
            $encabezados = array();

            $rows []        = ['Pedidos', '', ''];
            $rows []        = ['', '', ''];
            $rows []        = [
                'Folio', 
                'Nombre', 
                'Correo', 
                'Dirección', 
                'Teléfono', 
                'Fecha - Hora',  
                'Fecha de entrega', 
                'Producto', 
                'Cantidad', 
                'Costo', 
                'Flete', 
                'Total flete', 
                'Total', 
                'Estado', 
                'Observaciones', 
                'Folio carta porte', 
                'Tracking', 
                'Fecha factura', 
                'Folio factura', 
                'Litros totales', 
                'Total de la factura', 
                'Folio nota de crédito',
                'Litros totales NC', 
                'Total nota de crédito', 
                'Observaciones de facturación', 
                'Operador', 
                'Tractor', 
                'Tanque', 
                'Densidad', 
                'Observaciones de descarga'];
            $encabezados [] = count($rows);
            foreach ($items as $pedido) {
                if(isset($pedido->documentacion)) {
                    $rows [] = [
                        $pedido->id, 
                        $pedido->user->nombre, 
                        $pedido->user->email, 
                        $pedido->direccion, 
                        $pedido->user->telefono, 
                        $pedido->created_at,  
                        $pedido->fecha_entrega, 
                        $pedido->productos[0]->producto, 
                        $pedido->productos[0]->cantidad, 
                        '$'.number_format($pedido->productos[0]->costo, 4), 
                        $pedido->flete.' - $'.number_format($pedido->importe_flete, 4), 
                        '$'.number_format($pedido->total_flete, 4), 
                        '$'.number_format($pedido->total, 4), 
                        ucfirst($pedido->status), 
                        $pedido->observaciones,
                        $pedido->documentacion->folio_carta_porte,
                        $pedido->documentacion->tracking,
                        $pedido->documentacion->fecha_factura,
                        $pedido->documentacion->folio_factura,
                        number_format($pedido->documentacion->litros_totales,0),
                        '$'.number_format($pedido->documentacion->total_factura, 4),
                        $pedido->documentacion->folio_nota_credito,
                        number_format($pedido->documentacion->litros_totales_nc, 0),
                        '$'.number_format($pedido->documentacion->total_nota_credito, 4),
                        $pedido->documentacion->observaciones_facturacion,
                        $pedido->documentacion->operador,
                        $pedido->documentacion->tractor,
                        $pedido->documentacion->tanque,
                        $pedido->documentacion->densidad,
                        $pedido->documentacion->observaciones_descarga
                    ];
                } else {
                    $rows [] = [
                        $pedido->id, 
                        $pedido->user->nombre, 
                        $pedido->user->email, 
                        $pedido->direccion, 
                        $pedido->user->telefono, 
                        $pedido->created_at,  
                        $pedido->fecha_entrega, 
                        $pedido->productos[0]->producto, 
                        $pedido->productos[0]->cantidad, 
                        '$'.number_format($pedido->productos[0]->costo, 4), 
                        $pedido->flete.' - $'.number_format($pedido->importe_flete, 4), 
                        '$'.number_format($pedido->total_flete, 4), 
                        '$'.number_format($pedido->total, 4), 
                        ucfirst($pedido->status), 
                        $pedido->observaciones
                    ];
                }
                
            }
            return Excel::download(new PedidosExport($rows, $titulos, $encabezados), 'Listado de productos pedidos '.date('d-m-Y').'.xlsx');
        } else {
            return redirect()->to('/login');
        }
    }

    /**
     * Use Excel instance to export all products at once.
     *
     * @return \Illuminate\Http\Response
     */
    public function mail( Request $req )
    {   
        if (auth()->check()) {
            $dayRestList = 1;
            if (Carbon::now()->dayOfWeek == 1) {
                $dayRestList = 2;                
            }

            $items = Pedido::with("productos")->where("created_at", ">=", Carbon::now()->subDays($dayRestList)->setTime(0, 0, 0))->where("created_at", "<", Carbon::now()->setTime(0, 0, 0))->get();
            $productos = [];
            $lacteos   = [];
            $carnicos  = [];
            $otros     = [];
            $rows = array();
            foreach ($items as $item) {
                foreach ($item->productos as $itemProd) {
                    if ($itemProd->producto) {
                        if ($itemProd->producto->categoria != "Carnicos" &&
                            $itemProd->producto->categoria != "Lácteos") {
                            $llave = $itemProd->producto->nombre.$itemProd->producto->unidad->unidad . " (" . $itemProd->producto->unidad->abreviacion . ")";
                            if (isset($productos[$llave]) == false) {
                                $productos[$llave] = [ 
                                                                            'Producto'     => $itemProd->producto->nombre,
                                                                            'Unidad'       => $itemProd->producto->unidad->unidad . " (" . $itemProd->producto->unidad->abreviacion . ")",
                                                                            'Categoria'    => $itemProd->producto->categoria,
                                                                            'Fraccionario' => $itemProd->producto->unidad->fraccionario,
                                                                            'Cantidad'     => 0,
                                                                            'Aux'          => '',
                                                                            'Notas'        => ''
                                                                        ];
                            }
                            if ($itemProd->nota) {
                                if ($productos[$llave]['Notas'] != "") {
                                    $productos[$llave]['Notas'] = $productos[$llave]['Notas'].', ';
                                }
                                $productos[$llave]['Notas'] = $productos[$llave]['Notas'].$itemProd->nota.'(Pedido '.$item->id.')';
                            }
                            $productos[$llave]['Cantidad'] = $productos[$llave]['Cantidad'] + $itemProd->cantidad;
                        } else {
                            if ($itemProd->producto->categoria == "Carnicos") {
                                $carnicos [] = [
                                                    'Cliente'  => $item->nombre,
                                                    'Producto' => $itemProd->producto->nombre,
                                                    'Unidad'   => $itemProd->producto->unidad->unidad . " (" . $itemProd->producto->unidad->abreviacion . ")",
                                                    'Cantidad' => $itemProd->producto->unidad->fraccionario ? number_format($itemProd->cantidad, 2) : $itemProd->cantidad,
                                                    'Nota'     => $itemProd->nota
                                                ];
                            }
                            if ($itemProd->producto->categoria == "Lácteos") {
                                $lacteos [] =  [
                                                    'Cliente'  => $item->nombre,
                                                    'Producto' => $itemProd->producto->nombre,
                                                    'Unidad'   => $itemProd->producto->unidad->unidad . " (" . $itemProd->producto->unidad->abreviacion . ")",
                                                    'Cantidad' => $itemProd->producto->unidad->fraccionario ? number_format($itemProd->cantidad, 2) : $itemProd->cantidad,
                                                    'Nota'     => $itemProd->nota
                                                ];
                            }
                        } 
                    } else {
                        $otros [] =  [
                                                    'Cliente'  => $item->nombre,
                                                    'Producto' => $itemProd->nota,
                                                    'Cantidad' => number_format($itemProd->cantidad, 2)
                                                ];
                    }
                                       
                }
            }

            $frutas = [];
            $verduras = [];
            $cereales = [];            
            $abarrotes = [];
            foreach ($productos as $producto) {
                if($producto['Fraccionario']){
                    $producto['Cantidad'] = number_format($producto['Cantidad'], 2);
                }
                unset($producto['Fraccionario']);
                if ($producto['Categoria'] == "Frutas") {
                    $frutas [] = $producto;
                } else if ($producto['Categoria'] == "Verduras") {
                    $verduras [] = $producto;
                } else if ($producto['Categoria'] == "Cereales") {
                    $cereales [] = $producto;
                } else if ($producto['Categoria'] == "Abarrotes") {
                    $abarrotes [] = $producto;
                }
            }
            $encabezados = array();
            $titulos     = array();

            $rows [] = ['Fecha:', date('d/m/Y'), ''];            
            $total = 0;

            if ($frutas) {
                $rows []        = ['', '', ''];
                $rows []        = ['Frutas:', '', ''];
                $titulos []     = count($rows);
                $rows []        = ['Producto', 'Unidad', 'Cantidad', '', 'Notas'];
                $encabezados [] = count($rows);
                foreach ($frutas as $producto) {
                    $total = $total + $producto['Cantidad'];
                    unset($producto['Categoria']);                    
                    $rows [] = $producto;
                }
            }

            if ($verduras) {
                $rows []        = ['', '', ''];
                $rows []        = ['Verduras:', '', ''];
                $titulos []     = count($rows);
                $rows []        = ['Producto', 'Unidad', 'Cantidad', '', 'Notas'];
                $encabezados [] = count($rows);
                foreach ($verduras as $producto) {
                    $total = $total + $producto['Cantidad'];
                    unset($producto['Categoria']);
                    $rows [] = $producto;
                }
            }

            if ($cereales) {
                $rows []        = ['', '', ''];
                $rows []        = ['Cereales:', '', ''];
                $titulos []     = count($rows);
                $rows []        = ['Producto', 'Unidad', 'Cantidad', '', 'Notas'];
                $encabezados [] = count($rows);
                foreach ($cereales as $producto) {
                    $total = $total + $producto['Cantidad'];
                    unset($producto['Categoria']);
                    $rows [] = $producto;
                }
            }      

            if ($abarrotes) {
                $rows []        = ['', '', ''];
                $rows []        = ['Abarrotes:', '', ''];
                $titulos []     = count($rows);
                $rows []        = ['Producto', 'Unidad', 'Cantidad', '', 'Notas'];
                $encabezados [] = count($rows);
                foreach ($abarrotes as $producto) {
                    $total = $total + $producto['Cantidad'];
                    unset($producto['Categoria']);
                    $rows [] = $producto;
                }
            }       

            if ($lacteos) {
                $rows []        = ['', '', ''];
                $rows []        = ['Lácteos:', '', ''];
                $titulos []     = count($rows);
                $rows []        = ['Cliente', 'Producto', 'Unidad', 'Cantidad', 'Nota'];
                $encabezados [] = count($rows);
                foreach ($lacteos as $producto) {
                    $total = $total + $producto['Cantidad'];
                    unset($producto['Categoria']);
                    $rows [] = $producto;
                }
            } 

            if ($carnicos) {
                $rows []        = ['', '', ''];
                $rows []        = ['Carnicos:', '', ''];
                $titulos []     = count($rows);
                $rows []        = ['Cliente', 'Producto', 'Unidad', 'Cantidad', 'Nota'];
                $encabezados [] = count($rows);
                foreach ($carnicos as $producto) {
                    $total = $total + $producto['Cantidad'];
                    unset($producto['Categoria']);
                    $rows [] = $producto;
                }
            }           

            if ($otros) {
                $rows []        = ['', '', ''];
                $rows []        = ['Otros:', '', ''];
                $titulos []     = count($rows);
                $rows []        = ['Cliente', 'Producto', 'Cantidad'];
                $encabezados [] = count($rows);
                foreach ($otros as $producto) {
                    $total = $total + $producto['Cantidad'];
                    $rows [] = $producto;
                }
            }  

            $rows [] = ['', '', ''];
            $rows [] = ['', 'Total de productos:', number_format($total,2)];
            $rows [] = ['', 'Total de pedidos:', count($items)];

            $fileName = 'Listado de productos pedidos '.date('d-m-Y').'.xlsx';

            Excel::store(new PedidosExport($rows, $titulos, $encabezados), $fileName);
                        
            $params['subject'] = 'Listado de productos pedidos';
            $params['content'] = 'Se le ha enviado un reporte de Listado de productos pedidos del día '.date('d/m/Y').' a su correo electrónico.';
            $params['email'] = explode(",", 'geomarket.pedidos@gmail.com');
            $params['files'] = $fileName;

            Mail::send('mails.pedidos', ['content' => $params], function ($message) use($params)
            {
                $message->to($params['email']);
                $message->from(env('MAIL_USERNAME'), 'GEO MARKET');
                $message->subject('GEO MARKET | '.$params['subject']);
                $message->attach(storage_path('app/'.$params['files']));
            });
            if ( !Mail::failures() ){
                File::delete(storage_path('app/'.$fileName));
                return response(['msg' => 'Pedidos enviado correctamente.', 'url' => url('pedidos'), 'status' => 'success'], 200);
            } else {
                return response(['msg' => 'Error al enviar correo. Favor de volver a intentarlo.', 'status' => 'error', 'url' => url('pedidos')], 404); 
            }
        } else {
            return redirect()->to('/login');
        }
    }
}
