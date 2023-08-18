<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Action
 * 
 * @property int $action_id
 * @property string|null $description
 * 
 * @property Collection|Rol[] $rols
 *
 * @package App\Models
 */
class Action extends Model
{
	protected $table = 'action';
	protected $primaryKey = 'action_id';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'action_id' => 'int'
	];

	protected $fillable = [
		'description'
	];

	public function rols()
	{
		return $this->belongsToMany(Rol::class, 'rolaction')
					->withPivot('rolaction_id');
	}
}
