<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

trait UploadTrait
{
    //Function Global untuk mengupload Gambar
    public function upload(Request $request, $path)
    {
        // $quality = 70;
        // $default_path = 'image/' . $path . '/';
        // $file = $request->file('image');
        // if ($file) {
        //     $file_name = time() . '.' . $file->getClientOriginalExtension();
        //     $final_path = $default_path . $file_name;
        //     $img = Image::make($file);
        //     $img->save($final_path, $quality);

        //     return $final_path;
        //     // Storage::disk('digitalocean')->put('/Penerima/' . $file_name, $file, 'public');
        //     // $url = Storage::disk('digitalocean')->url('/Penerima' . $file_name);
        //     // return $url;
        // }
        // return null;
        $default_path = 'image/' . $path;
        $file = $request->file('image');
        if ($file) {

            // (Development mode) Upload ke folder local
            // $file_name = time() . '_' . $file->getClientOriginalName();
            // $final_path = $default_path . '/' . $file_name;
            // if (!Storage::exists($default_path)) {
            //     Storage::makeDirectory($default_path);
            // }
            // Storage::put($final_path, file_get_contents($file));
            // return Storage::url($final_path);

            // (Production mode) Upload ke folder digitalocean
            $test = Storage::disk('digitalocean')->put($default_path, $file, 'public');
            return Storage::disk('digitalocean')->url($test);
        }
        return null;
    }

    public function multiPicture(Request $request, $path)
    {
        $default_path = 'image/' . $path;
        $combined_path = null;
        $files = $request->file('image');
        foreach ($files as $file) {
            // (Development mode) Upload ke folder local
            // $file_name = time() . '_' . $file->getClientOriginalName();
            // $final_path = $default_path . '/' . $file_name;

            // if (!Storage::exists($default_path)) {
            //     Storage::makeDirectory($default_path);
            // }

            // Storage::put($final_path, file_get_contents($file));
            // $url = Storage::url($final_path);

            // if ($combined_path == null) {
            //     $combined_path = $url;
            // } else {
            //     $combined_path = $combined_path . ";" . $url;
            // }

            // (Production mode) Upload ke folder digitalocean
            $test = Storage::disk('digitalocean')->put($default_path, $file, 'public');
            if ($combined_path == "") {
                $url = Storage::disk('digitalocean')->url($test);
                $combined_path = $url;
            } else {
                $url = Storage::disk('digitalocean')->url($test);
                $combined_path = $combined_path . ";" . $url;
            }
        }
        return $combined_path;
    }
}
