<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Maintenancescheduleservicedetail
 * 
 * @property int $maintenancescheduleservicedetail_id
 * @property int|null $maintenancescheduleservice_id
 * @property string|null $time
 * @property string|null $january
 * @property string|null $february
 * @property string|null $march
 * @property string|null $april
 * @property string|null $may
 * @property string|null $june
 * @property string|null $july
 * @property string|null $august
 * @property string|null $september
 * @property string|null $october
 * @property string|null $november
 * @property string|null $december
 * @property string|null $comments
 * 
 * @property Maintenancescheduleservice|null $maintenancescheduleservice
 *
 * @package App\Models
 */
class Maintenancescheduleservicedetail extends Model
{
	protected $table = 'maintenancescheduleservicedetail';
	protected $primaryKey = 'maintenancescheduleservicedetail_id';
	public $timestamps = false;

	protected $casts = [
		'maintenancescheduleservice_id' => 'int'
	];

	protected $fillable = [
		'maintenancescheduleservice_id',
		'time',
		'january',
		'february',
		'march',
		'april',
		'may',
		'june',
		'july',
		'august',
		'september',
		'october',
		'november',
		'december',
		'comments'
	];

	public function maintenancescheduleservice()
	{
		return $this->belongsTo(Maintenancescheduleservice::class);
	}
}
