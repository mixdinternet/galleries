<?php

namespace Mixdinternet\Galleries\Http\Controllers;

use Illuminate\Http\Request;
use Mixdinternet\Admix\Http\Controllers\AdmixController;
use Folklore\Image\Facades\Image as FolkloreImage;
use Mixdinternet\Galleries\Gallery;
use Mixdinternet\Galleries\Image;

class GalleriesAdminController extends AdmixController
{
    public function upload(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');

            $tmpPath = storage_path('cache/tmp');
            $imagesPath = storage_path('cache/images');

            @mkdir($tmpPath, 0775, true);
            @mkdir($imagesPath, 0775, true);

            $fileInfo = pathinfo($file->getClientOriginalName());
            $fileName = str_slug(str_limit($fileInfo['filename'], 50, '') . '-' . rand(1, 999)) . '.' . $file->getClientOriginalExtension();
            $file->move($tmpPath, $fileName);

            $config = config('mgalleries.galleries');
            $default = [
                'width' => 800
                , 'height' => 600
                , 'quality' => 90
            ];
            $mergeConfig = array_merge($default, $config);

            FolkloreImage::make(storage_path('cache/tmp') . '/' . $fileName, [
                $mergeConfig
            ])->save($imagesPath . '/' . $fileName);

            if(config('mgalleries.watermark')) {
                $imagine = new \Imagine\Imagick\Imagine();
                $watermark = $imagine->open(config('mgalleries.watermark'));
                $image = $imagine->open($imagesPath . '/' . $fileName);
                $size = $image->getSize();
                $watermark->resize(new \Imagine\Image\Box($size->getWidth(), $size->getHeight()));
                $wSize = $watermark->getSize();
                $position = new \Imagine\Image\Point($size->getWidth() - $wSize->getWidth(), $size->getHeight() - $wSize->getHeight());

                $image->paste($watermark, $position);
                $image->save($imagesPath . '/' . $fileName);
            }

            return [
                'status' => 'success'
                , 'name' => $fileName
            ];
        }

        return [
            'status' => 'error'
        ];
    }

    public function sort(Request $request)
    {
        $images = $request->get('image');

        foreach ($images as $k => $v) {
            Image::find($v)->update(['order' => $k]);
        }
    }

    public function update(Request $request)
    {
        $id = $request->get('id');
        $description = $request->get('description');

        Image::find($id)->update(['description' => $description]);
    }

    public function destroy(Request $request)
    {
        $id = $request->get('id');

        Image::destroy($id);
    }
}