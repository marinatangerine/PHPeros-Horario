<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class WorkMark
 * 
 * @property int $id_work
 * @property int $id_student
 * @property float $mark
 * 
 * @property Student $student
 * @property Work $work
 *
 * @package App\Models
 */
class WorkMark extends Model
{
	protected $table = 'work_marks';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id_work' => 'int',
		'id_student' => 'int',
		'mark' => 'float'
	];

	protected $fillable = [
		'mark'
	];

	public function student()
	{
		return $this->belongsTo(Student::class, 'id_student');
	}

	public function work()
	{
		return $this->belongsTo(Work::class, 'id_work');
	}
}
