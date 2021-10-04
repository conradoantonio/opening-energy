<table class="table table-hover table-sm data-table" id="table-pedi">
    <thead>
        <tr>
            <th>Folio</th>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Dirección</th>
            <th>Teléfono</th>
            <th>Fecha - Hora</th>
            <th>Fecha de entrega</th>
            <th>Total</th>
            <th>Estado</th>            
            <th class="text-center">Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($items as $item)
            <tr>
                <td class="align-middle">{{$item->id}}</td>
                <td class="align-middle">{{$item->user->nombre}}</td>
                <td class="align-middle">{{$item->user->email}}</td>
                <td class="align-middle">{{$item->direccion}}</td>
                <td class="align-middle">{{$item->user->telefono}}</td>
                <td class="align-middle">{{$item->created_at}}</td>
                <td class="align-middle">{{$item->fecha_entrega}}</td>
                <td class="align-middle">${{number_format($item->total, 2)}}</td>
                @if($item->status == 'pendiente')
                <td class="align-middle"><span class="badge bg-danger" style="font-size: 13px; color: white; text-transform: capitalize;">{{$item->status}}</span></td>
                @else
                <td class="align-middle"><span class="badge bg-success" style="font-size: 13px; color: black; text-transform: capitalize;">{{$item->status}}</span></td>
                @endif
                <td class="text-center align-middle">
                    @if (Auth::user()->tipo_usuario === 1)
                    <!--<button class="btn btn-primary btn-sm print-row" data-row="{{$item}}" data-toggle="tooltip" data-target="#viewForm" data-placement="top" title="Imprimir"><i class="mdi mdi-printer"></i></button>-->
                    <button class="btn btn-secondary btn-sm details-row" data-row="{{$item}}" data-toggle="tooltip" data-target="#detailsForm" data-placement="top" title="Completar documentación"><i class="mdi mdi-file-document"></i></button>
                    <button class="btn btn-info btn-sm change-address" data-row="{{$item}}" data-toggle="tooltip" data-target="#detailsForm" data-placement="top" title="Cambiar dirección"><i class="mdi mdi-truck-delivery"></i></button>
                    <button class="btn btn-danger btn-sm delete-row" data-row-id="{{$item->id}}" data-toggle="tooltip" data-placement="top" title="Eliminar"><i class="mdi mdi-trash-can"></i></button>
                    @endif
                    <button class="btn btn-dark btn-sm edit-row" data-row="{{$item}}" data-toggle="tooltip" data-target="#viewForm" data-placement="top" title="Ver detalles"><i class="mdi mdi-eye"></i></button>
                    @if (Auth::user()->tipo_usuario === 2)
                    <button class="btn btn-secondary btn-sm details-row" data-row="{{$item}}" data-toggle="tooltip" data-target="#detailsForm" data-placement="top" title="Ver documentación"><i class="mdi mdi-file-document"></i></button>
                    @endif
                    @if (Auth::user()->tipo_usuario === 1 && $item->status == 'pendiente')
                    <button class="btn btn-success btn-sm aprov-row" data-row="{{$item}}" data-toggle="tooltip" title="Pedido atendido"><i class="mdi mdi-check"></i></button>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>