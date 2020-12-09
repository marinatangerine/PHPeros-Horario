@include("common.header")
@if(!Session::has('role') || $result->success)
<div class="limiter">
<div class="title-register">
    <h1> Conviértete en PHPero<br/></h1>
</div>
<div class="container-register">
    <div class="wrap-register">
        <div class="half-wrapper">
            <div class="big-icon"><i class="fa fa-bug" aria-hidden="true"></i></div>
        </div>
        <div class="half-wrapper">
            <div class="form-body">
            @if(!$result->success)
                <form action="signup" method="POST">
                    <span class="register-form-title"><p>Registro de alumnos</p> </span>
                    
                    <div class="wrap-input validate-input">
                        <input 
                            class="input-register @if($result->errorUsername != '') validation-error @endif"
                            title="@if($result->errorUsername != '') {{ $result->errorUsername }} @endif"
                            value="{{ $result->username }}"
                            type="text" 
                            name="username" 
                            placeholder="Nombre de usuario" 
                            required>
                        <span class="focus-input"></span>
                        <span class="icon-input">
                        <i class="fa fa-child" aria-hidden="true"></i>
                    </span>
                    </div>

                    <div class="wrap-input validate-input">
                        <input class="input-register" type="text" name="name" placeholder="Nombre" value="{{ $result->name }}" required>
                        <span class="focus-input"></span>
                        <span class="icon-input">
                        <i class="fa fa-pencil" aria-hidden="true"></i>
                    </span>
                    </div>

                    <div class="wrap-input validate-input">
                        <input class="input-register" type="text" name="surname" placeholder="Apellidos" value="{{ $result->surname }}" required>
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
                        <input class="input-register" type="tel" name="telephone" placeholder="Teléfono" value="{{ $result->telephone }}" required>
                        <span class="focus-input"></span>
                        <span class="icon-input">
                        <i class="fa fa-phone" aria-hidden="true"></i>
                    </span>
                    </div>

                    <div class="wrap-input validate-input">
                        <input class="input-register" type="password" name="pass" placeholder="Contraseña" required>
                        <span class="focus-input"></span>
                        <span class="icon-input">
                        <i class="fa fa-lock" aria-hidden="false"></i>
                    </span>
                    </div>

                    <br>
                    @if($result->validationErrors > 0)
                        <div class="register-error">
                            <p>Revise los campos marcados e inténtelo de nuevo</p>
                        </div>
                    @elseif($result->serverError != '')
                        <div class="register-error">
                            <p>Error interno de servidor: {{ $result->serverError }}</p>
                        </div>
                    @endif
                    <div class="btn-register">
                        <input type="submit" class="register-form-btn" name="submit" value="Registrarse"></input>
                    </div>
                    <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                </form>
            @else
                <div class="register-success">
                    <p>Registro completado. Bienvenido a PHPeros</p>
                    <p>Está siendo redireccionado a la página de login. Si no es redirigido automáticamente pulse <a href="index">aquí</a></p>
                    <script language="javascript">setTimeout(function(){window.location.href="index";}, 5000);</script>
                </div>
            @endif
            </div>
        </div>
    </div>
</div>
@else
<div class="limiter">
    <div class="title-register">
        <p>Ya está logado en PHPeros</p>
    </div>
</div>
@endif
@include("common.footer")