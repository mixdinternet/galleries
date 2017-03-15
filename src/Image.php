<?php

namespace Mixdinternet\Galleries;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    use SoftDeletes;

    protected $table = 'galleries_images';

    protected $fillable = ['name', 'description', 'order'];

    public function gallery()
    {
        return $this->belongsTo(\Mixdinternet\Galleries\Gallery::class);
    }
}
