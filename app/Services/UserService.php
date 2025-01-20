<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    /**
     * A function to save or update user details
     * @param mixed $data
     * @param mixed $id
     * @return User|\Illuminate\Database\Eloquent\Model|\Illuminate\Http\RedirectResponse
     */
    public function saveOrUpdateUserDetails($data, $id)
    {
        //check password
        if ($data['password'] !== $data['confirm_password']) {
            return redirect()->back()->with('error', 'Password does not match .');
        }

        $password = $data['password'] ?? null;
        $confirm_password = $data['confirm_password'] ?? null;
        $user = User::find($id);
        if($user){
            unset($data['password']);
            unset($data['confirm_password']);
            if ($password && $confirm_password) {
                $user->update([
                    'password' => Hash::make($password),
                    'confirm_password' => Hash::make($confirm_password)
                ]);
            }
        }

        $user = User::updateOrCreate(['id' => $id], $data);
        $user->is_verified = '1';

        $user->save();

        if ($user->wasRecentlyCreated) {
            if (isset($data['is_doctor']) && $data['is_doctor'] == 1) {
                $user->assignRole('doctor');
            } elseif (!(isset($data['is_patient']) && $data['is_patient'] == 1))
                $user->assignRole('employee');
        }

        if (isset($data['is_patient']) && $data['is_patient'] == 1) {
            $user->assignRole('patient');
        }
        return $user;
    }
}
