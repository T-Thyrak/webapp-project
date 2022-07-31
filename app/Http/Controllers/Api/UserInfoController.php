<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserInfoController extends Controller
{
    public function update(Request $request, $user_id) {
        $name = request('name');
        $email = request('email');
        $old_pass = request('old-password');
        $new_pass = request('new-password');
        $new_pass_conf = request('new-password-confirm');

        $user = User::find($user_id);

        if ($user->password != Hash::check($old_pass, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Old password is incorrect!',
            ]);
        }

        if ($name) {
            if ($user->name != $name) {
                $user->name = $name;
            }
        }

        if ($email) {
            if ($user->email != $email) {
                $user->email = $email;
            }
        }

        if ($old_pass && $new_pass && $new_pass_conf) {
            if ($new_pass != $new_pass_conf) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'New password is not confirmed!',
                ]);
            }

            if (preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\[$@!%*?&\](){}#^`\'";,.])[A-Za-z\d$@!%*?&\[\](){}#^`\'";,.]{8,}$/', $new_pass)) {
                $user->password = Hash::make($new_pass);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'New password is not strong enough!',
                ]);
            }
        }

        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'User info updated!',
            'user_id' => $user->id,
            'name' => $name,
            'email' => $email,
        ]);
    }
}
