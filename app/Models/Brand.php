<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Brand
 * 
 * @property int $brand_id
 * @property string|null $description
 * 
 * @property Collection|Hardware[] $hardware
 *
 * @package App\Models
 */
class Brand extends Model
{
	protected $table = 'brand';
	protected $primaryKey = 'brand_id';
	public $timestamps = false;

	protected $fillable = [
		'description'
	];

	public function hardware()
	{
		return $this->hasMany(Hardware::class);
	}
}
