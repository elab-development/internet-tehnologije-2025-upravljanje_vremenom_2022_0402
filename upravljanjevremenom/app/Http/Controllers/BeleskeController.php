<?php

namespace App\Http\Controllers;

use App\Models\Beleske;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use OpenApi\Attributes as OA;

class BeleskeController extends Controller
{
    #[OA\Get(
        path: "/api/beleske",
        summary: "Lista svih beleški",
        tags: ["Beleške"],
        responses: [
            new OA\Response(response: 200, description: "Uspešno vraćena lista beleški")
        ]
    )]

    public function index()
    {
        return Beleske::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    #[OA\Post(
        path: "/api/beleske",
        summary: "Kreiranje nove beleške",
        tags: ["Beleške"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["naslov", "sadrzaj", "korisnik_id"],
                properties: [
                    new OA\Property(property: "naslov", type: "string", example: "Plan za danas"),
                    new OA\Property(property: "sadrzaj", type: "string", example: "Završiti projekat i učiti za ispit."),
                    new OA\Property(property: "korisnik_id", type: "integer", example: 1),
                ],
                type: "object"
            )
        ),
        responses: [
            new OA\Response(response: 201, description: "Beleška uspešno kreirana"),
            new OA\Response(response: 422, description: "Validaciona greška")
        ]
    )]

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'naslov' => 'required|string|max:255',
            'sadrzaj' => 'required|string',
            'korisnik_id' => 'required|integer|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validacija nije prošla',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();
        $beleske = Beleske::create($data);

        return response()->json($beleske, 201);
    }

    #[OA\Get(
        path: "/api/beleske/{id}",
        summary: "Prikaz jedne beleške",
        tags: ["Beleške"],
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
            new OA\Response(response: 200, description: "Beleška pronađena"),
            new OA\Response(response: 404, description: "Beleška nije pronađena")
        ]
    )]

    public function show($id)
    {
        $beleske = Beleske::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Beleske $beleske)
    {
        //
    }

    #[OA\Put(
        path: "/api/beleske/{id}",
        summary: "Izmena beleške",
        tags: ["Beleške"],
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
                    new OA\Property(property: "naslov", type: "string", example: "Novi naslov"),
                    new OA\Property(property: "sadrzaj", type: "string", example: "Izmenjeni sadržaj"),
                    new OA\Property(property: "korisnik_id", type: "integer", example: 1),
                ],
                type: "object"
            )
        ),
        responses: [
            new OA\Response(response: 200, description: "Beleška uspešno izmenjena"),
            new OA\Response(response: 404, description: "Beleška nije pronađena"),
            new OA\Response(response: 422, description: "Validaciona greška")
        ]
    )]

    public function update(Request $request, $id)
    {
        $beleske = Beleske::find($id);

        if (!$beleske) {
            return response()->json([
                'message' => 'Beleška nije pronađena'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'naslov' => 'sometimes|string|max:255',
            'sadrzaj' => 'sometimes|string',
            'korisnik_id' => 'required|integer|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validacija nije prošla',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();
        $beleske->update($data);

        return response()->json($beleske, 200);
    }

    #[OA\Delete(
        path: "/api/beleske/{id}",
        summary: "Brisanje beleške",
        tags: ["Beleške"],
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
            new OA\Response(response: 200, description: "Beleška uspešno obrisana"),
            new OA\Response(response: 404, description: "Beleška nije pronađena")
        ]
    )]

    public function destroy($id)
    {
        $beleske = Beleske::find($id);

        if (!$beleske) {
            return response()->json([
                'message' => 'Beleška nije pronađena'
            ], 404);
        }

        $beleske->delete();

        return response()->json([
            'message' => 'Beleška uspešno obrisana'
        ], 200);
    }
}
