<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePatientRequest;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ApiPatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $patient = Patient::all();
        return response()->json([
            'status' => true,
            'patients' => $patient
        ]);
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
        try {

            $jsonData = $request->json()->all();
            $name = $jsonData['name'];
            $email = $jsonData['email'];
            $phoneNumber = $jsonData['phoneNumber'];

            $request->validate([
                'name' => 'required|string',
                'email' => 'required|email',
                'phoneNumber' => 'required|string|min:9'
            ]);
    

            $patient = new Patient;
            $patient->name=$name;
            $patient->email=$email;
            $patient->phoneNumber=$phoneNumber;
            $patient->save();

            return response()->json([
                'status' => true,
                'message' => 'Patient Created successfully!',
                'patient' => $patient,
            ], 201);

        } catch (ValidationException $e) {
            $errors = $e->validator->errors();
        
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $errors,
            ], 422);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show($name)
    {
        $patient = Patient::find($name);
        if(!empty($patient)){ return response() -> json($patient);}
        else {return response()->json(["message" => "Patient not found", 404]);}
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patient $patient)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Patient $patient)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        //
    }
}
