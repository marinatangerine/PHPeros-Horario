<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UsersAdmin
 * 
 * @property int $id_user_admin
 * @property string $username
 * @property string $name
 * @property string $email
 * @property string $password
 *
 * @package App\Models
 */
class UsersAdmin extends Model
{
	protected $table = 'users_admin';
	protected $primaryKey = 'id_user_admin';
	public $timestamps = false;

	protected $hidden = [
		'password'
	];

	protected $fillable = [
		'username',
		'name',
		'email',
		'password'
	];
}
