<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function register()
    {
        $data = request()->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', Rule::unique('users')],
            'age'      => ['required', 'numeric', 'min:0'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // $data['password'] = bcrypt($data['password']); 

        $user = User::query()->create($data);

        $token = $user->createToken(env('SANCTUM_NAME'))->plainTextToken;

        return response()->json(['token' => $token]);
    }

    public function login()
    {
        $data = request()->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::query()->firstWhere('email', $data['email']);

        if(!$user){
            return response()->json(['message' => 'Email does not exists'],404);
        }

        if(!Hash::check($data['password'], $user->password)){
            return response()->json(['message' => 'Password incorrect'],400);
        }

        // Auth::login();
        $token = $user->createToken(env('SANCTUM_NAME'))->plainTextToken;

        return response()->json(['token' => $token]);
        
    }

    public function logout(Request $request)
    {
        if($request->type == 'all'){
            $request->user()->tokens()->delete();
        }else{
            $request->user()->currentAccessToken()->delete();
        }

        return response()->noContent();
    }

}
