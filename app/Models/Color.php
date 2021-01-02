<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Color
 * 
 * @property string $name
 * @property string $hex
 * @property bool $whitetext
 * 
 * @property Collection|Subject[] $subjects
 *
 * @package App\Models
 */
class Color extends Model
{
	protected $table = 'colors';
	protected $primaryKey = 'name';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'whitetext' => 'bool'
	];

	protected $fillable = [
		'hex',
		'whitetext'
	];

	public function subjects()
	{
		return $this->hasMany(Subject::class, 'color');
	}
}
