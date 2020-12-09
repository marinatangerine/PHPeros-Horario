<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Student
 * 
 * @property int $id
 * @property string $username
 * @property string $pass
 * @property string $email
 * @property string $name
 * @property string $surname
 * @property string $telephone
 * @property string $nif
 * @property Carbon $date_registered
 * 
 * @property Collection|Enrollment[] $enrollments
 * @property Collection|ExamMark[] $exam_marks
 * @property Collection|WorkMark[] $work_marks
 *
 * @package App\Models
 */
class Student extends Model
{
	protected $table = 'students';
	public $timestamps = false;

	protected $dates = [
		'date_registered'
	];

	protected $fillable = [
		'username',
		'pass',
		'email',
		'name',
		'surname',
		'telephone',
		'nif',
		'date_registered'
	];

	public function enrollments()
	{
		return $this->hasMany(Enrollment::class, 'id_student');
	}

	public function exam_marks()
	{
		return $this->hasMany(ExamMark::class, 'id_student');
	}

	public function work_marks()
	{
		return $this->hasMany(WorkMark::class, 'id_student');
	}
}
