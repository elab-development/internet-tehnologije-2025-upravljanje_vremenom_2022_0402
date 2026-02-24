<?php

namespace App\Http\Controllers;

use App\Models\Zadatak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use OpenApi\Attributes as OA;

class ZadatakController extends Controller
{
    #[OA\Get(
    path: "/api/zadaci",
    summary: "Lista svih zadataka",
    tags: ["Zadaci"],
    responses: [
    new OA\Response(response: 200, description: "Uspešno vraćena lista zadataka")
]
)]

    public function index()
    {
        return Zadatak::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    #[OA\Post(
    path: "/api/zadaci",
    summary: "Kreiranje novog zadatka",
    tags: ["Zadaci"],
    requestBody: new OA\RequestBody(
    required: true,
    content: new OA\JsonContent(
    required: ["naslov", "korisnik_id"],
    properties: [
    new OA\Property(property: "naslov", type: "string", example: "Završiti projekat"),
    new OA\Property(property: "opis", type: "string", example: "Implementirati Swagger dokumentaciju"),
    new OA\Property(property: "uradjeno", type: "boolean", example: false),
    new OA\Property(property: "rok", type: "string", format: "date-time", example: "2026-02-25 23:59:00"),
    new OA\Property(property: "korisnik_id", type: "integer", example: 1),
],
    type: "object"
)
),
    responses: [
    new OA\Response(response: 201, description: "Zadatak uspešno kreiran"),
    new OA\Response(response: 422, description: "Validaciona greška")
]
)]

    public function store(Request $request)
    {
        $validator= Validator::make($request->all(),[
            'naslov' => 'required|string|max:255',
            'opis' => 'nullable|string',
            'uradjeno' => 'boolean',
            'rok' => 'nullable|date',
            'korisnik_id' => 'required|integer|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validacija nije prošla',
                'errors' => $validator->errors()
        ], 422);
        }
        $data = $validator ->validated();
        $zadatak = Zadatak::create($data);
        return response()->json($zadatak, 201);
    }

    #[OA\Get(
    path: "/api/zadaci/{id}",
    summary: "Prikaz jednog zadatka",
    tags: ["Zadaci"],
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
    new OA\Response(response: 200, description: "Zadatak pronađen"),
    new OA\Response(response: 404, description: "Zadatak nije pronađen")
]
)]

    public function show($id)
    {
        return Zadatak::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Zadatak $zadatak)
    {
        //
    }

    #[OA\Put(
    path: "/api/zadaci/{id}",
    summary: "Izmena zadatka",
    tags: ["Zadaci"],
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
    new OA\Property(property: "naslov", type: "string", example: "Izmenjen naslov"),
    new OA\Property(property: "opis", type: "string", example: "Izmenjen opis"),
    new OA\Property(property: "uradjeno", type: "boolean", example: true),
    new OA\Property(property: "rok", type: "string", format: "date-time", example: "2026-02-28 18:00:00"),
    new OA\Property(property: "korisnik_id", type: "integer", example: 1),
],
    type: "object"
)
),
    responses: [
    new OA\Response(response: 200, description: "Zadatak uspešno izmenjen"),
    new OA\Response(response: 404, description: "Zadatak nije pronađen"),
    new OA\Response(response: 422, description: "Validaciona greška")
]
)]

    public function update(Request $request, $id)
    {
        $zadatak = Zadatak::find($id);

        if (!$zadatak) {
            return response()->json([
                'message' => 'Zadatak nije pronađen'
            ], 404);
        }

        $validator = Validator::make($request->all(),[
            'naslov' => 'sometimes|string|max:255',
            'opis' => 'sometimes|nullable|string',
            'uradjeno' => 'sometimes|boolean',
            'rok' => 'sometimes|nullable|date',
            'korisnik_id' => 'required|integer|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validacija nije prošla',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator ->validated();
        $zadatak->update($data);
        return response()->json($zadatak, 200);
    }

    #[OA\Delete(
    path: "/api/zadaci/{id}",
    summary: "Brisanje zadatka",
    tags: ["Zadaci"],
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
    new OA\Response(response: 200, description: "Zadatak uspešno obrisan"),
    new OA\Response(response: 404, description: "Zadatak nije pronađen")
]
)]

    public function destroy($id)
    {
        $zadatak = Zadatak::find($id);

        if (!$zadatak) {
            return response()->json([
                'message' => 'Zadatak nije pronađen'
            ], 404);
        }

        $zadatak->delete();

        return response()->json([
            'message' => 'Zadatak uspešno obrisan'
        ], 200);
    }
}
