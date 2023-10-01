<?php

namespace App\Http\Controllers;

use App\Jobs\SendConfirmationEmail;
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
        $patients = Patient::all();

        return view('index', compact('patients'));
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
        $name = $request->name;
        $email = $request->email;
        $phoneNumber = $request->phoneNumber;

        $request->validate([
            'name' => 'required|regex:/^[A-Za-z\s]+$/',
            'email' => 'required|email|unique:patients|ends_with:@gmail.com',
            'phoneNumber' => 'required|regex:/^[0-9]+$/',
            'documentPhoto' => ['nullable','image',function ($attribute, $value, $fail) {
                $extension = strtolower($value->getClientOriginalExtension());
                if ($extension !== 'jpg') {
                    $fail('The document photo field must be a file of type: jpg.');
                }
            }]
        ]);

        $patient = new Patient;
        $patient->name=$name;
        $patient->email=$email;
        $patient->phoneNumber=$phoneNumber;
        
        if ($request->hasFile('documentPhoto')) {
            $path = $request->documentPhoto->store('public/images');
            $patient->documentPhoto=basename($path);
        }
        
        $patient->save();
        
        dispatch(new SendConfirmationEmail($email));

        return back()->with('message', 'The patient has been added successfully');
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

    public function list(){
        $patients = Patient::all();

        return response()->json([
            'status' => true,
            'patients' => $patients
        ]);
    }
    
    public function form(){
        return view('newPatient');
    }

    public function save(Request $request)
    {
        try {
            $name = $request->name;
            $email = $request->email;
            $phoneNumber = $request->phoneNumber;

            $request->validate([
                'name' => 'required|aplha',
                'email' => 'required|email|ends_with:@gmail.com',
                'phoneNumber' => 'required|numeric',
                'documentPhoto' => 'nullable|image|mimes:jpg'
            ]);
    
            $patient = new Patient;
            $patient->name=$name;
            $patient->email=$email;
            $patient->phoneNumber=$phoneNumber;
            
            if ($request->hasFile('documentPhoto')) {
                $path = $request->documentPhoto->store('public/images');
                $patient->documentPhoto=basename($path);
            }
            
            $patient->save();
            
            dispatch(new SendConfirmationEmail($email));

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
                'message' => 'Internal error',
                'error' => $error,
            ], 500);
        }

    }

}
