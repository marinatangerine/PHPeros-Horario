<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Exam
 * 
 * @property int $id_exam
 * @property int $id_class
 * @property Carbon $date
 * @property string $name
 * 
 * @property Subject $subject
 * @property Collection|ExamMark[] $exam_marks
 *
 * @package App\Models
 */
class Exam extends Model
{
	protected $table = 'exams';
	protected $primaryKey = 'id_exam';
	public $timestamps = false;

	protected $casts = [
		'id_class' => 'int'
	];

	protected $dates = [
		'date'
	];

	protected $fillable = [
		'id_class',
		'date',
		'name'
	];

	public function subject()
	{
		return $this->belongsTo(Subject::class, 'id_class');
	}

	public function exam_marks()
	{
		return $this->hasMany(ExamMark::class, 'id_exam');
	}
}
