<?php

namespace Mixdinternet\Galleries\Facades;

use Illuminate\Support\Facades\Facade;

class Gallery extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Mixdinternet\Galleries\Facades\Html';
    }
}