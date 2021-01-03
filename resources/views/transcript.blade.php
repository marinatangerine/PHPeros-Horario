@include("common.header")
<div class="limiter">
    <div class="title-register">
        <h1>Expediente - {{$data->name}}</h1>
    </div>
    <div class="container-register">
        <div class="wrap-register">
            @if(count($data->subjects) > 0)
                <table class="data-table">
                    <tr>
                        <th>#</th><th>Nombre</th><th>Curso</th><th>Evaluación contínua</th><th>Media exámenes</th><th>Nota final</th>
                    </tr>
                    @foreach ($data->subjects as $subject)
                        <tr>
                            <td>{{$subject->id_class}}</td><td>{{$subject->name}}</td><td>{{$subject->courseName}}</td><td>{{$subject->works_avg_mark}}</td><td>{{$subject->exams_avg_mark}}</td><td>{{$subject->avg_mark}}</td>
                        </tr>
                        @if(count($subject->exams) > 0 || count($subject->works) > 0)
                        <tr>
                            <td colspan="6">
                                @if(count($subject->exams) > 0)
                                <span class="sub-header">Examenes</span>
                                <table class="subdata-table">
                                    <tr>
                                        <th>Fecha</th><th>Nombre</th><th>Calificación</th>
                                    </tr>
                                    @foreach ($subject->exams as $exam)
                                        <tr>
                                            <td>{{$exam->date}}</td><td>{{$exam->name}}</td><td>{{$exam->mark}}</td>
                                        </tr>
                                    @endforeach
                                </table>
                                @endif
                                @if(count($subject->works) > 0)
                                <span class="sub-header">Trabajos</span>
                                <table class="subdata-table">
                                    <tr>
                                        <th>Fecha</th><th>Nombre</th><th>Calificación</th>
                                    </tr>
                                    @foreach ($subject->works as $work)
                                        <tr>
                                            <td>{{$work->date}}</td><td>{{$work->name}}</td><td>{{$work->mark}}</td>
                                        </tr>
                                    @endforeach
                                </table>
                                @endif
                            </td>
                        </tr>
                        @endif
                    @endforeach
                </table>
            @else
                No hay datos para mostrar
            @endif
        </div>
    </div>
</div>
@include("common.footer")