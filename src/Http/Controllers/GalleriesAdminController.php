<?php

namespace Mixdinternet\Galleries\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use Folklore\Image\Facades\Image as FolkloreImage;
use Mixdinternet\Galleries\Gallery;
use Mixdinternet\Galleries\Image;

class GalleriesAdminController extends AdminController
{

    public function upload(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');

            $fileInfo = pathinfo($file->getClientOriginalName());
            $fileName = str_slug(str_limit($fileInfo['filename'], 50, '') . '-' . rand(1, 999)) . '.' . $file->getClientOriginalExtension();
            $file->move(storage_path('cache/tmp'), $fileName);

            FolkloreImage::make(storage_path('cache/tmp') . '/' . $fileName, [
                'width' => 1024,
                'quality' => 90
            ])->save(storage_path('cache/images') . '/' . $fileName);

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