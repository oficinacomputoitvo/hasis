<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Maintenancescheduleservice
 * 
 * @property int $maintenancescheduleservice_id
 * @property int|null $number
 * @property int|null $maintenanceschedule_id
 * @property string|null $service
 * @property string|null $type
 * 
 * @property Maintenanceschedule|null $maintenanceschedule
 * @property Collection|Maintenancescheduleservicedetail[] $maintenancescheduleservicedetails
 *
 * @package App\Models
 */
class Maintenancescheduleservice extends Model
{
	protected $table = 'maintenancescheduleservice';
	protected $primaryKey = 'maintenancescheduleservice_id';
	public $timestamps = false;

	protected $casts = [
		'number' => 'int',
		'maintenanceschedule_id' => 'int'
	];

	protected $fillable = [
		'number',
		'maintenanceschedule_id',
		'service',
		'type'
	];

	public function maintenanceschedule()
	{
		return $this->belongsTo(Maintenanceschedule::class);
	}

	public function maintenancescheduleservicedetails()
	{
		return $this->hasMany(Maintenancescheduleservicedetail::class);
	}
}
