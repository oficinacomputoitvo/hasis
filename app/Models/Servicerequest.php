<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Servicerequest
 * 
 * @property int $servicerequest_id
 * @property int|null $folio
 * @property Carbon|null $daterequest
 * @property string|null $email
 * @property string|null $description
 * @property int|null $status
 * 
 * @property User|null $user
 * @property Collection|Executionofservice[] $executionofservices
 * @property Collection|Receptionofrequest[] $receptionofrequests
 * @property Collection|Hardware[] $hardware
 *
 * @package App\Models
 */
class Servicerequest extends Model
{
	protected $table = 'servicerequest';
	protected $primaryKey = 'servicerequest_id';
	public $timestamps = false;

	protected $casts = [
		'folio' => 'int',
		'daterequest' => 'datetime',
		'status' => 'int'
	];

	protected $fillable = [
		'folio',
		'daterequest',
		'email',
		'description',
		'status'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'email');
	}

	public function executionofservices()
	{
		return $this->hasMany(Executionofservice::class);
	}

	public function receptionofrequests()
	{
		return $this->hasMany(Receptionofrequest::class);
	}

	public function hardware()
	{
		return $this->belongsToMany(Hardware::class, 'servicerequesthardware')
					->withPivot('servicerequesthardware_id');
	}
}
