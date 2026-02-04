<?php

namespace App\Http\Controllers;

use App\Models\Statistika;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StatistikaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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

    /**
     * Store a newly created resource in storage.
     */
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

    /**
     * Display the specified resource.
     */
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

    /**
     * Update the specified resource in storage.
     */
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

    /**
     * Remove the specified resource from storage.
     */
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
