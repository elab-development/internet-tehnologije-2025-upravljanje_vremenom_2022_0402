<?php

namespace App\Http\Controllers;

use App\Models\Obavestenje;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ObavestenjeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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

    /**
     * Store a newly created resource in storage.
     */
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

    /**
     * Display the specified resource.
     */
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

    /**
     * Update the specified resource in storage.
     */
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

    /**
     * Remove the specified resource from storage.
     */
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
