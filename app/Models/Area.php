<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Area
 * 
 * @property int $area_id
 * @property string|null $description
 * @property int|null $parent
 * 
 * @property Collection|Areaowner[] $areaowners
 * @property Collection|Assignment[] $assignments
 *
 * @package App\Models
 */
class Area extends Model
{
	protected $table = 'area';
	protected $primaryKey = 'area_id';
	public $timestamps = false;

	protected $casts = [
		'parent' => 'int'
	];

	protected $fillable = [
		'description',
		'parent'
	];

	public function areaowners()
	{
		return $this->hasMany(Areaowner::class);
	}

	public function assignments()
	{
		return $this->hasMany(Assignment::class);
	}
}
