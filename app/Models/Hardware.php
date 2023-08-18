<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Hardware
 * 
 * @property int $hardware_id
 * @property string|null $inventorynumber
 * @property int|null $category_id
 * @property int|null $brand_id
 * @property string|null $features
 * @property string|null $serial
 * @property string|null $model
 * @property string|null $image
 * @property int|null $status_id
 * @property string|null $comments
 * 
 * @property Brand|null $brand
 * @property Category|null $category
 * @property Status|null $status
 * @property Collection|Assignment[] $assignments
 * @property Collection|Computer[] $computers
 * @property Collection|Executionofservice[] $executionofservices
 * @property Collection|Maintenancescheduleservicedetail[] $maintenancescheduleservicedetails
 * @property Collection|Servicerequest[] $servicerequests
 *
 * @package App\Models
 */
class Hardware extends Model
{
	protected $table = 'hardware';
	protected $primaryKey = 'hardware_id';
	public $timestamps = false;

	protected $casts = [
		'category_id' => 'int',
		'brand_id' => 'int',
		'status_id' => 'int'
	];

	protected $fillable = [
		'inventorynumber',
		'category_id',
		'brand_id',
		'features',
		'serial',
		'model',
		'image',
		'status_id',
		'comments'
	];

	public function brand()
	{
		return $this->belongsTo(Brand::class);
	}

	public function category()
	{
		return $this->belongsTo(Category::class);
	}

	public function status()
	{
		return $this->belongsTo(Status::class);
	}

	public function assignments()
	{
		return $this->hasMany(Assignment::class);
	}

	public function computers()
	{
		return $this->hasMany(Computer::class);
	}

	public function executionofservices()
	{
		return $this->hasMany(Executionofservice::class);
	}

	public function maintenancescheduleservicedetails()
	{
		return $this->hasMany(Maintenancescheduleservicedetail::class);
	}

	public function servicerequests()
	{
		return $this->hasMany(Servicerequest::class);
	}
}
