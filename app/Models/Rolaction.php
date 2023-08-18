<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Rolaction
 * 
 * @property int $rolaction_id
 * @property int|null $rol_id
 * @property int|null $action_id
 * 
 * @property Action|null $action
 * @property Rol|null $rol
 *
 * @package App\Models
 */
class Rolaction extends Model
{
	protected $table = 'rolaction';
	protected $primaryKey = 'rolaction_id';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'rolaction_id' => 'int',
		'rol_id' => 'int',
		'action_id' => 'int'
	];

	protected $fillable = [
		'rol_id',
		'action_id'
	];

	public function action()
	{
		return $this->belongsTo(Action::class);
	}

	public function rol()
	{
		return $this->belongsTo(Rol::class);
	}
}
