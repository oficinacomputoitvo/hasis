<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Classification
 * 
 * @property int $classification_id
 * @property string $description
 * 
 * @property Collection|Software[] $software
 *
 * @package App\Models
 */
class Classification extends Model
{
	protected $table = 'classification';
	protected $primaryKey = 'classification_id';
	public $timestamps = false;

	protected $fillable = [
		'description'
	];

	public function software()
	{
		return $this->hasMany(Software::class);
	}
}
