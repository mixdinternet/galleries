<?php namespace Mixdinternet\Galleries;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use SimpleSoftwareIO\Cache\Cacheable;

class Gallery extends Model {

	use SoftDeletes, Cacheable;

    protected $cacheBusting = true;

    protected $fillable = [
        'name'
    ];

	public function galleriable()
    {
        return $this->morphTo();
    }

    public function images()
    {
    	return $this->hasMany('Mixdinternet\Galleries\Image')->orderBy('order', 'asc');
    }

	public function image()
	{
		return $this->images()->first();
	}
}
