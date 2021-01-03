<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\Exam;
use App\Models\Work;
use App\Http\DTOs\GetCalendarDataResultDTO;
use App\Http\DTOs\GetScheduleResultDTO;
use App\Http\DTOs\GetExamResultDTO;
use App\Http\DTOs\GetWorkResultDTO;


class CalendarController extends Controller 
{
    public function getCalendarData(Request $request){
        $role = Session::get('role');
        $user = Session::get('user');
        $today = date("Y-m-d");

        $data = new GetCalendarDataResultDTO;
        $data->month = $request->query('month') ?? date('m', strtotime($today));
        $data->year = $request->query('year') ?? date('Y', strtotime($today));

        if($data->month == 12){
            $data->next_month = 1;
            $data->next_year = $data->year + 1;
        } else {
            $data->next_month = $data->month + 1;
            $data->next_year = $data->year;
        }

        if($data->month == 1){
            $data->previous_month = 12;
            $data->previous_year = $data->year - 1;
        } else {
            $data->previous_month = $data->month - 1;
            $data->previous_year = $data->year;
        }

        $data->last_month_day = date("t", strtotime($data->year."-".$data->month."-1"));

        $data->month_start_week_day = date('w', strtotime($data->year."-".$data->month."-1"));
        if($data->month_start_week_day == 0) {
            $data->month_start_week_day = 7;
        }

        switch ($role) {
            case 1:
                $schedules = Schedule::with('subject', 'subject.teacher', 'subject.course', 'subject.colorR')->whereYear('day', '=', $data->year)->whereMonth('day', '=', $data->month)->whereHas('subject', function($q) { $q->whereHas('course', function($q) { $q->where('active', '1'); }); })->get();
                $exams = Exam::with('subject', 'subject.teacher', 'subject.course', 'subject.colorR')->whereYear('date', '=', $data->year)->whereMonth('date', '=', $data->month)->whereHas('subject', function($q) { $q->whereHas('course', function($q) { $q->where('active', '1'); }); })->get();
                $works = Work::with('subject', 'subject.teacher', 'subject.course', 'subject.colorR')->whereYear('date', '=', $data->year)->whereMonth('date', '=', $data->month)->whereHas('subject', function($q) { $q->whereHas('course', function($q) { $q->where('active', '1'); }); })->get();
                break;
            case 2:
                $id_teacher = $user->id_teacher;
                $schedules = Schedule::with('subject', 'subject.teacher', 'subject.course', 'subject.colorR')->whereYear('day', '=', $data->year)->whereMonth('day', '=', $data->month)->whereHas('subject', function($q) { $q->whereHas('course', function($q) { $q->where('active', '1'); }); })->whereHas('subject', function($q) use($id_teacher) { $q->where('id_teacher', $id_teacher); })->get();
                $exams = Exam::with('subject', 'subject.teacher', 'subject.course', 'subject.colorR')->whereYear('date', '=', $data->year)->whereMonth('date', '=', $data->month)->whereHas('subject', function($q) { $q->whereHas('course', function($q) { $q->where('active', '1'); }); })->whereHas('subject', function($q) use($id_teacher) { $q->where('id_teacher', $id_teacher); })->get();
                $works = Work::with('subject', 'subject.teacher', 'subject.course', 'subject.colorR')->whereYear('date', '=', $data->year)->whereMonth('date', '=', $data->month)->whereHas('subject', function($q) { $q->whereHas('course', function($q) { $q->where('active', '1'); }); })->whereHas('subject', function($q) use($id_teacher) { $q->where('id_teacher', $id_teacher); })->get();
                break;
            case 3:
                $id_student = $user->id;
                $schedules = Schedule::with('subject', 'subject.teacher', 'subject.course', 'subject.colorR')->whereYear('day', '=', $data->year)->whereMonth('day', '=', $data->month)->whereHas('subject', function($q) { $q->whereHas('course', function($q) { $q->where('active', '1'); }); })
                ->whereHas('subject', function($q) use($id_student) { 
                    $q->whereHas('course', function($q) use($id_student) { 
                        $q->whereHas('enrollments', function($q) use($id_student) { 
                            $q->where(['id_student'=>$id_student, 'status'=>'1']);
                        }); 
                    }); 
                })->get();
                $exams = Exam::with('subject', 'subject.teacher', 'subject.course', 'subject.colorR')->whereYear('date', '=', $data->year)->whereMonth('date', '=', $data->month)->whereHas('subject', function($q) { $q->whereHas('course', function($q) { $q->where('active', '1'); }); })
                ->whereHas('subject', function($q) use($id_student) { 
                    $q->whereHas('course', function($q) use($id_student) { 
                        $q->whereHas('enrollments', function($q) use($id_student) { 
                            $q->where(['id_student'=>$id_student, 'status'=>'1']);
                        }); 
                    }); 
                })->get();
                $works = Work::with('subject', 'subject.teacher', 'subject.course', 'subject.colorR')->whereYear('date', '=', $data->year)->whereMonth('date', '=', $data->month)->whereHas('subject', function($q) { $q->whereHas('course', function($q) { $q->where('active', '1'); }); })
                ->whereHas('subject', function($q) use($id_student) { 
                    $q->whereHas('course', function($q) use($id_student) { 
                        $q->whereHas('enrollments', function($q) use($id_student) { 
                            $q->where(['id_student'=>$id_student, 'status'=>'1']);
                        }); 
                    }); 
                })->get();
                break;
        }

        foreach ($schedules as $schedule) {
            $subject = $schedule->subject;
            $teacher = $subject->teacher;
            $course = $subject->course;
            $color = $subject->colorR;

            $result = new GetScheduleResultDTO;
            $result->id_schedule = $schedule->id_schedule;
            $result->day = Carbon::parse($schedule->day)->format('d');
            $result->time_start = Carbon::parse($schedule->time_start)->format('h:i');
            $result->time_end = Carbon::parse($schedule->time_end)->format('h:i');
            $result->course_name = $course->name;
            $result->class_name = $subject->name;
            $result->bg_color = $color->hex;
            $result->text_color = $color->whitetext == 1 ? '#FFF' : '#000';
            $result->teacher_name = $teacher->name . ' ' . $teacher->surname;

            $data->items[] = $result;
        }

        foreach ($exams as $exam) {
            $subject = $exam->subject;
            $teacher = $subject->teacher;
            $course = $subject->course;
            $color = $subject->colorR;

            $result = new GetExamResultDTO;
            $result->id_exam = $exam->id_exam;
            $result->date = Carbon::parse($exam->date)->format('d');
            $result->time = Carbon::parse($exam->date)->format('h:i');
            $result->name = $exam->name;
            $result->course_name = $course->name;
            $result->class_name = $subject->name;
            $result->bg_color = $color->hex;
            $result->text_color = $color->whitetext == 1 ? '#FFF' : '#000';
            $result->teacher_name = $teacher->name . ' ' . $teacher->surname;

            $data->exams[] = $result;
        }

        foreach ($works as $work) {
            $subject = $work->subject;
            $teacher = $subject->teacher;
            $course = $subject->course;
            $color = $subject->colorR;

            $result = new GetWorkResultDTO;
            $result->id_work = $work->id_work;
            $result->date = Carbon::parse($work->date)->format('d');
            $result->time = Carbon::parse($work->date)->format('h:i');
            $result->name = $work->name;
            $result->course_name = $course->name;
            $result->class_name = $subject->name;
            $result->bg_color = $color->hex;
            $result->text_color = $color->whitetext == 1 ? '#FFF' : '#000';
            $result->teacher_name = $teacher->name . ' ' . $teacher->surname;

            $data->works[] = $result;
        }

        return view("calendar", ["data" => $data]);
    }
}