<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use OpenApi\Attributes as OA;


class AuthController extends Controller
{
    #[OA\Post(
    path: "/api/register",
    summary: "Registracija korisnika (regular, premium ili admin)",
    tags: ["Authentication"],
    requestBody: new OA\RequestBody(
        required: true,
    content: new OA\JsonContent(
    required: ["name","email","password","password_confirmation","tip"],
        properties: [
            new OA\Property(property: "name", type: "string", example: "Jelena Vasiljević"),
            new OA\Property(property: "email", type: "string", format: "email", example: "jelena@email.com"),
            new OA\Property(property: "password", type: "string", example: "123456"),
            new OA\Property(property: "password_confirmation", type: "string", example: "123456"),
            new OA\Property(
                property: "tip",
                type: "string",
                enum: ["regular","premium","admin"],
                example: "regular",
                description: "Tip korisnika u sistemu"
    )
    ],
        type: "object"
    )
    ),
    responses: [
    new OA\Response(response: 201, description: "Uspešna registracija"),
    new OA\Response(response: 422, description: "Validaciona greška")
    ]
    )]


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

    #[OA\Post(
    path: "/api/login",
    summary: "Prijava korisnika (Sanctum token)",
    tags: ["Authentication"],
    requestBody: new OA\RequestBody(
    required: true,
    content: new OA\JsonContent(
    required: ["email","password"],
    properties: [
    new OA\Property(property: "email", type: "string", format: "email", example: "jelena@email.com"),
    new OA\Property(property: "password", type: "string", example: "123456")
],
    type: "object"
)
),
    responses: [
    new OA\Response(response: 200, description: "Uspešna prijava"),
    new OA\Response(response: 401, description: "Neispravni kredencijali"),
    new OA\Response(response: 422, description: "Validaciona greška")
]
)]

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
    #[OA\Post(
    path: "/api/logout",
    summary: "Odjava korisnika (briše trenutni token)",
    tags: ["Authentication"],
    security: [["bearerAuth" => []]],
    responses: [
    new OA\Response(response: 200, description: "Uspešna odjava"),
    new OA\Response(response: 401, description: "Unauthorized")
]
)]
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
    #[OA\Get(
    path: "/api/me",
    summary: "Podaci o trenutno prijavljenom korisniku",
    tags: ["Authentication"],
    security: [["bearerAuth" => []]],
    responses: [
    new OA\Response(response: 200, description: "Podaci o korisniku"),
    new OA\Response(response: 401, description: "Unauthorized")
]
)]

    //ME
    public function me(Request $request)
    {
        return response()->json($request->user());
    }
}
