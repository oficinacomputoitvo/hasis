<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Roluser
 * 
 * @property int $roluser_id
 * @property int|null $rol_id
 * @property string|null $email
 * 
 * @property Rol|null $rol
 * @property User|null $user
 *
 * @package App\Models
 */
class Roluser extends Model
{
	protected $table = 'roluser';
	protected $primaryKey = 'roluser_id';
	public $timestamps = false;

	protected $casts = [
		'rol_id' => 'int'
	];

	protected $fillable = [
		'rol_id',
		'email'
	];

	public function rol()
	{
		return $this->belongsTo(Rol::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'email');
	}
}
