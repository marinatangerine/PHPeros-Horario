<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Subject;
use App\Models\Schedule;
use App\Http\DTOs\CreateScheduleResultDTO;
use App\Http\DTOs\GetScheduleResultDTO;

class ScheduleController extends Controller
{
    public function getSchedule($id) {
        $result = $this->getData($id);
        return view("schedule", ["result" => $result]);
    }

    protected function getData($id){
        $subject = Subject::with('course', 'teacher')->where('id_class', $id)->first();
        if($subject) {
            $course = $subject->course;
            $teacher = $subject->teacher;

            $result = new CreateScheduleResultDTO;
            $result->id_class = $subject->id_class;
            $result->name_class = $subject->name;
            $result->course_start = Carbon::parse($course->date_start)->format('d-m-Y');
            $result->course_end = Carbon::parse($course->date_end)->format('d-m-Y');

            $schedules = Schedule::where('id_class', $id)->get();
            foreach($schedules as $schedule) {
                $scheduleDTO = new GetScheduleResultDTO;
                $scheduleDTO->id_schedule = $schedule->id_schedule;
                $scheduleDTO->day = Carbon::parse($schedule->day)->format('d-m-Y');
                $scheduleDTO->time_start = Carbon::parse($schedule->time_start)->format('h:i');
                $scheduleDTO->time_end = Carbon::parse($schedule->time_end)->format('h:i');
                $scheduleDTO->course_name = $course->name;
                $scheduleDTO->teacher_name = $teacher->name .' '. $teacher->surname;
                $result->items[] = $scheduleDTO;
            }
            return $result;
        }
    }

    public function saveSchedule($id, Request $request) {
        $id_class = $id;
        $time_start = $request->time_start;
        $time_end = $request->time_end;
        $day = $request->day;
        $min_date = $request->min_date;
        $max_date = $request->max_date;

        $dateCmp = strtotime($day);
        $datestartCmp = strtotime($min_date);
        $dateendCmp = strtotime($max_date);
        if($dateCmp < $datestartCmp || $dateCmp > $dateendCmp) {
            $result = $this->getData($id);
            $result->time_start = $request->time_start;
            $result->time_end = $request->time_end;
            $result->day = $request->day;
            $result->dateError = "La fecha debe estar entre el $min_date y el $max_date";
            $result->success = false;
        } else {
            $schedule = new Schedule;
            $schedule->id_class = $id_class;
            $schedule->day = $day;
            $schedule->time_start = $time_start;
            $schedule->time_end = $time_end;

            $schedule->save();
            $result = $this->getData($id);
            $result->success = true;
        }
        return view("schedule", ["result" => $result]);
    }

    public function deleteSchedule($id) {
        $schedule = Schedule::where('id_schedule', $id)->first();
        $id_class = $schedule->id_class;
        $schedule->delete();
        $result = $this->getData($id_class);
        return view("schedule", ["result" => $result]);
    }
}
