@include("common.header")
<div class="limiter">
    <div class="title-register">
        <h1>{{$result->name_class}}</h1>
    </div>
    <div class="container-register">
        <div class="wrap-register">
        <div class="half-wrapper">
                <div class="big-icon"><i class="fa fa-book" aria-hidden="true"></i></div>
            </div>
            <div class="half-wrapper">
                <div class="form-body">
                    <form action="{{url('/subjects')}}/{{$result->id_class}}/schedulework" method="POST">
                        <span class="register-form-title"><p>Crear trabajo {{$result->course_start}} - {{$result->course_end}}</p> </span>
                        <div class="wrap-input validate-input">
                            <input 
                                class="input-register @if($result->dateError != '') validation-error @endif"
                                    title="@if($result->dateError != '') {{$result->dateError}} @endif"
                                    value="{{ $result->date }}" 
                                    type="datetime-local" 
                                    name="date" 
                                    placeholder="Fecha entrega" 
                                    required>
                        </div>

                        <div class="wrap-input validate-input">
                            <input 
                                class="input-register"
                                value="{{ $result->name }}"
                                type="text" 
                                name="name" 
                                placeholder="Nombre" 
                                required>
                        </div>

                        <br>
                        <div class="btn-register">
                            <input type="submit" class="register-form-btn" name="submit" value="Guardar"></input>
                        </div>
                        <input name="min_date" type="hidden" value="{{$result->course_start}}"/>
                        <input name="max_date" type="hidden" value="{{$result->course_end}}"/>
                        <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                    </form>
                    @if($result->success)
                        <div class="register-success">
                            <p>Cambios guardados correctamente</p>
                        </div>
                    @elseif($result->dateError)
                        <div class="register-error">
                            <p>Revise los campos marcados e inténtelo de nuevo</p>
                        </div>
                    @endif
                    <p><a href="{{url('/subjects')}}">Volver</a></p>
                </div>
            </div>
            @if(count($result->items) > 0)
                <div><span class="register-form-title"><p>Calendario de trabajos</p> </span></div>
                <table class="data-table"><tr>
                <th>Fecha</th><th>Nombre</th><th>Curso</th><th>Profesor</th><th>Acciones</th>
                </tr>
                @foreach($result->items as $item)
                    <tr>
                    <td>{{$item->date}}</td><td>{{$item->name}}</td><td>{{$item->course_name}}</td><td>{{$item->teacher_name}}</td><td>
                    <a class="icon" href="{{url('/works')}}/{{$item->id_work}}/delete"><i class="fa fa-trash" aria-hidden="true"></i></a>
                    <a class="icon" href="{{url('/works')}}/{{$item->id_work}}/marks"><i class="fa fa-institution" aria-hidden="true"></i></a>
                    </td>
                    </tr>
                @endforeach
                </table>
            @endif
        </div>
    </div>
</div>
@include("common.footer")