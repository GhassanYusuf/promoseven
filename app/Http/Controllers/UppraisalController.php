<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\employees_uppraisal;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class UppraisalController extends Controller
{

    private $uppraisal = ("
    
                        SELECT
                            position.id as 'id',
                            UPPER(employee.id) AS 'eid',
                            UPPER(employee.name) AS 'name',
                            UPPER(position.position) AS 'position',
                            UPPER(department.name) AS 'department',
                            UPPER(company.name) AS 'company',
                            UPPER(visa.name) AS 'visa',
                            UPPER(position.salary) AS 'salary',
                            (position.salary - LAG(position.salary, 1) OVER ( ORDER BY position.created_at ASC ) ) as 'difference',
                            ROUND(((position.salary - LAG(position.salary, 1) OVER ( ORDER BY position.created_at ASC ) ) / LAG(position.salary, 1) OVER ( ORDER BY position.created_at ASC )), 1) * 100 as 'percent',
                            UPPER(position.allowances) AS 'allowances',
                            UPPER(position.duties) AS 'duties',
                            UPPER(position.documents) AS 'documents',
                            UPPER(position.effective) AS 'effective',
                            UPPER(position.created_at) AS 'created_at'
                        FROM 
                            users AS employee
                        LEFT JOIN
                            employees_uppraisals AS position ON position.eid = employee.id
                        LEFT JOIN
                            companies_departments AS department ON department.id = position.did
                        LEFT JOIN
                            employees_visas AS visa ON visa.id = position.vid
                        LEFT JOIN
                            companies AS company ON company.id = department.cid

                    ");

    private $uppraisal2 = ("
                            SELECT 
                                uppraisal.id AS 'id',
                                employee.id AS 'eid',
                                company.id AS 'cid',
                                uppraisal.did AS 'did',
                                visa.id AS 'vid',
                                enroller.id AS 'enrid',
                                UPPER(employee.name) AS 'name',
                                UPPER(company.name) AS 'company',
                                UPPER(department.name) AS 'department',
                                UPPER(uppraisal.position) AS 'position',
                                UPPER(if(employee.nationality = 'BHR', 'NONE', visa.name)) AS 'visa',
                                UPPER(uppraisal.effective) AS 'effective',
                                UPPER(ROUND(uppraisal.salary, 0)) AS 'salary',
                                UPPER(ROUND((uppraisal.salary - LAG(uppraisal.salary, 1) OVER (ORDER BY uppraisal.effective ASC)), 0)) AS 'increment',
                                UPPER(TIMESTAMPDIFF(MONTH, uppraisal.effective, LEAD(uppraisal.effective, 1) OVER (ORDER BY uppraisal.effective ASC))) as 'months',
                                UPPER(ROUND(TIMESTAMPDIFF(MONTH, uppraisal.effective, LEAD(uppraisal.effective, 1) OVER (ORDER BY uppraisal.effective ASC)) * uppraisal.salary, 0)) AS 'earning',
                                UPPER(enroller.name) AS 'enroller'
                            FROM 
                                users AS employee
                            LEFT JOIN
                                employees_uppraisals AS uppraisal ON uppraisal.eid = employee.id
                            LEFT JOIN
                                companies_departments AS department ON department.id = uppraisal.did
                            LEFT JOIN
                                companies AS company ON company.id = department.cid
                            LEFT JOIN
                                employees_visas AS visa ON visa.id = uppraisal.vid
                            LEFT JOIN
                                users AS enroller ON enroller.id = uppraisal.doneBy
                        ");

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index() {
        
        // Modifying the Query
        $query = ("

                    SELECT
                        position.id as 'id',
                        UPPER(employee.id) AS 'eid',
                        UPPER(employee.name) AS 'name',
                        UPPER(position.position) AS 'position',
                        UPPER(department.name) AS 'department',
                        UPPER(company.name) AS 'company',
                        UPPER(visa.name) AS 'visa',
                        UPPER(position.salary) AS 'salary',
                        UPPER(position.allowances) AS 'allowances',
                        UPPER(position.duties) AS 'duties',
                        UPPER(position.documents) AS 'documents',
                        UPPER(position.effective) AS 'effective',
                        UPPER(position.created_at) AS 'created_at'
                    FROM 
                        users AS employee
                    LEFT JOIN
                        employees_uppraisals AS position ON position.eid = employee.id
                    LEFT JOIN
                        companies_departments AS department ON department.id = position.did
                    LEFT JOIN
                        employees_visas AS visa ON visa.id = position.vid
                    LEFT JOIN
                        companies AS company ON company.id = department.cid
                    ORDER BY
                        position.created_at DESC,
                        employee.name ASC
                ");

        // Executing The Query
        $result = DB::select($query);

        // Return The Result
        return $result;

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request) {
        
        // Inser To Datatable
        return employees_uppraisal::create($request->all());

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($eid) {

        // Modifying the Query
        $query = $this->uppraisal2 . ("
                                WHERE
                                    employee.id = ?
                                ORDER BY
                                    uppraisal.created_at DESC
                            ");

        // Executing The Query
        $result = DB::select($query, [$eid]);

        // Return The Result
        return $result;

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id) {

        // Find the Record By The ID
        $uppraisal = employees_uppraisal::find($id);

        // Executing The Query
        $uppraisal->update($uppraisal->all());
        
        // Return The Result
        return $uppraisal;

    }

    public function migrate() {

        $query = ("
                    INSERT INTO
                        employees_uppraisals
                        (
                            eid, 
                            did, 
                            vid, 
                            position, 
                            effective,
                            doneBy,
                            created_at,
                            updated_at
                        )
                    SELECT 
                        employee.id AS 'eid',
                        department.id AS 'did',
                        visa.id AS 'vid',
                        employee.position as 'position',
                        employee.join_date as 'effective',
                        171,
                        now(),
                        now()
                        -- company.id AS 'cid',
                        -- UPPER(company.name) AS 'company',
                        -- UPPER(department.name) AS 'department',
                        -- visa.name AS 'visa',
                        -- employee.join_date as 'effective'
                    FROM 
                        users AS employee
                    LEFT JOIN
                        companies_departments AS department ON department.id = employee.department
                    LEFT JOIN
                        companies AS company ON company.id = department.cid
                    LEFT JOIN
                        employees_visas AS visa ON visa.id = employee.visa
                    ORDER BY
                        company.name,
                        department.name
                        ASC
                ");

        // Executing The Query
        $result = DB::insert($query);

        // Return The Result
        return $result;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id) {

        // Deleting A Record
        return employees_uppraisal::destroy($id);

    }

}
