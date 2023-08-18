<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Maintenanceschedule
 * 
 * @property int $maintenanceschedule_id
 * @property string|null $comment
 * @property string|null $schoolcycle
 * @property string|null $whoautorized
 * @property string|null $whoelaborated
 * @property int|null $year
 * @property Carbon|null $dateofpreparation
 * @property Carbon|null $dateofapproval
 * @property bool|null $preparationsignature
 * @property bool|null $authorizationsignature
 * 
 * @property User|null $user
 * @property Collection|Maintenancescheduleservice[] $maintenancescheduleservices
 *
 * @package App\Models
 */
class Maintenanceschedule extends Model
{
	protected $table = 'maintenanceschedule';
	protected $primaryKey = 'maintenanceschedule_id';
	public $timestamps = false;

	protected $casts = [
		'year' => 'int',
		'preparationsignature' => 'bool',
		'authorizationsignature' => 'bool'
	];

	protected $dates = [
		'dateofpreparation',
		'dateofapproval'
	];

	protected $fillable = [
		'comment',
		'schoolcycle',
		'whoautorized',
		'whoelaborated',
		'year',
		'dateofpreparation',
		'dateofapproval',
		'preparationsignature',
		'authorizationsignature'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'whoelaborated');
	}

	public function maintenancescheduleservices()
	{
		return $this->hasMany(Maintenancescheduleservice::class);
	}
}
