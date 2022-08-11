<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class LecturerController extends Controller
{
    //
    public function update(Request $request, $user_id) {
        $is_lecturer = request('is_lecturer');

        if ($is_lecturer == 1) {
            $user = User::find($user_id);
            $user->is_lecturer = 1;
            $user->update();
        } else {
            $user = User::find($user_id);
            $user->is_lecturer = 0;
            $user->update();
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Lecturer status updated!',
        ]);
    }
}
