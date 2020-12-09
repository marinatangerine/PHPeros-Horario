<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Work
 * 
 * @property int $id_work
 * @property int $id_class
 * @property Carbon $date
 * @property string $name
 * 
 * @property Subject $subject
 * @property Collection|WorkMark[] $work_marks
 *
 * @package App\Models
 */
class Work extends Model
{
	protected $table = 'works';
	protected $primaryKey = 'id_work';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id_work' => 'int',
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

	public function work_marks()
	{
		return $this->hasMany(WorkMark::class, 'id_work');
	}
}
