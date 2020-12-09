<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Teacher
 * 
 * @property int $id_teacher
 * @property string $username
 * @property string $pass
 * @property string $name
 * @property string $surname
 * @property string $telephone
 * @property string $nif
 * @property string $email
 * 
 * @property Collection|Subject[] $subjects
 *
 * @package App\Models
 */
class Teacher extends Model
{
	protected $table = 'teachers';
	protected $primaryKey = 'id_teacher';
	public $timestamps = false;

	protected $fillable = [
		'username',
		'pass',
		'name',
		'surname',
		'telephone',
		'nif',
		'email'
	];

	public function subjects()
	{
		return $this->hasMany(Subject::class, 'id_teacher');
	}
}
