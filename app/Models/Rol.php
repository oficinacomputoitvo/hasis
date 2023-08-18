<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Rol
 * 
 * @property int $rol_id
 * @property string|null $description
 * 
 * @property Collection|Menu[] $menus
 * @property Collection|Action[] $actions
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class Rol extends Model
{
	protected $table = 'rol';
	protected $primaryKey = 'rol_id';
	public $timestamps = false;

	protected $fillable = [
		'description'
	];

	public function menus()
	{
		return $this->hasMany(Menu::class);
	}

	public function actions()
	{
		return $this->belongsToMany(Action::class, 'rolaction')
					->withPivot('rolaction_id');
	}

	public function users()
	{
		return $this->belongsToMany(User::class, 'roluser', 'rol_id', 'email')
					->withPivot('roluser_id');
	}
}
