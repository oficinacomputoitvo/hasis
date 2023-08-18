<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Status
 * 
 * @property int $status_id
 * @property string|null $description
 * 
 * @property Collection|Hardware[] $hardware
 *
 * @package App\Models
 */
class Status extends Model
{
	protected $table = 'status';
	protected $primaryKey = 'status_id';
	public $timestamps = false;

	protected $fillable = [
		'description'
	];

	public function hardware()
	{
		return $this->hasMany(Hardware::class);
	}
}
