<?php

namespace App\Services;

use App\Models\User;

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

        $password = $validatedData['password'] ?? null;
        $confirm_password = $validatedData['confirm_password'] ?? null;
        unset($data['password']);
        unset($data['confirm_password']);

        $user = User::updateOrCreate(['id' => $id], $data);
        $user->is_verified = '1';
        if ($password && $confirm_password) {
            $user->update([
                'password' => bcrypt($password),
                'confirm_password' => bcrypt($confirm_password)
            ]);
        }
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
