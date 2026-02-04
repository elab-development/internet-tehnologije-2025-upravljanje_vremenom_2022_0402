<?php

namespace App\Http\Controllers;

use App\Models\Podsetnik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PodsetnikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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

    /**
     * Store a newly created resource in storage.
     */
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

    /**
     * Display the specified resource.
     */
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

    /**
     * Update the specified resource in storage.
     */
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

    /**
     * Remove the specified resource from storage.
     */
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
