<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Subject;
use App\Models\Enrollment;
use App\Http\DTOs\ListResultDTO;
use App\Http\DTOs\GetCoursesResultDTO;
use App\Http\DTOs\EditCourseResultDTO;


class CourseController extends Controller 
{
    public function getCourses(){
        $data = new ListResultDTO;
        $data->itemType = "course";
        $data->listName = "Cursos";
        $data->editItemUrl = "courses";
        $data->newItemText = "Crear curso";

        foreach (Course::all() as $item) {
            $result = new GetCoursesResultDTO;
            $result->id_course = $item->id_course;
            $result->name = $item->name;
            $result->description = $item->description;
            $result->date_start = $item->date_start;
            $result->date_end = $item->date_end;
            $result->active = $item->active;
            $result->hasChildren = (Subject::where('id_course', $item->id_course)->count()) + (Enrollment::where('id_course', $item->id_course)->count()) > 0;
            $data->items[] = $result;
        }

        return view("list", ["data" => $data]);        
    }

    public function getCourse($id){
        if ($id == 'new') {
            $result = new EditCourseResultDTO;
            $result->formTitle = 'Crear Curso';
        } else {
            $item = Course::where('id_course', $id)->first();
            if ($item) {
                $result = new EditCourseResultDTO;
                $result->name = $item->name;
                $result->description = $item->description;
                $result->date_start = Carbon::parse($item->date_start)->format('Y-m-d');
                $result->date_end = Carbon::parse($item->date_end)->format('Y-m-d');
                $result->active = $item->active;
                $result->id_course = $item->id_course;                
            }
        }
        return view("editCourse", ["result" => $result]);
    }

    public function updateCourse($id, Request $request) {
        $name = $request->name;
        $description = $request->description;
        $date_start = $request->date_start;
        $date_end = $request->date_end;
        
        if($request->active) {
            $active = 1;
        } else {
            $active = 0;
        }

        $validationErrors = 0;

        if ($id == 'new') {
            $course = new Course;
        } else {
            $course = Course::where('id_course', $id)->first();
        }

        $datestartCmp = strtotime($date_start);
        $dateendCmp = strtotime($date_end);
        if($datestartCmp >= $dateendCmp) {
            $datesError = "La fecha de fin debe ser posterior a la fecha de inicio";
        }

        $result = new EditCourseResultDTO;
        $result->name = $name;
        $result->description = $description;
        $result->date_start = $date_start;
        $result->date_end = $date_end;
        $result->active = $active;

        if ($validationErrors == 0) {
            $course->name = $name;
            $course->description = $description;
            $course->date_start = $date_start;
            $course->date_end = $date_end;
            $course->active = $active;

            try{
                $course->save();
                $result->success = true;
            }catch(\Exception $ex) {
                $result->serverError = $ex->getMessage();
                $result->success = false;
                return view('editCourse', ['id'=>$id, 'result' => $result]);
            }
        } else {
            $result->success = false;
            $result->validationErrors = $validationErrors ?? 0;
            $result->datesError = $datesError ?? '';
            return view('editCourse', ['id'=>$id, 'result' => $result]);
        }

        return redirect()->route('courses');
    }

    public function deleteCourse($id) {
        Course::where('id_course', $id)->delete();
        return redirect()->route('courses');
    }
}