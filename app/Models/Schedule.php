<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Schedule
 * 
 * @property int $id_schedule
 * @property int $id_class
 * @property Carbon $time_start
 * @property Carbon $time_end
 * @property Carbon $day
 * 
 * @property Subject $subject
 *
 * @package App\Models
 */
class Schedule extends Model
{
	protected $table = 'schedule';
	protected $primaryKey = 'id_schedule';
	public $timestamps = false;

	protected $casts = [
		'id_class' => 'int'
	];

	protected $dates = [
		'time_start',
		'time_end',
		'day'
	];

	protected $fillable = [
		'id_class',
		'time_start',
		'time_end',
		'day'
	];

	public function subject()
	{
		return $this->belongsTo(Subject::class, 'id_class');
	}
}
