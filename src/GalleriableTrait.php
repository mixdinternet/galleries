<?php

namespace Mixdinternet\Galleries;

trait GalleriableTrait
{
    public static function bootGalleriableTrait()
    {
        self::saved(function ($model) {
            if (!request()->has('gallery')) {
                return;
            }

            if (!request()->has('images')) {
                return;
            }

            $reqGallery = request()->get('gallery');
            $reqImages = request()->get('images');

            foreach ($reqGallery as $galleryName) {

                if (isset($reqImages[$galleryName])) {
                    $gallery = $model->galleries($galleryName)->first();
                    if ($gallery == null) {
                        $gallery = $model->galleries($galleryName)->create(['name' => $galleryName]);
                    }

                    $last = $gallery->images()->get()->last();
                    $count = 0;
                    if ($last) {
                        $count = ($last->order + 1);
                    }

                    foreach ($reqImages[$galleryName] as $k => $v) {
                        $fullPath = storage_path('cache/images/') . $v;
                        if (!file_exists($fullPath))
                            continue;

                        $subDir = implode('/', str_split(substr(md5($gallery->id), 0, 6), 2));

                        $targetPath = public_path('media/gallery/') . $subDir;
                        @mkdir($targetPath, 0775, true);

                        $friendlyName = $v;
                        if(method_exists($model, 'galleriableName')) {
                            $extension = pathinfo($v, PATHINFO_EXTENSION);
                            $friendlyName = uniqid(str_slug($model->galleriableName()) . '-') . '.' . $extension;
                        }

                        rename($fullPath, $targetPath . '/' . $friendlyName);

                        $image = new Image();
                        $image->name = '/media/gallery/' . $subDir . '/' . $friendlyName;
                        $image->description = '';
                        $image->order = ($k + $count);
                        $image->gallery()->associate($gallery);
                        $image->save();
                    }
                }
            }
        });
    }

    public function galleries($name = 'images')
    {
        return $this->morphMany(\Mixdinternet\Galleries\Gallery::class, 'galleriable')->where('name', $name);
    }

    public function gallery($name = 'images')
    {
        return $this->galleries($name)->first();
    }

    public function getGalleryAttribute()
    {
        return $this->gallery();
    }

    public function flatGallery($name = 'images')
    {
        $gallery = $this->galleries($name)->first();
        if (!$gallery) {
            return [];
        }

        return $gallery->images()->select('id', 'name', 'description', 'order')->get();
    }
}
