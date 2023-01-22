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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request) {

        $result = attachments::create($request->all());
        return $result;
        
    }


    public function fileUpload(Request $request, $cpr, $userName) {
 
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


            /*
                ------------------------------------------------
                Rename The Following Variables
                ------------------------------------------------
                $file               -----> $submitedFile -> done
                $name               -----> $fileOrigionalName
                $fileName           -----> $fileNewName
                $destinationPath    -----> $fileDirectory

            */


            // Preparing The Variables
            $submittedFile      = $request->file('file');

            // Convert The String OF the File Name To Lower Case
            $fileOrigionalName  = strtolower($submittedFile->getClientOriginalName());

            // Here We Define The Extension Of The File
            $fileExtensionName  = strtolower($submittedFile->getClientOriginalExtension());
            
            // Here We Store The File On To The Destination & Keep The File Origional Name In The Variable
            $fileNewName        = $file->storeAs('public/dist/employees/'. $cpr . '_' . strtoupper($userName), date("Ymd_his") . "_" . $fileOrigionalName);

            // Here We Define The Directory Path Of The File
            $fileDirectory      = public_path() . '\dist\\employees\\' . $cpr . '_' . strtoupper($userName);
            
            // If The Path Was Not Existing Then Create It
            File::ensureDirectoryExists($fileDirectory);

            // Move the Stored File On the System To The Directory
            $submittedFile->move($fileDirectory, $fileNewName);

            // Make Sure The File Is Not Empty
            if(!empty($files)) {
                foreach($files as $file) {
                    // File::disk(['drivers' => 'local', 'root' => $destinationPath])->put($file->getClientOriginalName());
                    File::disk(['drivers' => 'local', 'root' => $fileDirectory])->put($fileOrigionalName);
                }
            }
        
            // This Is What Stores The Data In The Database
            $save = new Attachments();
            // The Files Belongs To An Owner
            $save->cpr = $cpr;
            // $save->name = $fileOrigionalName;    // Stores The Field Name
            $save->title = $fileOrigionalName; 
            // Stores The Field Type
            $save->type = $fileExtensionName;
            // $save->path = $fileDirectory;        // Stores The Field Path
            $save->path = $fileNewName;             // Stores The Fiels Path
            // $save->file = $fileNewName;          // Stores The Field File
            $save->save();

            // Successful Response Message
            return response()->json([
                "success"   => true,
                "message"   => "File successfully uploaded",
                "file"      => $submittedFile
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

    public function deletefile($id) {
        // Deleteing The Note By Its ID

        $file = Attachments::find($id);
        // $path = 'employees/';
        $file_path = public_path()  . '\dist\\employees\\' . $cpr . '_' . strtoupper($userName);
        if ($file->attachments_file != null && File::disk('public')->exists($file_path)){
            File::disk('public/dist/employees/')->delete($file_path);
            return response();
        }
        $query = $file->delete();
        if ($query) {
            return response()->json(['code'=>1, 'msg'=>'File has been deleted successfully']);
        } else {
            return response()->json(['code'=>0, 'msg'=>'Something went wrong']);
        }
        // return attachments::destroy($id);
    }
}
