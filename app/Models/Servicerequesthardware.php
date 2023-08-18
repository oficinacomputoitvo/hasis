<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Servicerequesthardware
 * 
 * @property int $servicerequesthardware_id
 * @property int|null $servicerequest_id
 * @property int|null $hardware_id
 * 
 * @property Hardware|null $hardware
 * @property Servicerequest|null $servicerequest
 *
 * @package App\Models
 */
class Servicerequesthardware extends Model
{
	protected $table = 'servicerequesthardware';
	protected $primaryKey = 'servicerequesthardware_id';
	public $timestamps = false;

	protected $casts = [
		'servicerequest_id' => 'int',
		'hardware_id' => 'int'
	];

	protected $fillable = [
		'servicerequest_id',
		'hardware_id'
	];

	public function hardware()
	{
		return $this->belongsTo(Hardware::class);
	}

	public function servicerequest()
	{
		return $this->belongsTo(Servicerequest::class);
	}
}
