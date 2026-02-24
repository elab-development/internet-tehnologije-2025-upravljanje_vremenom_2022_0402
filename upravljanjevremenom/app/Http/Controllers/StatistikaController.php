<?php

namespace App\Http\Controllers;

use App\Models\Statistika;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use OpenApi\Attributes as OA;

class StatistikaController extends Controller
{
    #[OA\Get(
    path: "/api/statistike",
    summary: "Lista svih statistika",
    tags: ["Statistika"],
    responses: [
    new OA\Response(response: 200, description: "Uspešno vraćena lista statistika")
]
)]

    public function index()
    {
        return Statistika::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    #[OA\Post(
    path: "/api/statistike",
    summary: "Kreiranje nove statistike",
    tags: ["Statistika"],
    requestBody: new OA\RequestBody(
    required: true,
    content: new OA\JsonContent(
    required: [
    "broj_odradjenih_zadataka",
    "ukupan_broj_zadataka",
    "procenat_uspesnosti",
    "korisnik_id"
],
    properties: [
    new OA\Property(property: "broj_odradjenih_zadataka", type: "integer", example: 8),
    new OA\Property(property: "ukupan_broj_zadataka", type: "integer", example: 10),
    new OA\Property(property: "procenat_uspesnosti", type: "number", example: 80),
    new OA\Property(property: "korisnik_id", type: "integer", example: 1),
],
    type: "object"
)
),
    responses: [
    new OA\Response(response: 201, description: "Statistika uspešno kreirana"),
    new OA\Response(response: 422, description: "Validaciona greška")
]
)]

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'broj_odradjenih_zadataka' => 'required|integer|min:0',
            'ukupan_broj_zadataka' => 'required|integer|min:1',
            'procenat_uspesnosti' => 'required|numeric|min:0|max:100',
            'korisnik_id' => 'required|integer|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validacija nije prošla',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();
        $statistika = Statistika::create($data);

        return response()->json($statistika, 201);
    }

    #[OA\Get(
    path: "/api/statistike/{id}",
    summary: "Prikaz jedne statistike",
    tags: ["Statistika"],
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
    new OA\Response(response: 200, description: "Statistika pronađena"),
    new OA\Response(response: 404, description: "Statistika nije pronađena")
]
)]

    public function show($id)
    {
        $statistika = Statistika::find($id);

        if (!$statistika) {
            return response()->json([
                'message' => 'Statistika nije pronađena'
            ], 404);
        }

        return response()->json($statistika, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Statistika $statistika)
    {
        //
    }

    #[OA\Put(
    path: "/api/statistike/{id}",
    summary: "Izmena statistike",
    tags: ["Statistika"],
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
    new OA\Property(property: "broj_odradjenih_zadataka", type: "integer", example: 9),
    new OA\Property(property: "ukupan_broj_zadataka", type: "integer", example: 12),
    new OA\Property(property: "procenat_uspesnosti", type: "number", example: 75),
],
    type: "object"
)
),
    responses: [
    new OA\Response(response: 200, description: "Statistika uspešno izmenjena"),
    new OA\Response(response: 404, description: "Statistika nije pronađena"),
    new OA\Response(response: 422, description: "Validaciona greška")
]
)]

    public function update(Request $request, $id)
    {
        $statistika = Statistika::find($id);

        if (!$statistika) {
            return response()->json([
                'message' => 'Statistika nije pronađena'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'broj_odradjenih_zadataka' => 'sometimes|integer|min:0',
            'ukupan_broj_zadataka' => 'sometimes|integer|min:1',
            'procenat_uspesnosti' => 'sometimes|numeric|min:0|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validacija nije prošla',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();
        $statistika->update($data);

        return response()->json($statistika, 200);
    }

    #[OA\Delete(
    path: "/api/statistike/{id}",
    summary: "Brisanje statistike",
    tags: ["Statistika"],
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
    new OA\Response(response: 200, description: "Statistika uspešno obrisana"),
    new OA\Response(response: 404, description: "Statistika nije pronađena")
]
)]

    public function destroy($id)
    {
       $statistika = Statistika::find($id);

        if (!$statistika) {
            return response()->json([
                'message' => 'Statistika nije pronađena'
            ], 404);
        }

        $statistika->delete();

        return response()->json([
            'message' => 'Statistika uspešno obrisana'
        ], 200);
    } 
}
