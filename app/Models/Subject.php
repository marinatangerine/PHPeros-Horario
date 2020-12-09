<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Subject
 * 
 * @property int $id_class
 * @property int $id_teacher
 * @property int $id_course
 * @property string $name
 * @property string $color
 * 
 * @property Course $course
 * @property Teacher $teacher
 * @property Collection|Exam[] $exams
 * @property Collection|Schedule[] $schedules
 * @property Collection|Work[] $works
 *
 * @package App\Models
 */
class Subject extends Model
{
	protected $table = 'subjects';
	protected $primaryKey = 'id_class';
	public $timestamps = false;

	protected $casts = [
		'id_teacher' => 'int',
		'id_course' => 'int'
	];

	protected $fillable = [
		'id_teacher',
		'id_course',
		'name',
		'color'
	];

	public function course()
	{
		return $this->belongsTo(Course::class, 'id_course');
	}

	public function teacher()
	{
		return $this->belongsTo(Teacher::class, 'id_teacher');
	}

	public function exams()
	{
		return $this->hasMany(Exam::class, 'id_class');
	}

	public function schedules()
	{
		return $this->hasMany(Schedule::class, 'id_class');
	}

	public function works()
	{
		return $this->hasMany(Work::class, 'id_class');
	}
}
