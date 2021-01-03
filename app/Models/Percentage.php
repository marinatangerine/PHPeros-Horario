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
 * @property int $id_class
 * @property float $continuous_assessment
 * @property float $exams
 * 
 * @property Subject $subject
 *
 * @package App\Models
 */
class Percentage extends Model
{
	protected $table = 'percentage';
	protected $primaryKey = 'id_percentage';
	public $timestamps = false;

	protected $casts = [
		'id_class' => 'int',
		'continuous_assessment' => 'float',
		'exams' => 'float'
	];

	protected $fillable = [
		'id_class',
		'continuous_assessment',
		'exams'
	];

	public function subject()
	{
		return $this->belongsTo(Subject::class, 'id_class');
	}
}
