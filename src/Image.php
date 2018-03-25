<?php

namespace Mixdinternet\Galleries;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use SimpleSoftwareIO\Cache\Cacheable;

class Image extends Model {

	use SoftDeletes, Cacheable;

    protected $cacheBusting = true;

    protected $table = 'galleries_images';

	protected $fillable = [
	    'name', 'description', 'order'
    ];

	public function gallery()
	{
		return $this->belongsTo('Mixdinternet\Galleries\Gallery');
	}

}
