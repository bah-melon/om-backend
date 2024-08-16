<?php

namespace App\Http\Controllers\Applicants;

use App\Http\Controllers\Controller;
use App\Http\Requests\createApplicationRequest;
use App\Models\Applicants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApplicantsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function fetchApplications(){
        return(Applicants::query()
                        ->with('openPosition')
                        ->orderBy('created_at', 'desc')
                        ->paginate(8));
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
    public function store(createApplicationRequest $request)
    {
        $data = $request->validated();

        $data['file_path'] = $request->file('file_path')->store('application_CVs', 'local');
        
        $application = Applicants::create($data);

        return response()->json([
            'message' => 'Applicaton created successfully',
            'application' => $application
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Applicants $applicant)
    {
        return response()->json([
            'application' => $applicant
        ], 201);
    }

    public function downloadCV(Applicants $applicant)
    {
        $file_path = $applicant->file_path;
        
        if(Storage::disk('local')->exists($file_path)){
            return Storage::disk('local')->download($file_path, $applicant->file_name ?? 'CV.pdf');
        } else {
            return response()->json(['message' => 'File not found'], 404);
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Applicants $applicant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Applicants $applicant)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Applicants $applicant)
    {
        if (!$applicant->exists) {
            return response()->json([
                'message' => 'Applicaiton not found'
            ], 404);
        }
        $applicant->delete();

        return response()->json([
            'message' => 'Application deleted successfully'
        ], 201);
    }
}
