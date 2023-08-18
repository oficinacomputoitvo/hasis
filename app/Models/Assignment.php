<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Assignment
 * 
 * @property int $assignment_id
 * @property int|null $hardware_id
 * @property int|null $area_id
 * @property string|null $email
 * @property Carbon|null $dateassignment
 * 
 * @property Area|null $area
 * @property Hardware|null $hardware
 * @property User|null $user
 *
 * @package App\Models
 */
class Assignment extends Model
{
	protected $table = 'assignment';
	protected $primaryKey = 'assignment_id';
	public $timestamps = false;

	protected $casts = [
		'hardware_id' => 'int',
		'area_id' => 'int'
	];

	protected $dates = [
		'dateassignment'
	];

	protected $fillable = [
		'hardware_id',
		'area_id',
		'email',
		'dateassignment'
	];

	public function area()
	{
		return $this->belongsTo(Area::class);
	}

	public function hardware()
	{
		return $this->belongsTo(Hardware::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'email');
	}
}
