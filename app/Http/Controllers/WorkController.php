<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Subject;
use App\Models\Work;
use App\Http\DTOs\CreateWorkResultDTO;
use App\Http\DTOs\GetWorkResultDTO;

class WorkController extends Controller
{
    public function getWorksData($id) {
        $result = $this->getData($id);
        return view("work", ["result" => $result]);
    }

    protected function getData($id){
        $subject = Subject::with('course', 'teacher')->where('id_class', $id)->first();
        if($subject) {
            $course = $subject->course;
            $teacher = $subject->teacher;

            $result = new CreateWorkResultDTO;
            $result->id_class = $subject->id_class;
            $result->name_class = $subject->name;
            $result->course_start = Carbon::parse($course->date_start)->format('d-m-Y');
            $result->course_end = Carbon::parse($course->date_end)->format('d-m-Y');

            $items = Work::where('id_class', $id)->get();
            foreach($items as $item) {
                $itemDTO = new GetWorkResultDTO;
                $itemDTO->id_work = $item->id_work;
                $itemDTO->date = Carbon::parse($item->date)->format('d-m-Y h:i');
                $itemDTO->name = $item->name;
                $itemDTO->course_name = $course->name;
                $itemDTO->teacher_name = $teacher->name .' '. $teacher->surname;
                $result->items[] = $itemDTO;
            }
            return $result;
        }
    }

    public function saveWork($id, Request $request) {
        $id_class = $id;
        $date = $request->date;
        $name = $request->name;

        $min_date = $request->min_date;
        $max_date = $request->max_date;

        $dateCmp = strtotime($date);
        $datestartCmp = strtotime($min_date);
        $dateendCmp = strtotime($max_date);
        if($dateCmp < $datestartCmp || $dateCmp > $dateendCmp) {
            $result = $this->getData($id);
            $result->date = $request->date;
            $result->name = $request->name;
            $result->dateError = "La fecha debe estar entre el $min_date y el $max_date";
            $result->success = false;
        } else {
            $work = new Work;
            $work->id_class = $id_class;
            $work->date = $date;
            $work->name = $name;

            $work->save();
            $result = $this->getData($id);
            $result->success = true;
        }
        return view("work", ["result" => $result]);
    }

    public function deleteWork($id) {
        $work = Work::where('id_work', $id)->first();
        $id_class = $work->id_class;
        $work->delete();
        $result = $this->getData($id_class);
        return view("work", ["result" => $result]);
    }
}
