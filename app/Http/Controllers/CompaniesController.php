<?php

namespace App\Http\Controllers;

use App\Models\companies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class CompaniesController extends Controller {

    public function index() {

        // Query
        $query = ("SELECT DISTINCT * FROM companies GROUP BY name ORDER BY name ASC;");

        // Result
        $result = DB::select($query);

        // Return The Result
        return $result;

    }

    public function store(Request $request) {
        
        // Query
        $result = companies::create($request->all());

        // Return The Result
        return $result;

    }

    public function show($id) {
        
        // Query
        $query = ("SELECT * FROM companies WHERE id = ?");

        // Result
        $result = DB::select($query, [$id]);

        // Return The Result
        return $result;

    }

    public function update(Request $request, $id) {
        
        // Find The Note By Its ID
        $results = companies::find($id);
        
        // Update The Note With Request Data
        $results->update($request->all());

        // Return The Values For Display
        return $results;

    }

    public function destroy($id) {

        // Deleteing The Note By Its ID
        return companies::destroy($id);

    }

//--------------------------------------------------------------------
//  Attachments
//--------------------------------------------------------------------

    // Uploads A Picture
    public function logoUpload(Request $request, $id){
 
        // Laravel Raw MySQL Methode
        $query = ("SELECT * FROM companies WHERE id = ?;");
        
        // Executing The Query
        $company = json_decode(json_encode(DB::select($query, [$id])));

        // Read The Unique Record
        $company = $company[0];

        // Validate The File Type
        $validator = Validator::make($request->all(),[ 
            'logo'  => 'required|mimes:png,jpg,jpeg,gif',
        ]);
 
        if($validator->fails()) {          
            return response()->json(['error'=>$validator->errors()], 401);                        
        }
 
        if ($logo = $request->file('logo')) {

            // The Directory Name
            $CompanyDirectory   = strtoupper($company->name);

            // Preparing Variables
            $logo               = $request->file('logo');
            $logoExtension      = strtolower($logo->getClientOriginalExtension());
            $name               = 'logo.' . $logoExtension;
            $fileName           = $logo->storeAs('public/dist/companies/'. $CompanyDirectory, $name);
            $destinationPath    = public_path('dist\\companies\\' . $CompanyDirectory);

            // If The Path Was Not Existing Then Create It
            File::ensureDirectoryExists($destinationPath);

            $logo->move($destinationPath, $fileName);

            // Laravel Raw MySQL Methode
            $query = "UPDATE companies SET companies.logo = ? WHERE id = ?";

            // Executing The Query
            $results = DB::update($query, [$fileName, $company->id]);

            // Return A Response
            return response()->json([
                "success" => true,
                "message" => "File Successfully Uploaded",
                "picture" => $results
            ]);
  
        }

  
    }

    // Uploads A File
    public function crUpload(Request $request, $id) {
 
        // Laravel Raw MySQL Methode
        $query = ("SELECT * FROM companies WHERE id = ?;");
        
        // Executing The Query
        $company = json_decode(json_encode(DB::select($query, [$id])));

        // Read The Unique Record
        $company = $company[0];

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
            $file               = $request->file('file');
            
            // The Directory Name
            $CompanyDirectory   = strtoupper($company->name);

            // New File Name
            $fileNewName        = 'cr.'. strtolower($file->getClientOriginalExtension());
            
            // Here We Store The File On To The Destination & Keep The File Origional Name In The Variable
            $fileUrl            = $file->storeAs('public/dist/companies/'. $CompanyDirectory, $fileNewName);

            // Here We Define The Directory Path Of The File
            $fileDirectory      = public_path('dist\\companies\\'. $CompanyDirectory);

            // If The Path Was Not Existing Then Create It
            File::ensureDirectoryExists($fileDirectory);

            // Move the Stored File On the System To The Directory
            $file->move($fileDirectory, $fileUrl);

            // Make Sure The File Is Not Empty
            if(!empty($files)) {
                foreach($files as $file) {
                    File::disk(['drivers' => 'local', 'root' => $fileDirectory])->put(strtolower($file->getClientOriginalName()));
                }
            }
        
            // Laravel Raw MySQL Methode
            $query = "UPDATE companies SET companies.cr_attach = ? WHERE id = ?";

            // Executing The Query
            $results = DB::update($query, [$fileUrl, $company->id]);

            // Successful Response Message
            return response()->json([
                "success"   => true,
                "message"   => "File Successfully Uploaded",
                "file"      => $results
            ]);
  
        }
  
    }

}
