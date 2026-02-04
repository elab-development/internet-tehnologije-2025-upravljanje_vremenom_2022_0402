<?php

namespace App\Http\Controllers;

use App\Models\Beleske;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BeleskeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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

    /**
     * Store a newly created resource in storage.
     */
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

    /**
     * Display the specified resource.
     */
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

    /**
     * Update the specified resource in storage.
     */
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

    /**
     * Remove the specified resource from storage.
     */
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
