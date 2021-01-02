@include("common.header")
<div class="limiter">
    <div class="title-register">
        <h1>{{$result->name_class}}</h1>
    </div>
    <div class="container-register">
        <div class="wrap-register">
        <div class="half-wrapper">
                <div class="big-icon"><i class="fa fa-calendar" aria-hidden="true"></i></div>
            </div>
            <div class="half-wrapper">
                <div class="form-body">
                    <form action="{{url('/subjects')}}/{{$result->id_class}}/schedule" method="POST">
                        <span class="register-form-title"><p>Programar clase {{$result->course_start}} - {{$result->course_end}}</p> </span>
                        <div class="wrap-input validate-input">
                            <input 
                                class="input-register @if($result->dateError != '') validation-error @endif"
                                    title="@if($result->dateError != '') {{$result->dateError}} @endif"
                                    value="{{ $result->day }}" 
                                    type="date" 
                                    name="day" 
                                    placeholder="Fecha" 
                                    required>
                        </div>

                        <div class="wrap-input validate-input">
                            <input 
                                class="input-register @if($result->timeError != '') validation-error @endif"
                                title="@if($result->timeError != '') {{$result->timeError}} @endif"
                                value="{{ $result->time_start }}"
                                type="time" 
                                name="time_start" 
                                placeholder="Hora inicio" 
                                required>
                        </div>

                        <div class="wrap-input validate-input">
                            <input 
                                class="input-register @if($result->timeError != '') validation-error @endif"
                                title="@if($result->timeError != '') {{$result->timeError}} @endif"
                                value="{{ $result->time_end }}"
                                type="time" 
                                name="time_end" 
                                placeholder="Hora fin" 
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
                    @elseif($result->dateError || $result->timeError)
                        <div class="register-error">
                            <p>Revise los campos marcados e inténtelo de nuevo</p>
                        </div>
                    @endif
                    <p><a href="{{url('/subjects')}}">Volver</a></p>
                </div>
            </div>
            @if(count($result->items) > 0)
                <div><span class="register-form-title"><p>Programación actual</p> </span></div>
                <table class="data-table"><tr>
                <th>Fecha</th><th>Hora inicio</th><th>Hora fin</th><th>Curso</th><th>Profesor</th><th>Acciones</th>
                </tr>
                @foreach($result->items as $item)
                    <tr>
                    <td>{{$item->day}}</td><td>{{$item->time_start}}</td><td>{{$item->time_end}}</td><td>{{$item->course_name}}</td><td>{{$item->teacher_name}}</td><td>
                    <a class="icon" href="{{url('/schedules')}}/{{$item->id_schedule}}/delete"><i class="fa fa-trash" aria-hidden="true"></i></a>
                    </td>
                    </tr>
                @endforeach
                </table>
            @endif
        </div>
    </div>
</div>
@include("common.footer")