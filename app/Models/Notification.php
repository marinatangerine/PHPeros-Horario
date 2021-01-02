<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Notification
 * 
 * @property int $id_notification
 * @property int $id_student
 * @property bool $work
 * @property bool $exam
 * @property bool $continuous_assessment
 * @property bool $final_note
 *
 * @package App\Models
 */
class Notification extends Model
{
	protected $table = 'notifications';
	protected $primaryKey = 'id_notification';
	public $timestamps = false;

	protected $casts = [
		'id_student' => 'int',
		'work' => 'bool',
		'exam' => 'bool',
		'continuous_assessment' => 'bool',
		'final_note' => 'bool'
	];

	protected $fillable = [
		'id_student',
		'work',
		'exam',
		'continuous_assessment',
		'final_note'
	];
}
