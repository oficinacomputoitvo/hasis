<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 * 
 * @property string $email
 * @property string|null $password
 * @property string|null $name
 * @property int|null $estatus
 * @property string|null $digitalsignature
 * 
 * @property Collection|Areaowner[] $areaowners
 * @property Collection|Assignment[] $assignments
 * @property Collection|Executionofservice[] $executionofservices
 * @property Collection|Maintenanceschedule[] $maintenanceschedules
 * @property Collection|Receptionofrequest[] $receptionofrequests
 * @property Collection|Rol[] $rols
 * @property Collection|Servicerequest[] $servicerequests
 *
 * @package App\Models
 */
class User extends Authenticatable
{
	protected $table = 'user';
	protected $primaryKey = 'email';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'estatus' => 'int'
	];

	protected $hidden = [
		'password'
	];

	protected $fillable = [
		'email',
		'password',
		'name',
		'estatus',
		'digitalsignature'
	];

	public function areaowners()
	{
		return $this->hasMany(Areaowner::class, 'email');
	}

	public function assignments()
	{
		return $this->hasMany(Assignment::class, 'email');
	}

	public function executionofservices()
	{
		return $this->hasMany(Executionofservice::class, 'email');
	}

	public function maintenanceschedules()
	{
		return $this->hasMany(Maintenanceschedule::class, 'whoelaborated');
	}

	public function receptionofrequests()
	{
		return $this->hasMany(Receptionofrequest::class, 'email');
	}

	public function rols()
	{
		return $this->belongsToMany(Rol::class, 'roluser', 'email')
					->withPivot('roluser_id');
	}

	public function servicerequests()
	{
		return $this->hasMany(Servicerequest::class, 'email');
	}
}
