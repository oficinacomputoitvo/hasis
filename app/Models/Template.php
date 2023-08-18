<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Template
 * 
 * @property int $template_id
 * @property string $documentname
 * @property string $reference
 * @property string $code
 * @property string $review
 * @property string $logo
 * @property string|null $legendfootercenter
 *
 * @package App\Models
 */
class Template extends Model
{
	protected $table = 'template';
	protected $primaryKey = 'template_id';
	public $timestamps = false;

	protected $fillable = [
		'documentname',
		'reference',
		'code',
		'review',
		'logo',
		'legendfootercenter'
	];
}
