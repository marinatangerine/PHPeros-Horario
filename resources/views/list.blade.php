@include("common.header")
<div class="limiter">
    <div class="title-register">
        <h1>{{$data->listName}}</h1>
    </div>
    <div class="container-register">
        <div class="wrap-register">
        @if(Session::get('role') === 1)
            <div class="add-items-actions">
                <a href="{{$data->editItemUrl}}/new">{{$data->newItemText}}</a>
            </div>
        @endif
        @if(count($data->items) > 0)
            <table class="data-table">
                <tr>
                    @switch($data->itemType)
                        @case('teacher')
                            <th>#</th><th>Nombre</th><th>Apellidos</th><th>Teléfono</th><th>NIF</th><th>Email</th><th>Acciones</th>
                            @break
                        @case('class')
                            <th>#</th><th>Nombre</th><th>Color</th><th>Profesor</th><th>Curso</th><th>Acciones</th>
                            @break
                        @case('course')
                            @if(Session::get('role') === 1)
                                <th>#</th><th>Nombre</th><th>Descripción</th><th>Fecha Inicio</th><th>Fecha Fin</th><th>Activo</th><th>Acciones</th>
                            @else
                                <th>#</th><th>Nombre</th><th>Descripción</th><th>Fecha Inicio</th><th>Fecha Fin</th><th>Matriculado</th><th>Acciones</th>
                            @endif
                            @break
                    @endswitch
                </tr>
                @foreach ($data->items as $item)
                    <tr>
                        @switch($data->itemType)
                            @case('teacher')
                                <td>{{$item->id_teacher}}</td><td>{{$item->name}}</td><td>{{$item->surname}}</td><td>{{$item->telephone}}</td><td>{{$item->nif}}</td><td>{{$item->email}}</td>
                                <td>
                                    <a class="icon" href="{{$data->editItemUrl}}/{{$item->id_teacher}}"><i class="fa fa-edit" aria-hidden="true"></i></a>
                                    <a class="icon" href="{{$data->editItemUrl}}/{{$item->id_teacher}}/delete"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                </td>
                                @break
                            @case('class')
                                <td>{{$item->id_class}}</td><td>{{$item->name}}</td><td>{{$item->color}}</td><td>{{$item->teacherName}}</td><td>{{$item->courseName}}</td>
                                <td>
                                    <a class="icon" href="{{$data->editItemUrl}}/{{$item->id_class}}"><i class="fa fa-edit" aria-hidden="true"></i></a>
                                    <a class="icon" href="{{$data->editItemUrl}}/{{$item->id_class}}/delete"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                    @if($item->courseActive == 1)
                                        <a class="icon" href="{{$data->editItemUrl}}/{{$item->id_class}}/schedule"><i class="fa fa-calendar" aria-hidden="true"></i></a>
                                    @endif
                                </td>
                                @break
                            @case('course')
                                @if(Session::get('role') === 1)
                                    <td>{{$item->id_course}}</td><td>{{$item->name}}</td><td>{{$item->description}}</td><td>{{$item->date_start}}</td><td>{{$item->date_end}}</td>
                                    <td>
                                        @if($item->active == 1)
                                            <td class="status-icon ok"><span class="icon"><i class="fa fa-check fa-sm" aria-hidden="true"></i></span></td>
                                        @else
                                            <td class="status-icon nok"><span class="icon"><i class="fa fa-check fa-sm" aria-hidden="true"></i></span></td>
                                        @endif
                                    </td>
                                    <td>
                                        <a class="icon" href="{{$data->editItemUrl}}/{{$item->id_course}}"><i class="fa fa-edit" aria-hidden="true"></i></a>
                                        <a class="icon" href="{{$data->editItemUrl}}/{{$item->id_course}}/delete"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                    </td>
                                @elseif(Session::get('role') === 3)
                                    <td>{{$item->id_course}}</td><td>{{$item->name}}</td><td>{{$item->description}}</td><td>{{$item->date_start}}</td><td>{{$item->date_end}}</td>
                                    <td>
                                        @if($item->status == 1)
                                            <td class="status-icon ok"><span class="icon"><i class="fa fa-check fa-sm" aria-hidden="true"></i></span></td>
                                        @else
                                            <td class="status-icon nok"><span class="icon"><i class="fa fa-check fa-sm" aria-hidden="true"></i></span></td>
                                        @endif
                                    </td>
                                    <td>
                                        <a class="icon" href="{{$data->editItemUrl}}/{{$item->id_course}}/enroll"><i class="fa fa-sign-in" aria-hidden="true"></i></a>
                                    </td>
                                @endif
                                @break
                        @endswitch
                    </tr>
                @endforeach
            </table>
        @else
            No hay datos para mostrar
        @endif
        </div>
    </div>
</div>
@include("common.footer")