<?php

//-------------------------------------------------------------------------
//  Libraries Required
//-------------------------------------------------------------------------
    
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\File;
    use Illuminate\Support\Facades\Validator;

//-------------------------------------------------------------------------
//  List Of Functions - For Every Where
//-------------------------------------------------------------------------

    // To Display Missing If Null Value Is There
    if(!function_exists('display')) {
        function display($data) {
            if(!is_null($data)) {
                return $data;
            } else {
                return "MISSING";
            }
        }
    }

    // Date Formating To 01-May-22
    if(!function_exists('makeDate')) {
        function makeDate($date) {
            if(!is_null($date)) {
                $date = date_create($date);
                return strtoupper(date_format($date,"d-M-y"));
            } else {
                return "MISSING";
            }
        }
    }

    // Date Formating To 01-May-22
    if(!function_exists('makeTime')) {
        function makeTime($date) {
            if(!is_null($date)) {
                $date = date_create($date);
                return strtoupper(date_format($date,"g:i a"));
            } else {
                return "MISSING";
            }
        }
    }

    // Check Employee Experiance
    if(!function_exists('checkExperiance')) {
        function checkExperiance($data) {
            if(!is_null($data->start)) {
                $day    = NULL;
                $month  = NULL;
                $year   = NULL;
                if($data->experiance->y != 0) { $year = $data->experiance->y . " <sub>YEARS</sub> "; }
                if($data->experiance->m != 0) { $month = $data->experiance->m . " <sub>MONTHS</sub> "; }
                if($data->experiance->d != 0) { $day = $data->experiance->d . " <sub>DAYS</sub> "; }
                return $year . $month . $day;
            } else {
                return "MISSING INFO";
            }
        }
    }

    // Makes Validity 
    if(!function_exists('checkValidity')) {
        function checkValidity($data) {
            if(!is_null($data->expire)) {

                $day    = NULL;
                $month  = NULL;
                $year   = NULL;

                if($data->validity->y != 0) { $year = $data->validity->y . " <sub>YEARS</sub> "; }
                if($data->validity->m != 0) { $month = $data->validity->m . " <sub>MONTHS</sub> "; }
                if($data->validity->d != 0) { $day = $data->validity->d . " <sub>DAYS</sub> "; }

                return $year . $month . $day;
            } else {
                return "MISSING INFO";
            }
        }
    }

    // Years Of Work
    if(!function_exists('checkExperiance')) {
        function checkExperiance($work) {
            if(!is_null($work->experiance)) {

                $day    = NULL;
                $month  = NULL;
                $year   = NULL;

                if($data->experiance->y != 0) { $year = $data->validity->y . " <sub>YEARS</sub> "; }
                if($data->experiance->m != 0) { $month = $data->validity->m . " <sub>MONTHS</sub> "; }
                if($data->experiance->d != 0) { $day = $data->validity->d . " <sub>DAYS</sub> "; }

                return $year . $month . $day;
            } else {
                return "MISSING INFO";
            }
        }
    }

    // Check Picture
    if(!function_exists('checkPicture')) {
        function checkPicture($user) {
            if(!is_null($user->picture)) {
                return $user->picture;
            } else {
                if($user->gender == "M" || $user->gender == "MALE") {
                    return asset('dist/img/avatar/male.png');
                } elseif($user->gender == "F" || $user->gender == "FEMALE") {
                    return asset('dist/img/avatar/female.png');
                } else {
                    return asset('dist/img/avatar/male.png');
                }
            }
        }
    }

    // Check Whick Color To Put
    if(!function_exists('colorSelect')) {
        function colorSelect($data) {
            if($data == 'G') {
                return "success";
            } elseif($data == 'Y') {
                return "warning";
            } elseif($data == 'R') { 
                return "danger";
            }  elseif($data == 'I') { 
                return "info";
            } else {
                return "danger";
            }
        }
    }

    // Upload A File
    if(!function_exists('upload')) {

        /* This function will upload files based on the purpose of the file 
        
            Example :

                Company CR          :   type = 'cr'     // 
                Company Logo        :   type = 'lg'
                Employee Picture    :   type = 'ep'
                Employee Documents  :   type = 'ed'
                Employee Uppraisals :   type = 'eu'
                Employee Notes      :   type = 'en'
        
        */

        function upload(Request $request, $type, $cpr) {

            // Files Buffer
            $files = array();

            // Identify The File Type
            switch ($type) {

                case 'cr' :
                    // Laravel Raw MySQL Methode
                    $query      = ("SELECT * FROM users WHERE cpr = ?");
                    // Executing The Query
                    $employee   = json_decode(json_encode(DB::select($query, [$cpr])));
                    // Read The Unique Record
                    $employee   = $employee[0];
                    // STOP
                    break;

                case 'lg' :

                    break;

                case 'ep' :

                    break;

                case 'ed' :

                    break;

                case 'eu' :

                    break;

                case 'en' :

                    break;

            }

            // To Make Sure The Person Have A CPR
            if(is_null($employee->cpr) || empty($employee->cpr)) {
                return response()->json(['error'=>'employee cpr number is missing, please updare the user profile with same cpr number'], 401);
            }

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

            //----------------------------------------------------------------------
            // Uploading The File Part
            //----------------------------------------------------------------------

                // Preparing The Variables
                $file               = $request->file('file');

                // Convert The String OF the File Name To Lower Case
                $file_name          = strtolower($file->getClientOriginalName());

                // Here We Define The Extension Of The File
                $file_extension     = strtolower($file->getClientOriginalExtension());

                // New File Name
                $file_new_name      = date("Ymd_his") . "_" . $file_name;

                // The Directory Name
                $employee_directory = strtoupper($employee->cpr . '_' . $employee->name);
                
                // Here We Store The File On To The Destination & Keep The File Origional Name In The Variable
                $file_url           = $file->storeAs('public/dist/employees/'. $employee_directory . '/Attachments', $file_new_name);

                // Here We Define The Directory Path Of The File
                $file_destination   = public_path('dist\\employees\\'. $employee_directory . '\\Attachments');

                // If The Path Was Not Existing Then Create It
                File::ensureDirectoryExists($file_destination);

                // Move the Stored File On the System To The Directory
                $file->move($file_destination, $file_url);

                // Make Sure The File Is Not Empty
                if(!empty($files)) {
                    foreach($files as $file) {
                        // File::disk(['drivers' => 'local', 'root' => $destinationPath])->put($file->getClientOriginalName());
                        File::disk(['drivers' => 'local', 'root' => $file_destination])->put($file_name);
                    }
                }

            //----------------------------------------------------------------------
            // Database Part
            //----------------------------------------------------------------------

                // This Is What Stores The Data In The Database
                $save               = new Attachments();    // Openning A Record
                $save->eid          = $employee->id;        // Employee ID
                $save->cpr          = $employee->cpr;       // Employee CPR
                $save->title        = $request->title;      // File Title
                $save->name         = $fileOrigionalName;   // File Title
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
    }

?>