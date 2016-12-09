<?php namespace Mixdinternet\Galleries;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gallery extends Model {

	use SoftDeletes;

	protected $fillable = ['name'];

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
