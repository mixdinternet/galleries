<?php

namespace Mixdinternet\Galleries;

trait GalleriableTrait
{

    public static function bootGalleriableTrait()
    {
        self::saved(function ($model) {

            # comunidade é foda
            # dica do @vinicius73
            /*if ($model->tenant_id != 0 && empty($model->tenant_id)) {
                throw new \InvalidArgumentException(get_class($model).' need to be a valid tenant_id attribute');
            }*/

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

                        $md5 = md5($gallery->id);
                        $subDir = substr($md5, 0, 2) . '/' . substr($md5, 2, 2) . '/' . substr($md5, 4, 2);

                        $targetPath = public_path('media/gallery/') . $subDir;
                        @mkdir($targetPath, 0775, true);

                        rename($fullPath, $targetPath . '/' . $v);

                        $image = new Image();
                        $image->name = '/media/gallery/' . $subDir . '/' . $v;
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
        return $this->morphMany('Mixdinternet\Galleries\Gallery', 'galleriable')->where('name', $name);
    }

    public function gallery($name = 'images'){
        return $this->galleries($name)->first();
    }

    public function getGalleryAttribute(){
        return $this->gallery();
    }    

}
