@include("common.header")
<div class="limiter">
    <div class="title-register">
        <h1>Calendario</h1>
    </div>
    <div class="container-register">
        <div class="wrap-register">
            <div class="calendar-header">
                <a class="icon" href="{{url('/calendar')}}?month={{$data->previous_month}}&year={{$data->previous_year}}"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
                <span class="name">{{$data->months[$data->month - 1]}} de {{$data->year}}</span>
                <a class="icon" href="{{url('/calendar')}}?month={{$data->next_month}}&year={{$data->next_year}}"><i class="fa fa-arrow-right" aria-hidden="true"></i></a>
            </div>
            <table class="calendar-table">
                <tr>
                    <th>Lunes</th><th>Martes</th><th>Miércoles</th><th>Jueves</th><th>Viernes</th><th>Sábado</th><th>Domingo</th>
                </tr>
                <?php $counter = 0; ?>
                @while($counter < $data->last_month_day)
                    <tr>
                        @for ($i = 1; $i < 8; $i++)
                            @if(($counter == 0 && $i == $data->month_start_week_day) || ($counter > 0 && $counter < $data->last_month_day))
                                <?php $counter++; ?>
                                <td>
                                    <div class="calendarItem">
                                        <span>{{$counter}}</span>
                                        @foreach($data->items as $item)
                                            @if($item->day == $counter)
                                                <div class="scheduleElement" style="background-color: #{{$item->bg_color}}; color: {{$item->text_color}}" title="{{$item->course_name}} con {{$item->teacher_name}}">
                                                {{$item->class_name}} {{$item->time_start}}}-{{$item->time_end}}
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </td>
                            @else
                                <td class="inactive"></td>
                            @endif
                        @endfor
                    </tr>
                @endwhile
            </table>
        </div>
    </div>
</div>
@include("common.footer")