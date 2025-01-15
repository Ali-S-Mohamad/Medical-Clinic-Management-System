
<?php

use Illuminate\Support\Facades\Storage;

if (!function_exists('saveCvFile')) {
    function uploadCvFile($folder, $request,  $cv_path, $disk='public')
    {    
        if ($request->hasFile('pdf_cv')) {
            if(isset($cv_path)) 
                Storage::disk($disk)->delete($cv_path);            
            $cvFile = $request->file('pdf_cv');
            $cvFileName = time() . '_' . $cvFile->getClientOriginalName();
            return $cvFile->storeAs( $folder , $cvFileName, $disk);
        }
        return $cv_path; 
        // Keeps the old path without change if the user info is modified without modifying the file..
    }
}