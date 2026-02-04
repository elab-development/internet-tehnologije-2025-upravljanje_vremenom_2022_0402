<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // REGISTER
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'tip' => 'required|in:regular,premium,admin',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validacija nije prošla',
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = $validator -> validated();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'tip' => $request->tip,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('api_token')->plainTextToken;

        return response()->json([
            'message' => 'Uspešna registracija',
            'user' => $user,
            'token' => $token,
        ], 201);
    }

    // LOGIN
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validacija nije prošla',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Neispravni kredencijali',
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Uspešna prijava',
            'user' => $user,
            'token' => $token,
        ], 200);
    }

    // LOGOUT
    public function logout(Request $request)
    {
        $user = $request->user();
        //obrisemo samo trenutni token
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Uspešno ste se izlogovali',
        ], 200);
    }

    public function me(Request $request)
    {
        return response()->json($request->user());
    }
}
