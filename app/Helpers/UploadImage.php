<?php
namespace App\Helpers;
/**
 * Created by PhpStorm.
 * User: hassan
 * Date: 11/5/2020
 * Time: 11:46 PM
 */
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Intervention\Image\Constraint;
class UploadImage
{
    public static function upload($file,$slug){
        $fullFilename = null;
        $resizeWidth = 1800;
        $resizeHeight = null;


        $path = $slug.'/'.date('F').date('Y').'/';

        $filename = basename(hash('sha256',$file->getClientOriginalName().date('F').date('Y').time()), '.'.$file->getClientOriginalExtension());
        $filename_counter = 1;

        // Make sure the filename does not exist, if it does make sure to add a number to the end 1, 2, 3, etc...
        while (Storage::disk(config('voyager.storage.disk'))->exists($path.$filename.'.'.$file->getClientOriginalExtension())) {
            $filename = basename(hash('sha256',$file->getClientOriginalName().date('F').date('Y').time()), '.'.$file->getClientOriginalExtension()).(string) ($filename_counter++);
        }

        $fullPath = $path.$filename.'.'.$file->getClientOriginalExtension();

        $ext = $file->guessClientExtension();

        $image = Image::make($file)
            ->resize($resizeWidth, $resizeHeight, function (Constraint $constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
        if (session()->has('mob'))
            $image->orientate();
        $image->encode($file->getClientOriginalExtension(), 75);

        // move uploaded file from temp to uploads directory
        Storage::disk(config('voyager.storage.disk'))->put($fullPath, (string)$image, 'public');


        return $fullPath;

    }
}