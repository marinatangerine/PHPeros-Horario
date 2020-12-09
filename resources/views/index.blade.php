@include("common.header")
@if(!Session::has('role'))
<div class="limiter">
    <div class="container-login">
        <div class="wrap-login">
            <div class="login-pic">
                <img src="{{ asset('/img/img-02.png') }}" alt="Imagen Login">
            </div>
            <form action="login" method="POST" class = "login-form validate-form col-6">
                <span class="login-form-title"><p> Accede a PHPeros School</p> </span>

                <div class="wrap-input validate-input">
                    <input class="input-login" type="email" name="email" placeholder="Email" required>
                    <span class="focus-input"></span>
                    <span class="icon-input">
                        <i class="fa fa-envelope" aria-hidden="true"></i>
                    </span>
                </div>
                <br>
                <div class="wrap-input validate-input">
                    <input class="input-login" type="password" name="pass" placeholder="Contraseña" required>
                    <span class="focus-input"></span>
                    <span class="icon-input">
                        <i class="fa fa-lock" aria-hidden="false"></i>
                    </span>
                </div>
                <div class="login-error">
                    <p>{{ $errorLogin }}</p>
                </div>
                <div class="btn-login">
                    <input type="submit" class="login-form-btn" name="submit" value="Entrar"></input>
                </div>
                <div class="register">
                    <span><a href="signup"> <p>Regístrate </a>para formar parte de nuestra comunidad</p> </span>
                </div>
                <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
            </form>
        </div>
    </div>
</div>
@else
<div class="limiter">
    <div class="title-register">
    @switch(Session::get('role'))
        @case(1)
            <h1>Panel de administrador</h1>
            @break
        @case(2)
            <h1>Panel de profesor</h1>
            @break
        @case(3)
            <h1>Panel de estudiante</h1>
            @break
    @endswitch
    </div>
</div>
@endif
@include("common.footer")