<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Software
 * 
 * @property int $software_id
 * @property int|null $classification_id
 * @property int|null $licencetype_id
 * @property string $name
 * @property string|null $version
 * @property string|null $licence
 * 
 * @property Classification|null $classification
 * @property Licencetype|null $licencetype
 * @property Collection|Computer[] $computers
 *
 * @package App\Models
 */
class Software extends Model
{
	protected $table = 'software';
	protected $primaryKey = 'software_id';
	public $timestamps = false;

	protected $casts = [
		'classification_id' => 'int',
		'licencetype_id' => 'int'
	];

	protected $fillable = [
		'classification_id',
		'licencetype_id',
		'name',
		'version',
		'licence'
	];

	public function classification()
	{
		return $this->belongsTo(Classification::class);
	}

	public function licencetype()
	{
		return $this->belongsTo(Licencetype::class);
	}

	public function computers()
	{
		return $this->belongsToMany(Computer::class, 'computersoftware', 'software_id', 'inventorynumber')
					->withPivot('computersoftware_id', 'installationdate', 'comment');
	}
}
