@include("common.header")
<div class="limiter">
    <div class="title-register">
        <h1>Porcentajes evaluación</h1>
    </div>
    <div class="container-register">
        <div class="wrap-register">
            <div class="half-wrapper">
                <div class="big-icon"><i class="fa fa-bar-chart" aria-hidden="true"></i></div>
            </div>
            <div class="half-wrapper">
                <div class="form-body">
                    <form action="{{url('/subjects')}}/{{$result->id_class}}/percentages" method="POST">
                        <span class="register-form-title"><p>{{$result->name}}</p> </span>

                        <div class="wrap-input validate-input">
                            <input class="input-register" type="number" min="0" max="100" step="1" name="continuous_assessment" placeholder="Evaluación contínua" 
                            value="{{ $result->continuous_assessment }}" required>
                            <span class="focus-input"></span>
                            <span class="icon-input">
                            <i class="fa fa-pencil" aria-hidden="true"></i>
                            </span>
                        </div>

                        <div class="wrap-input validate-input">
                            <input class="input-register" type="number" min="0" max="100" step="1" name="exams" placeholder="Exámenes" 
                            value="{{ $result->exams }}" required>
                            <span class="focus-input"></span>
                            <span class="icon-input">
                            <i class="fa fa-pencil" aria-hidden="true"></i>
                            </span>
                        </div>

                        <div class="btn-register">
                            <input type="submit" class="register-form-btn" name="submit" value="Guardar"></input>
                        </div>
                        <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                        <p><a href="{{url('/subjects')}}">Cancelar</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@include("common.footer")