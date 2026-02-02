<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage; 

class ResumeAnalysisController extends Controller
{
    public function store(Request $request)
    {
        // 1️⃣ Validate input
        $request->validate([
            'resume_file' => 'required|mimes:pdf,doc,docx|max:2048',
            'job_description' => 'required|string',
        ]);

        // 2️⃣ Store resume file
        $file = $request->file('resume_file');
        $filePath = $file->store('resumes', 'public');

        // 3️⃣ Call MySQL Stored Procedure
        $success = DB::statement('CALL insert_resume_analysis_to_db(1, ?, ?)', [
            $filePath,
            $request->job_description
        ]);

        if($success) {
            return back()->with('success', 'Resume uploaded successfully!');
        } else {
            return back()->with('error', 'Failed to insert resume.');
        }
    }
}
