<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Servicetype
 * 
 * @property int $servicetype_id
 * @property string|null $description
 * 
 * @property Collection|Executionofservice[] $executionofservices
 * @property Collection|Maintenancescheduleservice[] $maintenancescheduleservices
 *
 * @package App\Models
 */
class Servicetype extends Model
{
	protected $table = 'servicetype';
	protected $primaryKey = 'servicetype_id';
	public $timestamps = false;

	protected $fillable = [
		'description'
	];

	public function executionofservices()
	{
		return $this->hasMany(Executionofservice::class);
	}

	public function maintenancescheduleservices()
	{
		return $this->hasMany(Maintenancescheduleservice::class);
	}
}
