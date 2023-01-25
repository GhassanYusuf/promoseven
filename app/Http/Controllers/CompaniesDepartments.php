<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\companies_departments;
use Illuminate\Support\Facades\DB;

class CompaniesDepartments extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index() {

        // Query
        $query = ("
                    SELECT 
                        DISTINCT
                        companies_departments.id,
                        if(companies_departments.pdid IS NULL, 'NONE', companies_departments.pdid) as 'pdid',
                        companies_departments.cid,
                        if(companies_departments.mid IS NULL, 'NONE', companies_departments.mid) as 'mid',
                        if(parent.name IS NULL, 'NONE', parent.name) as 'parent',
                        UPPER(company.name) as 'company',
                        UPPER(companies_departments.name) as 'department',
                        UPPER(if(companies_departments.mid IS NULL, 'NONE', users.name)) as 'manager'
                    FROM 
                        companies_departments 
                    LEFT JOIN
                        companies as company on company.id = companies_departments.cid
                    LEFT JOIN
                        companies as parent on parent.id = companies_departments.pdid
                    LEFT JOIN
                        users on users.id = companies_departments.mid
                    ORDER BY
                        company.name, companies_departments.name ASC;
                ");

        // Result
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

        // Query
        $result = companies_departments::create($request->all());

        // Return The Result
        return $result;

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id) {

        // Query
        $query = ("
                    SELECT 
                        DISTINCT
                        companies_departments.id,
                        if(companies_departments.pdid IS NULL, 'NONE', companies_departments.pdid) as 'pdid',
                        companies_departments.cid,
                        if(companies_departments.mid IS NULL, 'NONE', companies_departments.mid) as 'mid',
                        if(parent.name IS NULL, 'NONE', parent.name) as 'parent',
                        UPPER(company.name) as 'company',
                        UPPER(companies_departments.name) as 'department',
                        UPPER(if(companies_departments.mid IS NULL, 'NONE', users.name)) as 'manager'
                    FROM 
                        companies_departments 
                    LEFT JOIN
                        companies as company on company.id = companies_departments.cid
                    LEFT JOIN
                        companies as parent on parent.id = companies_departments.pdid
                    LEFT JOIN
                        users on users.id = companies_departments.mid
                    WHERE
                        companies_departments.id = ?
                ");

        // Result
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

    public function listDepartmentByCompany($cid) {

        $query = ("
                    SELECT
                        department.id as 'id',
                        company.id as 'cid',
                        UPPER(if(department.mid IS NULL, 'NONE', department.mid)) as 'mid',
                        UPPER(department.name) as 'department',
                        UPPER(company.name) as 'company',
                        UPPER(if(manager.name IS NULL, 'NONE', manager.name)) as 'manager',
                        if(manager.picture IS NULL, 'NONE', manager.picture) as 'picture'
                    FROM
                        companies_departments AS department
                    LEFT JOIN
                        companies AS company ON company.id = department.cid
                    LEFT JOIN
                        users AS manager ON manager.id = department.mid
                    WHERE
                        company.id = ?
                ");

        // Result
        $result = DB::select($query, [$cid]);

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

    public function listDepartmentLite() {

        // The Query
        $query = ("
                    SELECT
                        department.id,
                        concat(company.name, ' - ', department.name) as 'department'
                    FROM
                        companies_departments AS department
                    LEFT JOIN
                        companies AS company ON department.cid = company.id
                    ORDER BY
                        company.name,
                        department.name
                        ASC
        ");

        // Result
        $result = DB::select($query);

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

    public function batchMoveToNewDepartment($old, $new) {

        // Bact Move Employees To New Department
        $query = ("UPDATE users AS employee SET employee.department = ? WHERE employee.department = ?;");

        // Result
        $result = DB::update($query, [$new, $old]);

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

        // Find The Note By Its ID
        $results = companies_departments::find($id);
        
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

    public function destroy($id) {

        // Deleteing The Note By Its ID
        return companies_departments::destroy($id);

    }
    
}
