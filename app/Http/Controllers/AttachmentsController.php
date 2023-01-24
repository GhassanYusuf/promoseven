<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\attachments;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class AttachmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index() {

        // Laravel Raw MySQL Methode
        $query = ("SELECT * FROM employees_attachments ORDER BY created_at DESC;");

        // Executing The Query
        $results = DB::select($query);

        // Return The Results
        return $results;

    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function listFileVersions($title, $cpr) {

        // Laravel Raw MySQL Methode
        $query = ("
                    SELECT 
                        * 
                    FROM 
                        employees_attachments as attachment
                    WHERE
                        attachment.title = ?
                        AND
                        attachment.cpr = ?
                    ORDER BY
                        attachment.created_at
                        DESC
                ");

        // Executing The Query
        $results = DB::select($query, [$title, $cpr]);

        // Return The Results
        return $results;

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request) {

        $result = attachments::create($request->all());
        return $result;
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function fileUpload(Request $request, $cpr) {
 
        // Laravel Raw MySQL Methode
        $query = ("SELECT * FROM users WHERE cpr = ?");
        
        // Executing The Query
        $employee = json_decode(json_encode(DB::select($query, [$cpr])));

        // Read The Unique Record
        $employee = $employee[0];

        // Validate File Extension Type And File Size
        $validator = Validator::make($request->all(),[ 
            'file' => 'required|mimes:doc,docx,pdf,txt,csv,xlsx,png,jpg,jpeg,gif|max:2048',
        ]);

        // In Case the Validation Was Not Sucessfull Send Error Response
        if($validator->fails()) {          
            return response()->json(['error'=>$validator->errors()], 401);                        
        }
   
        // If File Was Submitted
        if($file = $request->file('file')) {

            // Preparing The Variables
            $submittedFile      = $request->file('file');

            // Convert The String OF the File Name To Lower Case
            $fileOrigionalName  = strtolower($submittedFile->getClientOriginalName());

            // New File Name
            $fileNewName        = date("Ymd_his") . "_" . $fileOrigionalName;

            // Here We Define The Extension Of The File
            $fileExtensionName  = strtolower($submittedFile->getClientOriginalExtension());
            
            // Here We Store The File On To The Destination & Keep The File Origional Name In The Variable
            $fileUrl            = $file->storeAs('public/dist/employees/'. $cpr . '_' . strtoupper($employee->name), $fileNewName);

            // Here We Define The Directory Path Of The File
            $fileDirectory      = public_path('dist\\employees\\') . $cpr . '_' . strtoupper($employee->name);

            // If The Path Was Not Existing Then Create It
            File::ensureDirectoryExists($fileDirectory);

            // Move the Stored File On the System To The Directory
            $submittedFile->move($fileDirectory, $fileUrl);

            // Make Sure The File Is Not Empty
            if(!empty($files)) {
                foreach($files as $file) {
                    // File::disk(['drivers' => 'local', 'root' => $destinationPath])->put($file->getClientOriginalName());
                    File::disk(['drivers' => 'local', 'root' => $fileDirectory])->put($fileOrigionalName);
                }
            }
        
            // This Is What Stores The Data In The Database
            $save               = new Attachments();    // Openning A Record
            $save->eid          = $employee->id;        // Employee ID
            $save->cpr          = $employee->cpr;       // Employee CPR
            $save->title        = $fileOrigionalName;   // File Title
            $save->type         = $fileExtensionName;   // File Type
            $save->url          = $fileUrl;             // File URL

            // File Path
            $save->path         = $fileDirectory . '\\' . date("Ymd_his") . "_" . $fileOrigionalName;

            // Save To Database
            $save->save();

            // Successful Response Message
            return response()->json([
                "success"   => true,
                "message"   => "File Successfully Uploaded",
                "file"      => $fileNewName
            ]);
  
        }
  
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id) {
        
        // Laravel Raw MySQL Methode
        $query = ("SELECT * FROM employees_attachments WHERE eid = ? ORDER BY created_at DESC;");

        // Executing The Query
        $results = DB::select($query, [$id]);

        // Return The Results
        return $results;

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id) {

        // Find The Note By Its ID
        $results = attachments::find($id);
        
        // Update The Note With Request Data
        $results->update($request->all());

        // Return The Values For Display
        return $results;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */



}
