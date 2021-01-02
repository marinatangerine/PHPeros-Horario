@include("common.header")
<div class="limiter">
    <div class="title-register">
        <h1>{{$result->formTitle}}</h1>
    </div>
    <div class="container-register">
        <div class="wrap-register">
            <div class="half-wrapper">
                <div class="big-icon"><i class="fa fa-user" aria-hidden="true"></i></div>
            </div>
            <div class="half-wrapper">
                <div class="form-body">
                    <form action="{{$result->id_class}}" method="POST">
                        <span class="register-form-title"><p>{{$result->name}}</p> </span>
                        <div class="wrap-input validate-input">
                            <input class="input-register" type="text" name="name" placeholder="Nombre" 
                            value="{{ $result->name }}"required>
                            <span class="focus-input"></span>
                            <span class="icon-input">
                            <i class="fa fa-pencil" aria-hidden="true"></i>
                            </span>
                        </div>

                        <div class="wrap-input validate-input">
                            @if(count($result->teachers) > 0 || $result->id_teacher)
                                <label for="id_teacher">Profesor</label><select name="id_teacher" class="input-register" placeholder="Profesor">
                                @if($result->id_teacher)
                                    <option value="{{$result->id_teacher}}">{{$result->name_teacher}}</option>
                                @endif
                                @foreach($result->teachers as $item)
                                    <option value="{{$item->id}}" @if($result->id_teacher == $item->id) selected=selected @endif >{{$item->name}}</option>
                                @endforeach
                                </select>
                            @else
                                No hay profesores disponibles
                            @endif
                        </div>

                        <div class="wrap-input validate-input">
                            @if(count($result->courses) > 0 || $result->id_course)
                                <label for="id_course">Curso</label><select name="id_course" class="input-register" placeholder="Curso">
                                @foreach($result->courses as $item)
                                    <option value="{{$item->id}}" @if($result->id_course == $item->id) selected=selected @endif>{{$item->name}}</option>
                                @endforeach
                                </select>
                            @else
                                No hay cursos disponibles
                            @endif
                        </div>

                        <div class="wrap-input validate-input">
                            @if(count($result->colors) > 0 || $result->color)
                                <label for="name">Color</label><select name="color" class="input-register" placeholder="Color">
                                @if($result->color)
                                    <option value="{{$result->color}}">{{$result->color}}</option>
                                @endif
                                @foreach($result->colors as $item)
                                    <option value="{{$item->name}}" @if($result->color == $item->name) selected=selected @endif>{{$item->name}}</option>
                                @endforeach
                                </select>
                            @else
                                No hay colores disponibles
                            @endif
                        </div>
                        <br>
                        @if($result->emptyDropDowns > 0)
                            Faltan datos para poder crear una clase
                        @else
                        <div class="btn-register">
                            <input type="submit" class="register-form-btn" name="submit" value="Guardar"></input>
                        </div>
                        @endif
                        <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                        <p><a href="{{url('/subjects')}}">Cancelar</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@include("common.footer")