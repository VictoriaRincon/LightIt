<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Exception;
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

            $name = $request->name;
            $email = $request->email;
            $phoneNumber = $request->phoneNumber;

            $request->validate([
                'name' => 'required|string',
                'email' => 'required|email',
                'phoneNumber' => 'required|string|min:9',
                'documentPhoto' => 'nullable|image|mimes:jpeg,png,jpg,gif'
            ]);
    
            $patient = new Patient;
            $patient->name=$name;
            $patient->email=$email;
            $patient->phoneNumber=$phoneNumber;

            if ($request->hasFile('documentPhoto')) {
                $path = $request->documentPhoto->store('images');
                $patient->documentPhoto=$path;
            }

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
        } catch (Exception  $e) {
            $error = $e->getMessage();
        
            return response()->json([
                'status' => false,
                'message' => 'DataBase error',
                'error' => $error,
            ], 500);
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
