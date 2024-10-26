<?php
namespace App\Traits;

trait ImageUpload
{
    public static function imageUpload($image, $folder)
    {
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $destinationPath = public_path($folder);
        $image->move($destinationPath, $imageName);
        $imagePath = $folder . '/' . $imageName;

        return $imagePath;
    }
}