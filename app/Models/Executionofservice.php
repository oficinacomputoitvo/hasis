<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Executionofservice
 * 
 * @property int $executionofservice_id
 * @property int|null $servicetype_id
 * @property int|null $servicerequest_id
 * @property string|null $email
 * @property Carbon|null $dateofservice
 * @property int|null $hardware_id
 * @property string|null $actions
 * @property string|null $materialsused
 * @property Carbon|null $datereleased
 * @property string|null $signreleased
 * @property Carbon|null $dateapproved
 * @property string|null $approved
 * @property string|null $signapproved
 * @property bool|null $internalservice
 * @property int|null $rating
 * 
 * @property Hardware|null $hardware
 * @property Servicerequest|null $servicerequest
 * @property Servicetype|null $servicetype
 * @property User|null $user
 *
 * @package App\Models
 */
class Executionofservice extends Model
{
	protected $table = 'executionofservice';
	protected $primaryKey = 'executionofservice_id';
	public $timestamps = false;

	protected $casts = [
		'servicetype_id' => 'int',
		'servicerequest_id' => 'int',
		'dateofservice' => 'datetime',
		'hardware_id' => 'int',
		'datereleased' => 'datetime',
		'dateapproved' => 'datetime',
		'internalservice' => 'bool',
		'rating' => 'int'
	];

	protected $fillable = [
		'servicetype_id',
		'servicerequest_id',
		'email',
		'dateofservice',
		'hardware_id',
		'actions',
		'materialsused',
		'datereleased',
		'signreleased',
		'dateapproved',
		'approved',
		'signapproved',
		'internalservice',
		'rating'
	];

	public function hardware()
	{
		return $this->belongsTo(Hardware::class);
	}

	public function servicerequest()
	{
		return $this->belongsTo(Servicerequest::class);
	}

	public function servicetype()
	{
		return $this->belongsTo(Servicetype::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'email');
	}
}
