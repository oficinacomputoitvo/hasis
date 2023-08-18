<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Menu
 * 
 * @property int $menu_id
 * @property int|null $rol_id
 * @property string|null $menu
 * 
 * @property Rol|null $rol
 *
 * @package App\Models
 */
class Menu extends Model
{
	protected $table = 'menu';
	protected $primaryKey = 'menu_id';
	public $timestamps = false;

	protected $casts = [
		'rol_id' => 'int'
	];

	protected $fillable = [
		'rol_id',
		'menu'
	];

	public function rol()
	{
		return $this->belongsTo(Rol::class);
	}
}
