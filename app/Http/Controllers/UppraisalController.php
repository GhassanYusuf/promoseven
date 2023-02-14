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
                            position.id AS 'id',
                                employee.id AS 'eid',
                                company.id AS 'cid',
                                position.did AS 'did',
                                visa.id AS 'vid',
                                enroller.id AS 'enrid',
                                UPPER(employee.name) AS 'name',
                                UPPER(company.name) AS 'company',
                                UPPER(department.name) AS 'department',
                                UPPER(position.position) AS 'position',
                                UPPER(if(employee.nationality = 'BHR', 'NONE', visa.name)) AS 'visa',
                                UPPER(position.start_date) AS 'start_date',
                                UPPER(ROUND(position.salary, 0)) AS 'salary',
                                UPPER(ROUND((position.salary - LAG(position.salary, 1) OVER (ORDER BY position.start_date ASC)), 0)) AS 'increment',
                                UPPER(TIMESTAMPDIFF(MONTH, position.start_date, LEAD(position.start_date, 1) OVER (ORDER BY position.start_date ASC))) as 'months',
                                UPPER(ROUND(TIMESTAMPDIFF(MONTH, position.start_date, LEAD(position.start_date, 1) OVER (ORDER BY position.start_date ASC)) * position.salary, 0)) AS 'earning',
                                UPPER(enroller.name) AS 'enroller'
                            FROM 
                                users AS employee
                            LEFT JOIN
                                employees_uppraisals AS position ON position.eid = employee.id
                            LEFT JOIN
                                companies_departments AS department ON department.id = position.did
                            LEFT JOIN
                                companies AS company ON company.id = department.cid
                            LEFT JOIN
                                companies AS visa ON visa.id = position.vid
                            LEFT JOIN
                                users AS enroller ON enroller.id = position.doneBy
                        ");

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index() {
        
        // Modifying the Query
        $query = $this->uppraisal . ("
                    WHERE
                        employee.id = ?
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

    public function show($id) {

        // Modifying the Query
        $query = $this->uppraisal . ("
                                WHERE
                                    employee.id = ?
                                ORDER BY
                                    position.start_date DESC
                            ");

        // Executing The Query
        $result = DB::select($query, [$id]);

        // Return The Result
        return $result;

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function current($id) {

        // Modifying the Query
        $query = $this->uppraisal . ("
                                WHERE
                                    employee.id = ?
                                ORDER BY
                                    position.start_date DESC
                                LIMIT 1
                            ");

        // Executing The Query
        $result = DB::select($query, [$id]);

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

        // Finding User Via ID
        $position = employees_uppraisal::find($id);

        // Updating Data To the User From The $request Object
        $position->update($request->all());
        
        return $position;

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

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
