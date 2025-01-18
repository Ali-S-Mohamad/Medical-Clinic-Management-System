<?php

namespace App\Services;

use App\Models\User;
class UserService
{
    public function saveOrUpdateUserDetails($data, $id)
    {
        //check password
        if ($data['password'] !== $data['confirm_password']) {
            return redirect()->back()->with('error', 'Password does not match .');
        }
        $user = User::updateOrCreate(['id' => $id],$data);
        $user->is_verified = '1' ;
        $user->save();

        if ($user->wasRecentlyCreated){
            if(isset($data['is_doctor']) && $data['is_doctor'] == 1){
                $user->assignRole('doctor');
            } elseif(!(isset($data['is_patient']) && $data['is_patient'] == 1))
                $user->assignRole('employee');
        }
        
        if (isset($data['is_patient']) && $data['is_patient'] == 1){
            $user->assignRole('patient');
        }
        return $user;
    }
}


