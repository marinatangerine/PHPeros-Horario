@include("common.header")
<div class="limiter">
    <div class="title-register">
        <h1>Calificaciones - {{$data->name}}</h1>
    </div>
    <div class="container-register">
        <div class="wrap-register">
            @if(count($data->items) > 0)
            <form style="width:100%" action="{{url($data->action)}}/{{$data->id}}/marks" method="POST">
                <table class="data-table">
                    <tr>
                        <th>#</th><th>Nombre</th><th>Apellidos</th><th>NIF</th><th>Calificación</th>
                    </tr>
                    @foreach($data->items as $item)
                    <tr>
                        <td>{{$item->id_student}}</td><td>{{$item->name}}</td><td>{{$item->surname}}</td><td>{{$item->nif}}</td>
                        <td>
                            <input 
                                class="input-register"
                                    value="{{ $item->mark }}" 
                                    type="number" 
                                    name="mark-{{$item->id_student}}" 
                                    min="0"
                                    max="10.00"
                                    step=".01"
                                    placeholder="Calificación" >
                        </td>
                    </tr>
                    @endforeach
                </table>
                <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                <br/>
                @if($data->success)
                    <div class="register-success">
                        <p>Cambios guardados correctamente</p>
                    </div>
                @endif
                <div class="btn-register">
                    <input type="submit" class="register-form-btn" name="submit" value="Guardar"></input>
                </div>
                <p style="text-align: center"><a href="{{url('/subjects')}}/{{$data->id_class}}/{{$data->back}}">Volver</a></p>
            </form>
            @else
                No hay alumnos matriculados en el curso
            @endif
        </div>
    </div>
</div>
@include("common.footer")