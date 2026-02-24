<?php

namespace App\Http\Controllers;

use App\Models\Obavestenje;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use OpenApi\Attributes as OA;

class ObavestenjeController extends Controller
{
    #[OA\Get(
    path: "/api/obavestenja",
    summary: "Lista svih obaveštenja",
    tags: ["Obaveštenja"],
    responses: [
    new OA\Response(response: 200, description: "Uspešno vraćena lista obaveštenja")
]
)]

    public function index()
    {
        return Obavestenje::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    #[OA\Post(
    path: "/api/obavestenja",
    summary: "Kreiranje novog obaveštenja",
    tags: ["Obaveštenja"],
    requestBody: new OA\RequestBody(
    required: true,
    content: new OA\JsonContent(
    required: ["poruka", "poslato", "nacin_slanja", "korisnik_id"],
    properties: [
    new OA\Property(property: "poruka", type: "string", example: "Podsetnik za sastanak u 15h"),
    new OA\Property(property: "poslato", type: "string", format: "date-time", example: "2026-02-23 14:00:00"),
    new OA\Property(property: "nacin_slanja", type: "string", example: "email"),
    new OA\Property(property: "korisnik_id", type: "integer", example: 1),
],
    type: "object"
)
),
    responses: [
    new OA\Response(response: 201, description: "Obaveštenje uspešno kreirano"),
    new OA\Response(response: 422, description: "Validaciona greška")
]
)]

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'poruka' => 'required|string|max:500',
            'poslato' => 'required|date',
            'nacin_slanja' => 'required|string|max:50',
            'korisnik_id' => 'required|integer|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validacija nije prošla',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();
        $obavestenje = Obavestenje::create($data);

        return response()->json($obavestenje, 201);
    }

    #[OA\Get(
    path: "/api/obavestenja/{id}",
    summary: "Prikaz jednog obaveštenja",
    tags: ["Obaveštenja"],
    parameters: [
    new OA\Parameter(
    name: "id",
    in: "path",
    required: true,
    schema: new OA\Schema(type: "integer"),
    example: 1
)
],
    responses: [
    new OA\Response(response: 200, description: "Obaveštenje pronađeno"),
    new OA\Response(response: 404, description: "Obaveštenje nije pronađeno")
]
)]

    public function show($id)
    {
        $obavestenje = Obavestenje::find($id);

        if (!$obavestenje) {
            return response()->json([
                'message' => 'Obaveštenje nije pronađeno'
            ], 404);
        }

        return response()->json($obavestenje, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Obavestenje $obavestenje)
    {
        //
    }

    #[OA\Put(
    path: "/api/obavestenja/{id}",
    summary: "Izmena obaveštenja",
    tags: ["Obaveštenja"],
    parameters: [
    new OA\Parameter(
    name: "id",
    in: "path",
    required: true,
    schema: new OA\Schema(type: "integer"),
    example: 1
)
],
    requestBody: new OA\RequestBody(
    required: false,
    content: new OA\JsonContent(
    properties: [
    new OA\Property(property: "poruka", type: "string", example: "Izmenjena poruka"),
    new OA\Property(property: "poslato", type: "string", format: "date-time", example: "2026-02-23 15:00:00"),
    new OA\Property(property: "nacin_slanja", type: "string", example: "sms"),
],
    type: "object"
)
),
    responses: [
    new OA\Response(response: 200, description: "Obaveštenje uspešno izmenjeno"),
    new OA\Response(response: 404, description: "Obaveštenje nije pronađeno"),
    new OA\Response(response: 422, description: "Validaciona greška")
]
)]

    public function update(Request $request, $id)
    {
        $obavestenje = Obavestenje::find($id);

        if (!$obavestenje) {
            return response()->json([
                'message' => 'Obaveštenje nije pronađeno'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'poruka' => 'sometimes|string|max:500',
            'poslato' => 'sometimes|date',
            'nacin_slanja' => 'sometimes|string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validacija nije prošla',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();
        $obavestenje->update($data);

        return response()->json($obavestenje, 200);
    }

    #[OA\Delete(
    path: "/api/obavestenja/{id}",
    summary: "Brisanje obaveštenja",
    tags: ["Obaveštenja"],
    parameters: [
    new OA\Parameter(
    name: "id",
    in: "path",
    required: true,
    schema: new OA\Schema(type: "integer"),
    example: 1
)
],
    responses: [
    new OA\Response(response: 200, description: "Obaveštenje uspešno obrisano"),
    new OA\Response(response: 404, description: "Obaveštenje nije pronađeno")
]
)]

    public function destroy($id)
    {
        $obavestenje = Obavestenje::find($id);

        if (!$obavestenje) {
            return response()->json([
                'message' => 'Obaveštenje nije pronađeno'
            ], 404);
        }

        $obavestenje->delete();

        return response()->json([
            'message' => 'Obaveštenje uspešno obrisano'
        ], 200);
    }
}
