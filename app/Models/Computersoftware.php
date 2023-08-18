<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Computersoftware
 * 
 * @property int $computersoftware_id
 * @property int|null $computer_id
 * @property int|null $software_id
 * @property Carbon|null $installationdate
 * @property string|null $comment
 * 
 * @property Computer|null $computer
 * @property Software|null $software
 *
 * @package App\Models
 */
class Computersoftware extends Model
{
	protected $table = 'computersoftware';
	protected $primaryKey = 'computersoftware_id';
	public $timestamps = false;

	protected $casts = [
		'computer_id' => 'int',
		'software_id' => 'int'
	];

	protected $dates = [
		'installationdate'
	];

	protected $fillable = [
		'computer_id',
		'software_id',
		'installationdate',
		'comment'
	];

	public function computer()
	{
		return $this->belongsTo(Computer::class);
	}

	public function software()
	{
		return $this->belongsTo(Software::class);
	}
}
