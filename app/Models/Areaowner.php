<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Areaowner
 * 
 * @property int $areaowner_id
 * @property int|null $area_id
 * @property string|null $email
 * @property Carbon|null $assignementdate
 * @property Carbon|null $expirationdate
 * 
 * @property Area|null $area
 * @property User|null $user
 *
 * @package App\Models
 */
class Areaowner extends Model
{
	protected $table = 'areaowner';
	protected $primaryKey = 'areaowner_id';
	public $timestamps = false;

	protected $casts = [
		'area_id' => 'int'
	];

	protected $dates = [
		'assignementdate',
		'expirationdate'
	];

	protected $fillable = [
		'area_id',
		'email',
		'assignementdate',
		'expirationdate'
	];

	public function area()
	{
		return $this->belongsTo(Area::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'email');
	}
}
