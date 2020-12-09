<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Course
 * 
 * @property int $id_course
 * @property string $name
 * @property string $description
 * @property Carbon $date_start
 * @property Carbon $date_end
 * @property int $active
 * 
 * @property Collection|Enrollment[] $enrollments
 * @property Collection|Subject[] $subjects
 *
 * @package App\Models
 */
class Course extends Model
{
	protected $table = 'courses';
	protected $primaryKey = 'id_course';
	public $timestamps = false;

	protected $casts = [
		'active' => 'int'
	];

	protected $dates = [
		'date_start',
		'date_end'
	];

	protected $fillable = [
		'name',
		'description',
		'date_start',
		'date_end',
		'active'
	];

	public function enrollments()
	{
		return $this->hasMany(Enrollment::class, 'id_course');
	}

	public function subjects()
	{
		return $this->hasMany(Subject::class, 'id_course');
	}
}
