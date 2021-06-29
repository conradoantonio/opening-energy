<html>
    <head></head>
    <body>
        <div style="text-align: justify; padding: 2% 10%;background: whitesmoke; color: #242442;">
                    <img src="{{asset('img/logo.jpeg')}}" style='width: 100%; max-width: 135px;'>
            <table style="width: 100%; padding: 0 0 20px; border-bottom: 1px solid #e6e6e6; border-bottom-color: rgb(230, 230, 230);">
                <tbody>
                    <tr>
                        <td>
                            <div>
                                <div style="font-weight: bold; width: 85px; float: left;">Nombre:</div>
                                <div>{{$content['pedido']->user->nombre}}</div>
                            </div>
                            <div>
                                <div style="font-weight: bold; width: 85px; float: left;">Teléfono:</div>
                                <div>{{$content['pedido']->user->telefono}}</div>
                            </div>
                            <div>
                                <div style="font-weight: bold; width: 85px; float: left;">Email:</div>
                                <div>{{$content['pedido']->user->email}}</div>
                            </div>
                            <div>
                                <div style="font-weight: bold; width: 85px; float: left;">Dirección:</div>
                                <div>{{$content['pedido']->direccion}}</div>
                            </div>
                            <div>
                                <div style="font-weight: bold; width: 85px; float: left;">Flete:</div>
                                <div>{{$content['direccion']->flete}} - ${{number_format($content['direccion']->importe_flete, 4)}}</div>
                            </div>
                            <div>
                                <div style="font-weight: bold; width: 85px; float: left;">Entrega:</div>
                                <div>{{$content['pedido']->fecha_entrega}}</div>
                            </div>
                        </td>
                        <td style="width: 115px; text-align: right;">
                            <div>
                                <h3 style="font-weight: bold; margin: 0;">Folio - {{$content['pedido']->id}}</h3>
                            </div>
                            <div>
                                {{$content['pedido']->created_at}}
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>

            @foreach($content['productos'] as $item)
                <div style="color: #000; padding: 20px 0 32px;border-bottom: 1px solid #e6e6e6;border-bottom-width: 1px;border-bottom-style: solid;border-bottom-color: rgb(230, 230, 230);">
                    <div style="display: flex!important; align-items: center !important;">
                        <div style="max-width: 100%; width: 100%;">
                            <div style="color: #000; font-weight: bold;">
                                {{$item->producto}}
                            </div>
                        </div>
                        <div style="max-width: 100%; width: 100%;">
                            <div style="display: flex!important; align-items: center !important;">
                                <div style="color: #000; font-size: 18px;max-width: 100%;width: 100%;">
                                    {{number_format($item->cantidad,0)}}
                                </div>
                                <div>
                                    <span style="color: #000; font-size: 24px;">
                                        ${{number_format($item->costo, 4)}}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <div style="color: #000;padding: 14px 0 32px;border-bottom: 1px solid #e6e6e6;border-bottom-width: 1px;border-bottom-style: solid;border-bottom-color: rgb(230, 230, 230);">
                <div class="row align-items-center" style="display: flex!important; align-items: center !important;">
                    <div class="col-12" style="max-width: 100%; width: 100%;">
                        <span class="font-weight-bold float-right" style="color: #000; float:right; font-weight: bold; font-size: 22px;">
                            Total: ${{number_format($content['pedido']->total, 4)}}
                        </span>
                    </div>
                </div>
            </div>

        </div>
        <div style="text-align:center; background:#b5770d; font-size:15px; font-weight:900; padding:6px 0px; color: floralwhite">
            <span>Desarrollado por Bridge Studio</span>
        </div>
    </body>
</html>