<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Enrollment
 * 
 * @property int $id_enrollment
 * @property int $id_student
 * @property int $id_course
 * @property int $status
 * 
 * @property Course $course
 * @property Student $student
 *
 * @package App\Models
 */
class Enrollment extends Model
{
	protected $table = 'enrollment';
	protected $primaryKey = 'id_enrollment';
	public $timestamps = false;

	protected $casts = [
		'id_student' => 'int',
		'id_course' => 'int',
		'status' => 'int'
	];

	protected $fillable = [
		'id_student',
		'id_course',
		'status'
	];

	public function course()
	{
		return $this->belongsTo(Course::class, 'id_course');
	}

	public function student()
	{
		return $this->belongsTo(Student::class, 'id_student');
	}
}
