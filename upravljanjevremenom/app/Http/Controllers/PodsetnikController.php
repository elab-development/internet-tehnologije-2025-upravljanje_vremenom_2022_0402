<?php

namespace App\Http\Controllers;

use App\Models\Podsetnik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use OpenApi\Attributes as OA;

class PodsetnikController extends Controller
{
    #[OA\Get(
    path: "/api/podsetnici",
    summary: "Lista svih podsetnika",
    tags: ["Podsetnici"],
    responses: [
    new OA\Response(response: 200, description: "Uspešno vraćena lista podsetnika")
]
)]

    public function index()
    {
        return Podsetnik::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    #[OA\Post(
    path: "/api/podsetnici",
    summary: "Kreiranje novog podsetnika",
    tags: ["Podsetnici"],
    requestBody: new OA\RequestBody(
    required: true,
    content: new OA\JsonContent(
    required: ["vreme", "aktivan", "korisnik_id"],
    properties: [
    new OA\Property(property: "vreme", type: "string", format: "date-time", example: "2026-02-23 15:00:00"),
    new OA\Property(property: "aktivan", type: "boolean", example: true),
    new OA\Property(property: "korisnik_id", type: "integer", example: 1),
],
    type: "object"
)
),
    responses: [
    new OA\Response(response: 201, description: "Podsetnik uspešno kreiran"),
    new OA\Response(response: 422, description: "Validaciona greška")
]
)]

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'vreme' => 'required|date',
            'aktivan' => 'required|boolean',
            'korisnik_id' => 'required|integer|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validacija nije prošla',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();
        $podsetnik = Podsetnik::create($data);

        return response()->json($podsetnik, 201);
    }

    #[OA\Get(
    path: "/api/podsetnici/{id}",
    summary: "Prikaz jednog podsetnika",
    tags: ["Podsetnici"],
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
    new OA\Response(response: 200, description: "Podsetnik pronađen"),
    new OA\Response(response: 404, description: "Podsetnik nije pronađen")
]
)]

    public function show($id)
    {
        $podsetnik = Podsetnik::find($id);

        if (!$podsetnik) {
            return response()->json([
                'message' => 'Podsetnik nije pronađen'
            ], 404);
        }

        return response()->json($podsetnik, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Podsetnik $podsetnik)
    {
        //
    }

    #[OA\Put(
    path: "/api/podsetnici/{id}",
    summary: "Izmena podsetnika",
    tags: ["Podsetnici"],
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
    new OA\Property(property: "vreme", type: "string", format: "date-time", example: "2026-02-23 18:00:00"),
    new OA\Property(property: "aktivan", type: "boolean", example: false),
],
    type: "object"
)
),
    responses: [
    new OA\Response(response: 200, description: "Podsetnik uspešno izmenjen"),
    new OA\Response(response: 404, description: "Podsetnik nije pronađen"),
    new OA\Response(response: 422, description: "Validaciona greška")
]
)]

    public function update(Request $request, $id)
    {
        $podsetnik = Podsetnik::find($id);

        if (!$podsetnik) {
            return response()->json([
                'message' => 'Podsetnik nije pronađen'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'vreme' => 'sometimes|date',
            'aktivan' => 'sometimes|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validacija nije prošla',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();
        $podsetnik->update($data);

        return response()->json($podsetnik, 200);
    }

    #[OA\Delete(
    path: "/api/podsetnici/{id}",
    summary: "Brisanje podsetnika",
    tags: ["Podsetnici"],
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
    new OA\Response(response: 200, description: "Podsetnik uspešno obrisan"),
    new OA\Response(response: 404, description: "Podsetnik nije pronađen")
]
)]

    public function destroy($id)
    {
        $podsetnik = Podsetnik::find($id);

        if (!$podsetnik) {
            return response()->json([
                'message' => 'Podsetnik nije pronađen'
            ], 404);
        }

        $podsetnik->delete();

        return response()->json([
            'message' => 'Podsetnik uspešno obrisan'
        ], 200);

    }
}
