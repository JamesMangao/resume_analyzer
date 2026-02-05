<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpWord\IOFactory;
use Smalot\PdfParser\Parser as PdfParser;

class ResumeAnalysisController extends Controller
{
    // 🔹 OPTIONAL: old non-AJAX version (can delete if unused)
    public function store(Request $request)
    {
        // if you are using AJAX, this method is NOT used
        return redirect()->back();
    }

    // 🔹 AJAX VERSION (THIS IS THE IMPORTANT ONE)
  public function storeAjax(Request $request)
{
    // Validate AJAX request
    $validator = \Validator::make($request->all(), [
        'resume_file' => 'required|mimetypes:application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,text/plain|max:5120',
        'job_description' => 'required|string',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'errors' => $validator->errors()
        ], 422);
    }

    $file = $request->file('resume_file');
    $extension = strtolower($file->getClientOriginalExtension());
    $resumeContent = '';

    // Move file to temporary path with proper extension
    $tempPath = sys_get_temp_dir() . '/' . uniqid() . '.' . $extension;
    $file->move(dirname($tempPath), basename($tempPath));

    try {
        switch ($extension) {
            case 'txt':
                $resumeContent = '<pre>' . htmlspecialchars(file_get_contents($tempPath)) . '</pre>';
                break;

            case 'doc':
            case 'docx':
                $phpWord = IOFactory::load($tempPath);
                $writer = IOFactory::createWriter($phpWord, 'HTML');
                ob_start();
                $writer->save('php://output');
                $resumeContent = ob_get_clean();
                break;

            case 'pdf':
                $parser = new PdfParser();
                $pdf = $parser->parseFile($tempPath);
                $resumeContent = '<pre>' . htmlspecialchars($pdf->getText()) . '</pre>';
                break;

            default:
                throw new \Exception('Unsupported file type.');
        }
    } catch (\Exception $e) {
        // Cleanup temp file
        @unlink($tempPath);

        return response()->json([
            'success' => false,
            'message' => 'Failed to read resume: ' . $e->getMessage()
        ], 500);
    }

    // Delete temp file after reading
    @unlink($tempPath);

    // Insert into database
    $insertResult = DB::select('CALL usp_insert_resume(?, ?, ?)', [
        1,
        $resumeContent,
        $request->job_description
    ]);

    $newId = $insertResult[0]->inserted_id;
    // Fetch result
    $result = DB::select('CALL usp_get_resume(?, ?)', [1, $newId]); // adjust params if needed

    if (!$result) {
        return response()->json([
            'success' => false, 
            'message' => 'No resume found'
        ], 500);
    }

    return response()->json([
        'success' => true,
        'resume' => $result[0]
    ]);
}

}

