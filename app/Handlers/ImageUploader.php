<?php

namespace App\Handlers;

use Image;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageUploader
{
    protected $allowedExtensions = ['jpg', 'jpeg', 'png', 'bmp', 'gif'];

    public function save(UploadedFile $file, $folder, $prefix, $maxWidth = null, $maxHeight = null)
    {
        $extension = strtolower($file->getClientOriginalExtension()) ? : 'png';

        if (!in_array($extension, $this->allowedExtensions)) {
            return false;
        }

        $filename = $prefix.'_'.time().'_'.str_random(8).'.'.$extension;    //文件名
        $folderInPublic = 'uploads/images/'.$folder.'/'.date('Y/m/d').'/';  //从public文件夹开始的文件夹路径
        $folderInRoot = public_path($folderInPublic);   //从项目根目录开始的文件夹路径

        $file->move($folderInRoot, $filename);

        if (($maxWidth || $maxHeight) && $extension !== 'gif') {
            $this->reduceSize($folderInRoot.$filename, $maxWidth, $maxHeight);
        }

        return [
            'path' => config('app.url').'/'.$folderInPublic.$filename,
        ];
    }


    public function reduceSize($file, $width, $height)
    {
        $image = Image::make($file);
        $image->resize($width, $height, function($constraint) {
            $constraint->upsize();  //不变大
        });
        $image->save();
    }
}