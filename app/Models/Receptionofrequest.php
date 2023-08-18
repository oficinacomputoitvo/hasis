<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Receptionofrequest
 * 
 * @property int $receptionofrequest_id
 * @property int|null $servicerequest_id
 * @property Carbon|null $datereception
 * @property string|null $email
 * @property string|null $comment
 * @property Carbon|null $probabledateexecution
 * 
 * @property Servicerequest|null $servicerequest
 * @property User|null $user
 *
 * @package App\Models
 */
class Receptionofrequest extends Model
{
	protected $table = 'receptionofrequest';
	protected $primaryKey = 'receptionofrequest_id';
	public $timestamps = false;

	protected $casts = [
		'servicerequest_id' => 'int'
	];

	protected $dates = [
		'datereception',
		'probabledateexecution'
	];

	protected $fillable = [
		'servicerequest_id',
		'datereception',
		'email',
		'comment',
		'probabledateexecution'
	];

	public function servicerequest()
	{
		return $this->belongsTo(Servicerequest::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'email');
	}
}
