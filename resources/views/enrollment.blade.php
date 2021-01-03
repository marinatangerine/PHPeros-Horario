@include("common.header")
<div class="limiter">
    <div class="title-register">
        <h1>{{$result->course_name}} ({{$result->course_date_start}} - {{$result->course_date_end}})</h1>
    </div>
    <div class="container-register">
        <div class="wrap-register">
        <div class="half-wrapper">
                <div class="big-icon"><i class="fa fa-folder-open" aria-hidden="true"></i></div>
            </div>
            <div class="half-wrapper">
                <div class="form-body">
                        <form action="{{url('/courses')}}/{{$result->id_course}}/enrollment" method="POST">
                            @if($result->status != 1)
                                <span class="register-form-title"><p>¿Quieres matricularte en este curso?</p> </span>
                                <br>
                                <div class="btn-register">
                                    <input type="submit" class="register-form-btn" name="submit" value="Matricular"></input>
                                </div>
                            @else
                                <span class="register-form-title"><p>Actualmente estás matriculado en este curso. ¿Quieres anular tu matricula?</p> </span>
                                <br>
                                <div class="btn-register">
                                    <input type="submit" class="register-form-btn" name="submit" value="Anular matrícula"></input>
                                </div>
                            @endif
                            <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                        </form>
                    <p><a href="{{url('/courses')}}">Volver</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@include("common.footer")