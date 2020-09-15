<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class SecurityController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
       ]);

        if ($validator->fails()) {
            return json_abort($validator->messages());
        }

        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return json_abort('Unauthorized');
        }

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return json_abort('The provided credentials are incorrect');
        }

        return response()->json([
            'token' => $user->createToken($user->email)->plainTextToken,
            'data' => $user
        ]);
    }

    public function me(Request $request)
    {
        dd($request->user());
        return $request->user();
    }


}
