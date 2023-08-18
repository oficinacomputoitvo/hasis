<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Computer
 * 
 * @property int $computer_id
 * @property int|null $hardware_id
 * @property string|null $inventorynumber
 * @property string|null $identifier
 * @property string|null $ram
 * @property string|null $useros
 * @property string|null $harddisk
 * @property string|null $processor
 * 
 * @property Hardware|null $hardware
 * @property Collection|Software[] $software
 *
 * @package App\Models
 */
class Computer extends Model
{
	protected $table = 'computer';
	protected $primaryKey = 'computer_id';
	public $timestamps = false;

	protected $casts = [
		'hardware_id' => 'int'
	];

	protected $fillable = [
		'hardware_id',
		'inventorynumber',
		'identifier',
		'ram',
		'useros',
		'harddisk',
		'processor'
	];

	public function hardware()
	{
		return $this->belongsTo(Hardware::class);
	}

	public function software()
	{
		return $this->belongsToMany(Software::class, 'computersoftware')
					->withPivot('computersoftware_id', 'installationdate', 'comment');
	}
}
