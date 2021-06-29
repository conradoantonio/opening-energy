<table class="table table-hover table-sm data-table">
    <thead>
        <tr>
            <th class="d-none">ID</th>
            <th>Nombre</th>
            <th>Correo electrónico</th>
            <th>Teléfono</th>
            <th class="text-center">Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($items as $item)
            <tr>
                <td class="align-middle d-none">{{$item->id}}</td>
                <td class="align-middle">{{$item->nombre}}</td>
                <td class="align-middle">{{$item->email}}</td>
                <td class="align-middle">{{$item->telefono}}</td>
                <td class="text-center align-middle">
                    <button class="btn btn-dark btn-sm edit-row" data-row="{{$item}}" data-toggle="tooltip" data-target="#editForm" data-placement="top" title="Editar"><i class="mdi mdi-square-edit-outline"></i></button>
                    <button class="btn btn-primary btn-sm edit-product" data-row="{{$item}}" data-toggle="tooltip" data-target="#productosEdit" data-placement="top" title="Productos"><i class="mdi mdi-dropbox"></i></button>
                    <button class="btn btn-secondary btn-sm edit-direcci" data-row="{{$item}}" data-toggle="tooltip" data-target="#direccionesEdit" data-placement="top" title="Direcciones"><i class="mdi mdi-home-city"></i></button>
                    <!--<button class="btn btn-danger btn-sm delete-row" data-row-id="{{$item->id}}" data-toggle="tooltip" data-placement="top" title="Eliminar"><i class="mdi mdi-trash-can"></i></button>-->
                </td>
            </tr>
        @endforeach
    </tbody>
</table>