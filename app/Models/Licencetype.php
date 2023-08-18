<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Licencetype
 * 
 * @property int $licencetype_id
 * @property string $description
 * @property int|null $parent
 * 
 * @property Collection|Software[] $software
 *
 * @package App\Models
 */
class Licencetype extends Model
{
	protected $table = 'licencetype';
	protected $primaryKey = 'licencetype_id';
	public $timestamps = false;

	protected $casts = [
		'parent' => 'int'
	];

	protected $fillable = [
		'description',
		'parent'
	];

	public function software()
	{
		return $this->hasMany(Software::class);
	}
}
