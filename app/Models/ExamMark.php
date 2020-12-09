<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ExamMark
 * 
 * @property int $id_exam
 * @property int $id_student
 * @property float $mark
 * 
 * @property Exam $exam
 * @property Student $student
 *
 * @package App\Models
 */
class ExamMark extends Model
{
	protected $table = 'exam_marks';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id_exam' => 'int',
		'id_student' => 'int',
		'mark' => 'float'
	];

	protected $fillable = [
		'mark'
	];

	public function exam()
	{
		return $this->belongsTo(Exam::class, 'id_exam');
	}

	public function student()
	{
		return $this->belongsTo(Student::class, 'id_student');
	}
}
