<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\attachments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    private $emp = ("
                        SELECT
                            users.id as 'id',
                            UPPER(code) as 'code',
                            ROUND(DATEDIFF(CURRENT_DATE, STR_TO_DATE(users.birthdate, '%Y-%m-%d'))/365, 0) AS 'age',
                            UPPER(users.name) as 'name',
                            if(users.gender = 'M', 'MALE', 'FEMALE') as 'gender',

                            /* Nationality */
                            JSON_OBJECT(
                                'id', UPPER(country.id),
                                'iso', UPPER(country.iso),
                                'iso3', UPPER(country.iso3),
                                'name', UPPER(country.name)
                            ) as 'nationality',

                            users.bank_account,
                            users.picture,
                            users.contact,
                            users.birthdate,
                            
                            /* Employment */
                            JSON_OBJECT(
                                'id', company.id,
                                'company', UPPER(company.name),
                                'did', department.id,
                                'department', UPPER(department.name),
                                'position', UPPER(position),
                                'accessLevel', UPPER(users.accesslevel),
                                'start', users.join_date,
                                'end', users.end_date,
                                'experiance', JSON_OBJECT(
                                    'y', if(users.end_date IS NULL, UPPER(CONCAT( timestampdiff(year, users.join_date, now()))), UPPER(CONCAT( timestampdiff(year, users.join_date, users.end_date)))),
                                    'm', if(users.end_date IS NULL, UPPER(CONCAT(timestampdiff (month, users.join_date, now()) % 12)), UPPER(CONCAT(timestampdiff (month, users.join_date, users.end_date) % 12))),
                                    'd', if(users.end_date IS NULL, UPPER(CONCAT(floor(timestampdiff(day, users.join_date, now()) % 30.4375))), UPPER(CONCAT(floor(timestampdiff(day, users.join_date, users.end_date) % 30.4375))))
                                ),
                                'indicator', if(users.end_date IS NULL, 'G', 'R')
                            ) as employment,
                            
                            /* VISA */
                            JSON_OBJECT(
                                'id', visa.id,
                                'company', UPPER(visa.name),
                                'expire', users.visa_expire,
                                'validity', JSON_OBJECT(
                                    'y', UPPER(CONCAT( timestampdiff(year, now(), users.visa_expire))),
                                    'm', UPPER(CONCAT(timestampdiff (month, now(), users.visa_expire) % 12)),
                                    'd', UPPER(CONCAT(floor (timestampdiff(day, now(), users.visa_expire) % 30.4375)))
                                ),
                                'indicator', (
                                    CASE
                                    WHEN DATEDIFF(users.visa_expire, now()) > 30 THEN 'G'
                                    WHEN DATEDIFF(users.visa_expire, now()) < 30 AND DATEDIFF(users.visa_expire, now()) > 0 THEN 'Y'
                                    WHEN DATEDIFF(users.visa_expire, now()) < 0 THEN 'R'
                                    ELSE 'R'
                                    END
                                )
                            ) as visa,
                            
                            /* CPR */
                            JSON_OBJECT(
                                'id', users.cpr,
                                'expire', users.cpr_expire,
                                'validity', JSON_OBJECT(
                                    'y', UPPER(CONCAT(timestampdiff(year, now(), users.cpr_expire))),
                                    'm', UPPER(CONCAT(timestampdiff (month, now(), users.cpr_expire) % 12)),
                                    'd', UPPER(CONCAT(floor (timestampdiff(day, now(), users.cpr_expire) % 30.4375)))
                                ),
                                'indicator', (
                                    CASE
                                    WHEN DATEDIFF(users.cpr_expire, now()) > 30 THEN 'G'
                                    WHEN DATEDIFF(users.cpr_expire, now()) < 30 AND DATEDIFF(users.cpr_expire, now()) > 0 THEN 'Y'
                                    WHEN DATEDIFF(users.cpr_expire, now()) < 0 THEN 'R'
                                    ELSE 'R'
                                    END
                                )
                            ) as cpr,
                            
                            /* PASSPORT */
                            JSON_OBJECT(
                                'id', users.passport,
                                'expire', users.passport_expire,
                                'validity', JSON_OBJECT(
                                    'y', UPPER(CONCAT( timestampdiff(year, now(), users.passport_expire))),
                                    'm', UPPER(CONCAT(timestampdiff (month, now(), users.passport_expire) % 12)),
                                    'd', UPPER(CONCAT(floor (timestampdiff(day, now(), users.passport_expire) % 30.4375)))
                                ),
                                'indicator', (
                                    CASE
                                    WHEN DATEDIFF(users.passport_expire, now()) > 180 THEN 'G'
                                    WHEN DATEDIFF(users.passport_expire, now()) < 180 AND DATEDIFF(users.passport_expire, now()) > 0 THEN 'Y'
                                    WHEN DATEDIFF(users.passport_expire, now()) < 0 THEN 'R'
                                    ELSE 'R'
                                    END
                                ),
                                'state', (select state from employees_passport_transactions WHERE eid = users.id ORDER BY employees_passport_transactions.created_at DESC LIMIT 1)
                            ) as passport,

                            (
                                CASE
                                WHEN users.passport IS NULL THEN 'I'
                                WHEN users.passport_expire IS NULL THEN 'I'
                                WHEN users.cpr IS NULL THEN 'I'
                                WHEN users.cpr_expire IS NULL THEN 'I'
                                WHEN department.cid IS NULL THEN 'I'
                                WHEN users.visa IS NULL AND users.nationality <> 'BAHRAIN' THEN 'I'
                                WHEN users.visa_expire IS NULL AND users.nationality <> 'BAHRAIN' THEN 'I'
                                ELSE 'C'
                                END
                            ) as incomplete
                        
                        FROM
                            users
                        LEFT JOIN
                            countries as country ON country.iso3 = users.nationality
                        LEFT JOIN
                            companies_departments as department on department.id = users.department
                        LEFT JOIN
                            companies as company ON company.id = department.cid
                        LEFT JOIN
                            employees_visas as visa ON visa.id = users.visa
                        ");

//--------------------------------------------------------------------
//  Direct Routes
//--------------------------------------------------------------------

    public function index() {

        // Laravel Raw MySQL Methode
        $query = $this->emp . (" WHERE users.end_date IS NULL ORDER BY users.name ASC");

        // Executing The Query
        $results = DB::select($query);

        // Return The Results
        return $results;

    }

    public function mgIndex($id) {

        // Laravel Raw MySQL Methode
        $query = $this->emp . (" WHERE department = ?");

        // Executing The Query
        $results = DB::select($query, [$id]);

        // Return The Results
        return $results;

    }

    public function ex() {

        // Laravel Raw MySQL Methode
        $query = $this->emp . (" WHERE users.end_date IS NOT NULL ORDER BY users.end_date, company.name, users.name, country.name ASC");

        // Executing The Query
        $results = DB::select($query);

        // Return The Results
        return $results;

    }

    public function native() {

        // Laravel Raw MySQL Methode
        $query = $this->emp . (" WHERE users.end_date IS NULL AND users.nationality = 'BHR' ORDER BY users.name, company.name, country.name ASC");

        // Executing The Query
        $results = DB::select($query);

        // Return The Results
        return $results;

    }

    public function expatriate() {

        // Laravel Raw MySQL Methode
        $query = $this->emp . (" WHERE users.end_date IS NULL AND users.nationality <> 'BHR' ORDER BY company.name, users.name, country.name ASC");

        // Executing The Query
        $results = DB::select($query);

        // Return The Results
        return $results;

    }

    public function expiries() {

        // Laravel Raw MySQL Methode
        $query = $this->emp . (" 
                                WHERE
                                    users.cpr_expire between CURRENT_DATE() 
                                    AND 
                                    DATE_ADD(CURRENT_DATE(), INTERVAL 1 MONTH) 
                                    OR
                                    users.passport_expire between CURRENT_DATE() AND DATE_ADD(CURRENT_DATE(), INTERVAL 6 MONTH) 
                                    OR
                                    users.visa_expire between CURRENT_DATE() AND DATE_ADD(CURRENT_DATE(), INTERVAL 1 MONTH)
                                    AND 
                                    users.end_date IS NULL
                                ORDER BY
                                    users.name, company.name, country.name ASC
                                ");

        // Executing The Query
        $results = DB::select($query);

        // Return The Results
        return $results;

    }

    public function incomplete() {

        // Laravel Raw MySQL Methode
        $query = $this->emp . (" 
                                WHERE
                                    passport IS NULL OR
                                    passport_expire IS NULL OR
                                    cpr IS NULL OR
                                    cpr_expire IS NULL OR
                                    company IS NULL OR
                                    (visa IS NULL AND nationality <> 'BHR') OR
                                    (visa_expire IS NULL AND nationality <> 'BHR')
                                ORDER BY
                                    users.name, company.name, country.name ASC
                                ");

        // Executing The Query
        $results = DB::select($query);

        // Return The Results
        return $results;

    }

    public function deposits() {

        // Laravel Raw MySQL Methode
        $query = (" 
                    SELECT
                        *
                    FROM
                        (
                            " . $this->emp . "
                            WHERE
                                users.nationality <> 'BHR'
                            ORDER BY
                                users.name, company.name, country.name ASC
                        ) as users
                    WHERE
                        JSON_EXTRACT(users.passport, '$.state') = 'IN'
                ");

        // Executing The Query
        $results = DB::select($query);

        // This Is A Response If No Data
        if(sizeOf($results) == 0) {
            return response()->json($results, 400);
        }

        // Return The Results
        return $results;

    }

    public function males() {

        // Laravel Raw MySQL Methode
        $query = $this->emp . (" 
                                WHERE
                                    users.end_date IS NULL
                                    AND
                                    users.gender = 'M'
                                ORDER BY
                                    users.name, company.name, country.name ASC
                                ");

        // Executing The Query
        $results = DB::select($query);

        // If No Results
        if(sizeOf($results) == 0) {
            return response()->json($results, 400);
        }

        // Return The Results
        return $results;

    }

    public function females() {

        // Laravel Raw MySQL Methode
        $query = $this->emp . (" 
                                WHERE
                                    users.end_date IS NULL
                                    AND
                                    users.gender = 'F'
                                ORDER BY
                                    users.name, company.name, country.name ASC
                                ");

        // Executing The Query
        $results = DB::select($query);

        // If No Results
        if(sizeOf($results) == 0) {
            return response()->json($results, 400);
        }

        // Return The Results
        return $results;

    }

    public function store(Request $request) {

        // Basic Requirments For Any New Employee
        $request->validate([
            'name'              => 'required',
            'accesslevel'       => 'required',
            // 'contact'           => 'required',
            'position'          => 'required',
            'company'           => 'required',
            'gender'            => 'required',
            'nationality'       => 'required',
            'birthdate'         => 'required',
            'passport'          => 'required',
            'passport_expire'   => 'required',
            'join_date'         => 'required'
        ]);

        // Inser To Datatable
        return User::create($request->all());
        
    }

    public function show($id) {

        // Laravel Raw MySQL Methode
        $query = $this->emp . (" WHERE users.id = ? ");

        // Executing The Query
        $results = DB::select($query, [$id]);

        // If No Results
        if(sizeOf($results) == 0) {
            return response()->json($results, 400);
        }

        // Return The Results
        return $results;

    }

//--------------------------------------------------------------------
//  For Files Of the User
//--------------------------------------------------------------------

    // Get All The Files Of This User
    public function attachmentAll($cpr) {
        
        // Laravel Raw MySQL Methode
        $query = ("SELECT * FROM employees_attachments WHERE cpr = ? ORDER BY title, created_at DESC;");

        // Executing The Query
        $results = DB::select($query, [$cpr]);

        // Return The Results
        return $results;

    }

    // Get File Version Of The Same File
    public function attachmentVersions($title, $cpr) {

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

    // Uploads A Picture
    public function pictureUpload(Request $request, $cpr){
 
        // Laravel Raw MySQL Methode
        $query = ("SELECT * FROM users WHERE cpr = ?");
        
        // Executing The Query
        $employee = json_decode(json_encode(DB::select($query, [$cpr])));

        // Read The Unique Record
        $employee = $employee[0];

        // To Make Sure The Person Have A CPR
        if(is_null($employee->cpr) || empty($employee->cpr)) {
            return response()->json(['error'=>'employee cpr number is missing, please updare the user profile with same cpr number'], 401);
        }

        // Validate The File Type
        $validator = Validator::make($request->all(),[ 
            // 'file' => 'required|mimes:doc,docx,pdf,txt,csv|max:2048',
            'picture'  => 'required|mimes:png,jpg,jpeg,gif',
        ]);
 
        if($validator->fails()) {          
            return response()->json(['error'=>$validator->errors()], 401);                        
        }
 
        if ($request->file('picture')) {

            // Preparing Variables
            $picture            = $request->file('picture');
            $pictureExtension   = strtolower($picture->getClientOriginalExtension());
            $pictureNewName     = 'profile.' . $pictureExtension;
            $EmployeeDirectory  = str_replace(' ', '_', strtoupper($employee->cpr . '_' . $employee->name));
            $fileName           = $picture->storeAs('public/dist/employees/'. $EmployeeDirectory, $pictureNewName);
            $destinationPath    = public_path('dist\\employees\\' . $EmployeeDirectory);
            $picture->move($destinationPath, $fileName);

            // Laravel Raw MySQL Methode
            $query = "UPDATE users SET users.picture = ? WHERE cpr = ?";

            // Executing The Query
            $results = DB::update($query, [$fileName, $employee->cpr]);

            // Return A Response
            return response()->json([
                "success"   => true,
                "message"   => "File successfully uploaded",
                "fileName"  => $pictureNewName,
                "filePath"  => $destinationPath . '\\' . $pictureNewName,
                "fileURL"   => $fileName
            ]);
  
        }

  
    }

    // Uploads A File - Working 100%
    public function attachmentUpload(Request $request, $cpr) {
 
        // Laravel Raw MySQL Methode
        $query = ("SELECT * FROM users AS employee WHERE employee.cpr = ?");
        
        // Executing The Query
        $employee = json_decode(json_encode(DB::select($query, [$cpr])));

        // Make Sure The Result Is Not 0 Records & Not More Than One Record
        if(sizeof($employee) < 1) {
            return response()->json(['error'=>'No Records Found, Or CPR Field Of The Employee Is Not Set'], 401);
        } elseif(sizeof($employee) > 1) {
            return response()->json(['error'=>'Duplicate Employee Records Found'], 401);
        }

        // Make The Data In Single Object
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
        if($request->file('file')) {

            // Getting File Object From Request With Name 'file'
            $file               = $request->file('file');

            // Convert The String OF The File Name To Lower Case
            $fileOrigionalName  = strtolower($file->getClientOriginalName());

            // New File Name
            $fileNewName        = str_replace(' ', '_', date("Ymd_hisA") . "_" . str_replace('-', '_', $fileOrigionalName));

            // The Directory Name
            $EmployeeDirectory  = str_replace(' ', '_', strtoupper($employee->cpr . '_' . $employee->name));

            // Here We Define The Extension Of The File
            $fileExtensionName  = strtolower($file->getClientOriginalExtension());
            
            // Here We Store The File On To The Destination & Keep The File Origional Name In The Variable
            $fileUrl            = $file->storeAs('public/dist/employees/'. $EmployeeDirectory . '/Attachments', $fileNewName);

            // Here We Define The Directory Path Of The File
            $fileDirectory      = public_path('dist\employees\\'. $EmployeeDirectory . '\\Attachments');

            // If The Path Was Not Existing Then Create It
            File::ensureDirectoryExists($fileDirectory);

            // Move the Stored File On the System To The Directory
            $file->move($fileDirectory, $fileUrl);
        
            // This Is What Stores The Data In The Database
            $save               = new Attachments();                        // Openning A Record
            $save->eid          = $employee->id;                            // Employee ID
            $save->cpr          = $employee->cpr;                           // Employee CPR
            $save->title        = $request->title;                          // File Title
            $save->name         = $fileNewName;                             // File Title
            $save->type         = $fileExtensionName;                       // File Type
            $save->url          = $fileUrl;                                 // File URL
            $save->path         = $fileDirectory . '\\' . $fileNewName;     // File Storage Path
            $save->save();                                                  // Save Record To Database

            // Successful Response Message
            return response()->json([
                "success"   => true,
                "recordID"  => $save->id,
                "message"   => "File Successfully Uploaded",
                "fileName"  => $save->name,
                "filePath"  => $save->path,
                "fileURL"   => $save->url
            ]);
  
        }
  
    }

    // Delete Aattachment - Working 100%
    public function attachmentDelete($id) {

        // Deleteing The Note By Its ID
        $file = Attachments::find($id);
        
        // The Place Where The File Is
        $file_path = $file->path;

        // return $file_path;
        // if(File::exists($file_path)) {
        //     return $file_path;
        // } else {
        //     return "file is NOT available";
        // }
        
        if ($file->path != null && File::exists($file_path)){
            // File::disk('public/dist/employees/')->delete($file_path);
            if(File::delete($file_path)) {
                $query = $file->delete();
                if ($query) {
                    return response()->json(['code'=>1, 'msg'=>'File has been deleted successfully']);
                } else {
                    return response()->json(['code'=>0, 'msg'=>'Something went wrong']);
                }
            } else {
                return response()->json(['error'=>0, 'msg'=>'file not deleted']);
            }
        } else {
            return response()->json(['error'=>0, 'msg'=>'No Record Of The File Found']);
        }

    }

//--------------------------------------------------------------------
//  Search Routes By (name or cpr or passport or email)
//--------------------------------------------------------------------

    // Search Between People Who Still Working In The Company
    public function search($info) {

        // Laravel Raw MySQL Methode
        $query = $this->emp . (" 
            WHERE 
                users.end_date IS NULL
                AND
                (
                users.name like concat('%', '" . $info . "', '%')
                OR
                users.cpr like concat('%', '" . $info . "', '%')
                OR
                users.passport like concat('%', '" . $info . "', '%')
                OR
                users.email like concat('%', '" . $info . "', '%')
                )
            ORDER BY 
                users.name, 
                company.name, 
                country.name ASC
        ");

        // Executing The Query
        $results = DB::select($query);

        // If No Results
        if(sizeOf($results) == 0) {
            return response()->json($results, 400);
        }

        // Return The Results
        return $results;

    }

    // Search Between People Who Are Natives
    public function search_native($info) {

        // Laravel Raw MySQL Methode
        $query = $this->emp . (" 
            WHERE
                country.iso3 = 'BHR'
                AND
                (
                    users.name like concat('%', '" . $info . "', '%')
                    OR
                    users.cpr like concat('%', '" . $info . "', '%')
                    OR
                    users.passport like concat('%', '" . $info . "', '%')
                    OR
                    users.email like concat('%', '" . $info . "', '%')
                )
                AND
                users.end_date IS NULL
            ORDER BY 
                users.name, 
                company.name, 
                country.name ASC
        ");

        // Executing The Query
        $results = DB::select($query);

        // If No Results
        if(sizeOf($results) == 0) {
            return response()->json($results, 400);
        }

        // Return The Results
        return $results;

    }

    // Search Between People Who Are Expatriate
    public function search_expatriate($info) {

        // Laravel Raw MySQL Methode
        $query = $this->emp . (" 
            WHERE
                country.iso3 <> 'BHR'
                AND
                (
                    users.name like concat('%', '" . $info . "', '%')
                    OR
                    users.cpr like concat('%', '" . $info . "', '%')
                    OR
                    users.passport like concat('%', '" . $info . "', '%')
                    OR
                    users.email like concat('%', '" . $info . "', '%')
                )
                AND
                users.end_date IS NULL
            ORDER BY 
                users.name, 
                company.name, 
                country.name ASC
        ");

        // Executing The Query
        $results = DB::select($query);

        // If No Results
        if(sizeOf($results) == 0) {
            return response()->json($results, 400);
        }

        // Return The Results
        return $results;

    }

    // Search Between People Who Have Expire Documents
    public function search_expire($info) {

        // Laravel Raw MySQL Methode
        $query = $this->emp . (" 
            WHERE
                users.end_date IS NULL
                AND
                (
                    users.name like concat('%', '" . $info . "', '%')
                    OR
                    users.cpr like concat('%', '" . $info . "', '%')
                    OR
                    users.passport like concat('%', '" . $info . "', '%')
                    OR
                    users.email like concat('%', '" . $info . "', '%')
                )
                AND
                (
                    users.cpr_expire between CURRENT_DATE() AND DATE_ADD(CURRENT_DATE(), INTERVAL 1 MONTH)
                    OR
                    users.passport_expire between CURRENT_DATE() AND DATE_ADD(CURRENT_DATE(), INTERVAL 6 MONTH)
                    OR
                    users.visa_expire between CURRENT_DATE() AND DATE_ADD(CURRENT_DATE(), INTERVAL 1 MONTH)
                )
            ORDER BY 
                users.name, 
                company.name, 
                country.name ASC
        ");

        // Executing The Query
        $results = DB::select($query);

        // If No Results
        if(sizeOf($results) == 0) {
            return response()->json($results, 400);
        }

        // Return The Results
        return $results;

    }

    // Search Between People Who Have Incomplete Profile
    public function search_incomplete($info) {

        // Laravel Raw MySQL Methode
        $query = $this->emp . (" 
                                WHERE
                                    users.end_date IS NULL
                                    AND
                                    (
                                        users.name like concat('%', '" . $info . "', '%')
                                        OR
                                        users.cpr like concat('%', '" . $info . "', '%')
                                        OR
                                        users.passport like concat('%', '" . $info . "', '%')
                                        OR
                                        users.email like concat('%', '" . $info . "', '%')
                                    )
                                    AND
                                    (
                                        passport IS NULL OR
                                        passport_expire IS NULL OR
                                        cpr IS NULL OR
                                        cpr_expire IS NULL OR
                                        company IS NULL OR
                                        (visa IS NULL AND nationality <> 'BHR') OR
                                        (visa_expire IS NULL AND nationality <> 'BHR')
                                    )
                                ORDER BY
                                    users.name, company.name, country.name ASC
                                ");

        // Executing The Query
        $results = DB::select($query);

        // Return The Results
        return $results;

    }

    // Search Between People Who Kept Their Passports With Us
    public function search_deposits($info) {

        // Laravel Raw MySQL Methode
        $query = (" 
                    SELECT
                        *
                    FROM
                        (
                            " . $this->emp . "
                            WHERE
                                users.nationality <> 'BHR'
                            ORDER BY
                                users.name, company.name, country.name ASC
                        ) as users
                    WHERE
                        (
                            users.name like concat('%', '" . $info . "', '%')
                            OR
                            JSON_EXTRACT(users.cpr, '$.id') like concat('%', '" . $info . "', '%')
                            OR
                            JSON_EXTRACT(users.passport, '$.id') like concat('%', '" . $info . "', '%')
                            OR
                            JSON_EXTRACT(users.contact, '$.email') like concat('%', '" . $info . "', '%')
                        )
                        AND
                        JSON_EXTRACT(users.passport, '$.state') = 'IN'
                ");

        // Executing The Query
        $results = DB::select($query);

        // This Is A Response If No Data
        if(sizeOf($results) == 0) {
            return response()->json($results, 400);
        }

        // Return The Results
        return $results;

    }

    // Search Between People Who Are Male Gendered
    public function search_male($info) {

        // Laravel Raw MySQL Methode
        $query = $this->emp . (" 
                                WHERE
                                    users.end_date IS NULL
                                    AND
                                    (
                                        users.name like concat('%', '" . $info . "', '%')
                                        OR
                                        users.cpr like concat('%', '" . $info . "', '%')
                                        OR
                                        users.passport like concat('%', '" . $info . "', '%')
                                        OR
                                        users.email like concat('%', '" . $info . "', '%')
                                    )
                                    AND
                                    ( 
                                        users.gender = 'M' 
                                        OR 
                                        users.gender = 'MALE'
                                    )
                                ORDER BY
                                    users.name, company.name, country.name ASC
                                ");

        // Executing The Query
        $results = DB::select($query);

        // Return The Results
        return $results;

    }

    // Search Between People Who Are female Gendered
    public function search_female($info) {

        // Laravel Raw MySQL Methode
        $query = $this->emp . (" 
                                WHERE
                                    users.end_date IS NULL
                                    AND
                                    (
                                        users.name like concat('%', '" . $info . "', '%')
                                        OR
                                        users.cpr like concat('%', '" . $info . "', '%')
                                        OR
                                        users.passport like concat('%', '" . $info . "', '%')
                                        OR
                                        users.email like concat('%', '" . $info . "', '%')
                                    )
                                    AND
                                    ( 
                                        users.gender = 'F' 
                                        OR 
                                        users.gender = 'FEMALE'
                                    )
                                ORDER BY
                                    users.name, company.name, country.name ASC
                                ");

        // Executing The Query
        $results = DB::select($query);

        // Return The Results
        return $results;

    }

    // Search Between People Who Have Left The Company
    public function search_ex($info) {

        // Laravel Raw MySQL Methode
        $query = $this->emp . (" 
            WHERE
                (
                    users.name like concat('%', '" . $info . "', '%')
                    OR
                    users.cpr like concat('%', '" . $info . "', '%')
                    OR
                    users.passport like concat('%', '" . $info . "', '%')
                    OR
                    users.email like concat('%', '" . $info . "', '%')
                )
                AND
                users.end_date IS NOT NULL
            ORDER BY 
                users.name, 
                company.name, 
                country.name ASC
        ");

        // Executing The Query
        $results = DB::select($query);

        // If No Results
        if(sizeOf($results) == 0) {
            return response()->json($results, 400);
        }

        // Return The Results
        return $results;

    }

//--------------------------------------------------------------------
//  Search By A Specific Field
//--------------------------------------------------------------------

    // Search People By Name
    public function search_name($name) {

        // Laravel Raw MySQL Methode
        $query = $this->emp . (" WHERE users.name like concat('%', ?, '%') ORDER BY users.name, company.name, country.name ASC");

        // Executing The Query
        $results = DB::select($query, [$name]);

        // If No Results
        if(sizeOf($results) == 0) {
            return response()->json($results, 400);
        }

        // Return The Results
        return $results;

    }

    // Search People By Passport
    public function search_email($email) {

        // Laravel Raw MySQL Methode
        $query = $this->emp . (" WHERE users.email = ?");

        // Executing The Query
        $results = DB::select($query, [$email]);

        // If No Results
        if(sizeOf($results) == 0) {
            return response()->json($results, 400);
        }

        // Return The Results
        return $results;

    }

    // Search People By CPR
    public function search_cpr($cpr) {

        // Laravel Raw MySQL Methode
        $query = $this->emp . (" WHERE users.cpr LIKE concat('%', ?, '%') ORDER BY users.name ASC");

        // Executing The Query
        $results = DB::select($query, [$cpr]);

        // If No Results
        if(sizeOf($results) == 0) {
            return response()->json($results, 400);
        }

        // Return The Results
        return $results;

    }

    // Search People By Passport
    public function search_passport($passport) {

        // Laravel Raw MySQL Methode
        $query = $this->emp . (" WHERE users.passport LIKE concat('%', ?, '%') ORDER BY users.name ASC");

        // Executing The Query
        $results = DB::select($query, [$passport]);

        // If No Results
        if(sizeOf($results) == 0) {
            return response()->json($results, 400);
        }

        // Return The Results
        return $results;

    }

    // Search By Company
    public function search_company($company) {

        // Laravel Raw MySQL Methode
        $query = $this->emp . (" WHERE company.name like concat('%', ?, '%') ORDER BY company.name, users.name, country.name ASC");

        // Executing The Query
        $results = DB::select($query, [$company]);

        // If No Results
        if(sizeOf($results) == 0) {
            return response()->json($results, 400);
        }

        // Return The Results
        return $results;

    }

    // Get : Employees Uppraisals
    public function getEmployeeUppraisals($eid) {

        $query = ("
                    SELECT 
                        uppraisal.id AS 'id',
                        employee.id AS 'eid',
                        company.id AS 'cid',
                        uppraisal.did AS 'did',
                        UPPER(if(employee.nationality = 'BHR', 'NONE', visa.id)) AS 'vid',
                        UPPER(if(employee.nationality = 'BHR', 'NONE', visa.name)) AS 'visa',
                        UPPER(if(employee.nationality = 'BHR', 'NONE', uppraisal.visa_expire)) as 'visa_expire',
                        -- UPPER(employee.name) AS 'name',
                        UPPER(company.name) AS 'company',
                        UPPER(department.name) AS 'department',
                        UPPER(uppraisal.position) AS 'position',
                        UPPER(uppraisal.start_date) AS 'start',
                        UPPER(uppraisal.end_date) AS 'end',
                        UPPER(ROUND(uppraisal.salary, 0)) AS 'salary',
                        UPPER(if(ROUND((uppraisal.salary - LAG(uppraisal.salary, 1) OVER (ORDER BY uppraisal.start_date ASC)), 0) IS NULL, 0, ROUND((uppraisal.salary - LAG(uppraisal.salary, 1) OVER (ORDER BY uppraisal.start_date ASC)), 0))) AS 'increment',
                        UPPER(IF(TIMESTAMPDIFF(MONTH, uppraisal.start_date, LEAD(uppraisal.start_date, 1) OVER (ORDER BY uppraisal.start_date ASC)) IS NULL, IF(employee.end_date IS NULL, TIMESTAMPDIFF(MONTH, uppraisal.start_date, now()), TIMESTAMPDIFF(MONTH, employee.end_date, uppraisal.start_date)),TIMESTAMPDIFF(MONTH, uppraisal.start_date, LEAD(uppraisal.start_date, 1) OVER (ORDER BY uppraisal.start_date ASC)))) as 'months',
                        UPPER(
                            if(
                                    ROUND(TIMESTAMPDIFF(MONTH, uppraisal.start_date, LEAD(uppraisal.start_date, 1) OVER (ORDER BY uppraisal.start_date ASC)) * uppraisal.salary, 0) IS NULL, 
                                    ROUND(IF(TIMESTAMPDIFF(MONTH, uppraisal.start_date, LEAD(uppraisal.start_date, 1) OVER (ORDER BY uppraisal.start_date ASC)) IS NULL, IF(employee.end_date IS NULL, TIMESTAMPDIFF(MONTH, uppraisal.start_date, now()), TIMESTAMPDIFF(MONTH, employee.end_date, uppraisal.start_date)),TIMESTAMPDIFF(MONTH, uppraisal.start_date, LEAD(uppraisal.start_date, 1) OVER (ORDER BY uppraisal.start_date ASC))) * uppraisal.salary, 0), 
                                    ROUND(TIMESTAMPDIFF(MONTH, uppraisal.start_date, LEAD(uppraisal.start_date, 1) OVER (ORDER BY uppraisal.start_date ASC)) * uppraisal.salary, 0)
                                )
                            ) AS 'earning',
                        enroller.id AS 'doneBy_id',
                        UPPER(enroller.name) AS 'doneBy'
                    FROM 
                        employees_uppraisals AS uppraisal
                    LEFT JOIN
                        users AS employee ON uppraisal.eid = employee.id
                    LEFT JOIN
                        companies_departments AS department ON department.id = uppraisal.did
                    LEFT JOIN
                        companies AS company ON company.id = department.cid
                    LEFT JOIN
                        employees_visas AS visa ON visa.id = uppraisal.vid
                    LEFT JOIN
                        users AS enroller ON enroller.id = uppraisal.doneBy
                    WHERE
                        employee.id = ?
                    ORDER BY
                        uppraisal.start_date DESC,
                        employee.name ASC
                ");

        // Executing The Query
        $results = DB::select($query, [$eid]);

        // If No Results
        if(sizeOf($results) == 0) {
            return response()->json($results, 400);
        }

        // Return The Results
        return $results;

    }

    // Get Company Employees
    public function getCompanyEmployees($cid) {

        $query = ("
        
                    SELECT
                        DISTINCT
                        employee.id AS 'id', 
                        UPPER(employee.name) AS 'name'
                    FROM
                        users AS employee
                    LEFT JOIN
                        employees_uppraisals AS uppraisal ON uppraisal.eid = employee.id
                    LEFT JOIN
                        companies_departments AS department ON department.id = uppraisal.did
                    LEFT JOIN
                        companies AS company ON company.id = department.cid
                    WHERE
                        company.id = ?
                        AND
                        employee.end_date IS NULL
                    ORDER BY
                        employee.name ASC

                ");

        // Executing The Query
        $results = DB::select($query, [$cid]);

        // If No Results
        if(sizeOf($results) == 0) {
            return response()->json($results, 400);
        }

        // Return The Results
        return $results;

    }

    // Get Department Employees
    public function getDepartmentEmployees($did) {

        $query = ("
        
                    SELECT
                        DISTINCT
                        employee.id AS 'id', 
                        UPPER(employee.name) AS 'name'
                    FROM
                        users AS employee
                    LEFT JOIN
                        employees_uppraisals AS uppraisal ON uppraisal.eid = employee.id
                    LEFT JOIN
                        companies_departments AS department ON department.id = uppraisal.did
                    LEFT JOIN
                        companies AS company ON company.id = department.cid
                    WHERE
                        department.id = ?
                        AND
                        employee.end_date IS NULL
                    ORDER BY
                        employee.name ASC

                ");

        // Executing The Query
        $results = DB::select($query, [$did]);

        // If No Results
        if(sizeOf($results) == 0) {
            return response()->json($results, 400);
        }

        // Return The Results
        return $results;

    }

    // Search By Visa Source
    public function search_visa($visa) {

        // Laravel Raw MySQL Methode
        $query = $this->emp . (" WHERE visa.name like concat('%', ?, '%') ORDER BY users.name, company.name, country.name ASC");

        // Executing The Query
        $results = DB::select($query, [$visa]);

        // If No Results
        if(sizeOf($results) == 0) {
            return response()->json($results, 400);
        }

        // Return The Results
        return $results;

    }

//--------------------------------------------------------------------
//  Charts Routes
//--------------------------------------------------------------------

    public function ChartNationality() {

        // Laravel Raw MySQL Methode
        $query = ("
                    -- SET @total = (select count(*) from users);

                    SELECT
                        country.name,
                        count(*) as count,
                        Round((count(*)/(select count(*) from users)) * 100, 1) as percent
                    FROM
                        users
                    LEFT JOIN
                        list_countries as country on country.iso3 = users.nationality
                    GROUP BY
                        country.name
                    ORDER BY
                        count DESC
        ");

        // Executing The Query
        $results = DB::select($query);

        // If No Results
        if(sizeOf($results) == 0) {
            return response()->json($results, 400);
        }

        // Return The Results
        return $results;

    }

    public function ChartCompany() {

        // Laravel Raw MySQL Methode
        $query = ("
                    SELECT
                        if(company.name IS NULL, 'NOT SET', company.name) as company,
                        count(*) as count,
                        Round((count(*)/(select count(*) from users)) * 100, 1) as percent
                    FROM
                        users
                    LEFT JOIN
                        companies_departments AS department ON users.department = department.id
                    LEFT JOIN
                        companies AS company ON company.id = department.cid
                    GROUP BY
                        company.name
                    ORDER BY
                        count DESC
        ");

        // Executing The Query
        $results = DB::select($query);

        // If No Results
        if(sizeOf($results) == 0) {
            return response()->json($results, 400);
        }

        // Return The Results
        return $results;

    }

    public function ChartVisa() {

        // Laravel Raw MySQL Methode
        $query = ("        
                    SELECT
                        if(visa.name IS NULL, 'NOT SET', visa.name) as visa,
                        count(*) as count,
                        Round((count(*)/(select count(*) from users)) * 100, 1) as percent
                    FROM
                        users
                    LEFT JOIN
                        employees_visas as visa on visa.id = users.visa
                    GROUP BY
                        visa.name
                    ORDER BY
                        count DESC
        ");

        // Executing The Query
        $results = DB::select($query);

        // If No Results
        if(sizeOf($results) == 0) {
            return response()->json($results, 400);
        }

        // Return The Results
        return $results;

    }

//--------------------------------------------------------------------
//  Update Routes
//--------------------------------------------------------------------

    public function update(Request $request, $id) {

        // Finding User Via ID
        $user = User::find($id);

        // Updating Data To the User From The $request Object
        $user->update($request->all());
        
        return $user;
    }

//--------------------------------------------------------------------
//  Terminate Routes
//--------------------------------------------------------------------

    public function terminate(Request $request, $id) {
        return User::destroy($id);
    }

//--------------------------------------------------------------------
//  Delete Routes
//--------------------------------------------------------------------

    public function destroy($id) {
        return User::destroy($id);
    }

//--------------------------------------------------------------------
//  Get Files & Attachments
//--------------------------------------------------------------------

    public function files($cpr) {

        // Laravel Raw MySQL Methode
        $query = ("
                    SELECT
                        *
                    FROM 
                        employees_attachments AS attachments
                    WHERE
                        attachments.cpr = ?
                    ORDER BY
	                    created_at DESC
        ");

        // Executing The Query
        $results = DB::select($query, [$cpr]);

        // Return The Results
        return $results;

    }

}
