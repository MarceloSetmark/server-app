<?php

namespace App\Http\Controllers;
use App\Http\Requests\StoreRegistrationRequest;
use App\Http\Requests\UpdateRegistrationRequest;
use App\Models\Registration;

use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return Registration::all();
        /* $query = Registration::query();

        // Verificamos se o parâmetro 'search_data' foi informado e aplicamos o filtro
        if ($request->has('search_data')) {
            $searchData = $request->input('search_data');
            $query->where(function($query) use ($searchData) {
                $query->where('name', 'like', '%' . $searchData . '%')
                      ->orWhere('email', 'like', '%' . $searchData . '%');
            });
        } */
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRegistrationRequest  $request)
    {
        $registration = Registration::create($request->validated());
        return response()->json($registration, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRegistrationRequest $request, string $id)
    {
        $registration->update($request->validated());
        return response()->json($registration);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $id->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
