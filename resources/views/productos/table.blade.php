<table class="table table-hover table-sm data-table">
    <thead>
        <tr>
            <th class="d-none">ID</th>
            <th>Nombre</th>
            <th>Precio base</th>
            <th>Precio A</th>
            <th>Precio B</th>
            <th>Precio C</th>
            <th>Precio D</th>
            <th>Precio E</th>
            <th class="text-center">Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($items as $item)
            <tr>
                <td class="align-middle d-none">{{$item->id}}</td>
                <td class="align-middle">{{$item->nombre}}</td>
                <td class="align-middle">${{number_format($item->precio_base, 2)}}</td>
                <td class="align-middle">${{number_format($item->precio_a, 2)}}</td>
                <td class="align-middle">${{number_format($item->precio_b, 2)}}</td>
                <td class="align-middle">${{number_format($item->precio_c, 2)}}</td>
                <td class="align-middle">${{number_format($item->precio_d, 2)}}</td>
                <td class="align-middle">${{number_format($item->precio_e, 2)}}</td>
                <td class="text-center align-middle">
                    <button class="btn btn-dark btn-sm edit-row" data-row="{{$item}}" data-toggle="tooltip" data-target="#editForm" data-placement="top" title="Editar"><i class="mdi mdi-square-edit-outline"></i></button>
                    <button class="btn btn-danger btn-sm delete-row" data-row-id="{{$item->id}}" data-toggle="tooltip" data-placement="top" title="Eliminar"><i class="mdi mdi-trash-can"></i></button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>