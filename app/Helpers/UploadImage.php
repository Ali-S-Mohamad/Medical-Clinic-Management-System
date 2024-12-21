<?php

use Illuminate\Support\Facades\Storage;


if (!function_exists('saveImage')) {
    function saveImage($folder, $request, $employee, $disk = 'public') {
        if ($request->hasFile('profile_image')) {
            // new image path
            $path = $request->file('profile_image');
            $image_name = time() . '_' . $path->getClientOriginalName(); 
            $path = $path->storeAs($folder, $image_name, $disk);

            // delete old image IF exists
            if ($employee->image) {
                Storage::disk($disk)->delete($employee->image->image_path);
            }

            // create OR update employee image
            $employee->image()->updateOrCreate(
                [],
                ['image_path' => $path]
            );
        }
}

    // function updateImage($folder, $request, $employee, $disk='public')
    // {
    //     if ($request->hasFile('profile_image')) {
    //         $existingImage = $employee->image;

    //         // delete image from disk + delete path from image table
    //         if ($existingImage) {
    //             Storage::disk($disk)->delete($existingImage->image_path);
    //             $existingImage->delete();
    //         }

    //         // upload image
    //         $path = $request->file('profile_image');
    //         $image_name = time() . '_' . $path->getClientOriginalName(); 
    //         $path = $path->storeAs($folder, $image_name, $disk);

    //         // save image path in images table
    //         $image = new Image();
    //         $image->image_path = $path;
    //         $image->imageable_id = $employee->id; // ID الموظف
    //         $image->imageable_type = 'App\Models\Employee';
    //         $image->save();
    //     }
    // }
}