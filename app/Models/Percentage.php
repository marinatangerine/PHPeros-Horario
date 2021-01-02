<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Percentage
 * 
 * @property int $id_percentage
 * @property int $id_course
 * @property int $id_class
 * @property float $continuous_assessment
 * @property float $exams
 *
 * @package App\Models
 */
class Percentage extends Model
{
	protected $table = 'percentage';
	protected $primaryKey = 'id_percentage';
	public $timestamps = false;

	protected $casts = [
		'id_course' => 'int',
		'id_class' => 'int',
		'continuous_assessment' => 'float',
		'exams' => 'float'
	];

	protected $fillable = [
		'id_course',
		'id_class',
		'continuous_assessment',
		'exams'
	];
}
