<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Color
 * 
 * @property string $name
 * @property string $hex
 * @property bool $whitetext
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
}
