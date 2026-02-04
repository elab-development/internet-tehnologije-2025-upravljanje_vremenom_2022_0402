<?php

namespace App\Http\Controllers;

use App\Models\Zadatak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ZadatakController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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

    /**
     * Store a newly created resource in storage.
     */
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

    /**
     * Display the specified resource.
     */
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

    /**
     * Update the specified resource in storage.
     */
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

    /**
     * Remove the specified resource from storage.
     */
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
