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
                    <form action="{{$result->id_teacher}}" method="POST">
                        <span class="register-form-title"><p>{{$result->name . ' ' . $result->surname}}</p> </span>

                        <div class="wrap-input validate-input">
                                <input 
                                    class="input-register @if($result->errorUserName != '') validation-error @endif"
                                    title="@if($result->errorUserName != '') {{ $result->errorUserName }} @endif"
                                    value="{{ $result->username }}"
                                    type="text" 
                                    name="username" 
                                    placeholder="Nombre de usuario" 
                                    required>
                                <span class="focus-input"></span>
                                <span class="icon-input">
                                <i class="fa fa-pencil" aria-hidden="true"></i>
                            </span>
                        </div>

                        <div class="wrap-input validate-input">
                            <input class="input-register" type="text" name="name" placeholder="Nombre" 
                            value="{{ $result->name }}"required>
                            <span class="focus-input"></span>
                            <span class="icon-input">
                            <i class="fa fa-pencil" aria-hidden="true"></i>
                        </span>
                        </div>

                        <div class="wrap-input validate-input">
                            <input class="input-register" type="text" name="surname" placeholder="Apellidos" 
                            value="{{ $result->surname }}" required>
                            <span class="focus-input"></span>
                            <span class="icon-input">
                            <i class="fa fa-pencil" aria-hidden="true"></i>
                        </span>
                        </div>

                        <div class="wrap-input validate-input">
                                <input 
                                    class="input-register @if($result->errorNIF != '') validation-error @endif"
                                    title="@if($result->errorNIF != '') {{ $result->errorNIF }} @endif"
                                    value="{{ $result->nif }}"
                                    type="text" 
                                    name="nif" 
                                    placeholder="DNI" 
                                    required>
                                <span class="focus-input"></span>
                                <span class="icon-input">
                                <i class="fa fa-pencil" aria-hidden="true"></i>
                            </span>
                        </div>

                        <div class="wrap-input validate-input">
                            <input 
                                class="input-register @if($result->errorEmail != '') validation-error @endif"
                                title="@if($result->errorEmail != '') {{ $result->errorEmail }} @endif"
                                value="{{ $result->email }}"
                                type="email" 
                                name="email" 
                                placeholder="Email" 
                                required>
                            <span class="focus-input"></span>
                            <span class="icon-input">
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                            </span>
                        </div>

                        <div class="wrap-input validate-input">
                            <input class="input-register" type="tel" name="telephone" placeholder="Teléfono" 
                            value="{{ $result->telephone }}" required>
                            <span class="focus-input"></span>
                            <span class="icon-input">
                            <i class="fa fa-phone" aria-hidden="true"></i>
                        </span>
                        </div>
                        <br>
                        <div class="register-error">
                            <p>El password por defecto de los profesores es 123</p>
                        </div>
                        @if($result->validationErrors > 0)
                            <div class="register-error">
                                <p>Revise los campos marcados e inténtelo de nuevo</p>
                            </div>
                        @endif
                        <div class="btn-register">
                            <input type="submit" class="register-form-btn" name="submit" value="Guardar"></input>
                        </div>
                        <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                        <p><a href="{{url('/teachers')}}">Cancelar</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@include("common.footer")