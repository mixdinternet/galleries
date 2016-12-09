<?php

namespace Mixdinternet\Galleries\Facades;

class Html
{
    public function form($model = '', $name = 'images')
    {
        return view('mixdinternet/galleries::admin.galleries.form', [
            'gallery' => $model->galleries($name)->first()
            , 'name' => $name
        ])->render();
    }
}