<?php

use Illuminate\Support\Facades\Storage;


if (!function_exists('saveImage')) {
    function saveImage($folder, $request, $user, $disk = 'public')
    {
        if ($request->hasFile('profile_image')) {
            // new image path
            $path = $request->file('profile_image');
            $image_name = time() . '_' . $path->getClientOriginalName();
            $path = $path->storeAs($folder, $image_name, $disk);

            // delete old image IF exists
            if ($user->image) {
                Storage::disk($disk)->delete($user->image->image_path);
            }

            // create OR update user image
            $user->image()->updateOrCreate(
                [],
                ['image_path' => $path]
            );
        }
    }
}
