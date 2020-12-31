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
                            @if(count($result->teachers) > 0)
                                <label for="id_teacher">Profesor</label><select name="id_teacher" class="input-register" placeholder="Profesor">
                                @foreach($result->teachers as $item)
                                    <option value="{{$item->id_teacher}}" @if($result->id_teacher == $item->id_teacher) selected=selected @else selected='' @endif>{{$item->name}}</option>
                                @endforeach
                                </select>
                            @elseif
                                No hay profesores disponibles
                            @endif
                        </div>

                        <div class="wrap-input validate-input">
                            
                        </div>

                        <div class="wrap-input validate-input">
                            
                        </div>

                        <div class="wrap-input validate-input">
                            <span>Activo</span>
                            <input class="input-register" type="checkbox" name="active" placeholder="Activo" @if($result->active) checked @endif value="1">
                            <span class="focus-input"></span>
                        </div>
                        <br>
                        @if($result->validationErrors > 0)
                            <div class="register-error">
                                <p>Revise los campos marcados e inténtelo de nuevo</p>
                            </div>
                        @endif
                        <div class="btn-register">
                            <input type="submit" class="register-form-btn" name="submit" value="Guardar"></input>
                        </div>
                        <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                        <p><a href="{{url('/courses')}}">Cancelar</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@include("common.footer")