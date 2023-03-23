<?php

namespace App\Http\Controllers;

use App\Models\Employees_Leaves;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LeavesController extends Controller
{

    /**
     * The Main Query
     * 
     */

    private $leavesQuery = ("
    
        SELECT 
            leaves.id as 'leave_id',
            applier.id as 'applier_id',
            applier.name as 'applier_name',
            leaves.created_at as 'apply_date',
            (
                CASE
                WHEN leaves.type = 'A' THEN 'ANNUAL'
                WHEN leaves.type = 'S' THEN 'SICK'
                WHEN leaves.type = 'W' THEN 'WITHOUT-PAY'
                WHEN leaves.type = 'P' THEN 'PATERNITY'
                WHEN leaves.type = 'M' THEN 'MATERNITY'
                WHEN leaves.type = 'C' THEN 'COMPASSIONATE'
                ELSE NULL
                END
            ) as 'type',
            leaves.start_date,
            leaves.return_date,
            DATEDIFF(leaves.return_date, leaves.start_date) as 'leave_days',
            (
                CASE
                WHEN leaves.status IS NULL THEN 'NOT YET LEFT'
                WHEN leaves.status = 'L' THEN 'ON LEAVE'
                WHEN leaves.status = 'R' THEN 'RETURNED'
                END
            ) as 'status',
            substitute.id as 'substitute_id',
            substitute.name as 'substitute_name',
            (
                CASE
                WHEN leaves.annual_ticket = 'Y' THEN 'YES'
                WHEN leaves.annual_ticket = 'N' THEN 'NO'
                ELSE NULL
                END
            ) as 'ticket',
            leaves.destination,
            leaves.flight_details,
            leaves.contact_info,
            -- leaves.record_date,
            leaves.note,
            (
                CASE
                WHEN leaves.hApproval IS NULL THEN 'PENDING'
                WHEN leaves.hApproval = 'A' THEN 'APPROVED'
                WHEN leaves.hApproval = 'R' THEN 'REJECTED'
                WHEN leaves.hApproval = 'C' THEN 'CANCELED'
                END
            ) as 'hApproval',
            (
                CASE
                WHEN leaves.mApproval IS NULL THEN 'PENDING'
                WHEN leaves.mApproval = 'A' THEN 'APPROVED'
                WHEN leaves.mApproval = 'R' THEN 'REJECTED'
                WHEN leaves.mApproval = 'C' THEN 'CANCELED'
                END
            ) as 'mApproval',
            hr.id as 'hr_id',
            hr.name as 'hr_name',
            mg.id as 'm_id',
            mg.name as 'm_name'
        FROM 
            employees_leaves as leaves
        LEFT JOIN 
            users as applier on applier.id = leaves.eid
        LEFT JOIN 
            users as substitute on substitute.id = leaves.employee_incharge
        LEFT JOIN 
            users as hr on hr.id = leaves.hApproved_by
        LEFT JOIN 
            users as mg on mg.id = leaves.mApproved_by
    ");

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index() {
        
        // Laravel Raw MySQL Methode
        $query = $this->leavesQuery . ("
                    ORDER BY
                        leaves.created_at DESC;
                ");

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

    public function list_hr_pending_req() {
        
        // Laravel Raw MySQL Methode
        $query = $this->leavesQuery . ("
                    WHERE
                        leaves.hApproval IS NULL
                        AND
                        leaves.mApproval = 'A'
                ");

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

    public function list_manager_pending_req() {
        
        // Laravel Raw MySQL Methode
        $query = $this->leavesQuery . ("
                    WHERE
                        leaves.mApproval IS NULL
                ");

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

    public function approvedReq() {
        
        // Laravel Raw MySQL Methode
        $query = $this->leavesQuery . ("
                    WHERE
                        leaves.hApproval = 'A'
                        AND
                        leaves.mApproval = 'A'
                ");

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

    public function rejectedReq() {
        
        // Laravel Raw MySQL Methode
        $query = $this->leavesQuery . ("
                    WHERE
                        leaves.hApproval = 'R'
                        OR
                        leaves.mApproval = 'R'
                ");

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

    public function canceledReq() {
        
        // Laravel Raw MySQL Methode
        $query = $this->leavesQuery . ("
                    WHERE
                        leaves.hApproval = 'C'
                        OR
                        leaves.mApproval = 'C'
                ");

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

    public function leaveStatusLeft() {
        
        // Laravel Raw MySQL Methode
        $query = $this->leavesQuery . ("
                    WHERE
                        leaves.status = 'L'
                        AND
                        leaves.hApproval = 'A'
                "); 

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

    public function leaveStatus() {
        
        // Laravel Raw MySQL Methode
        $query = $this->leavesQuery . ("
                    WHERE
                        leaves.status = 'L'
                    OR
                        leaves.status = 'R'
                    OR 
                        leaves.status IS NULL
                    AND 
                        leaves.hApproval = 'A'
                ");

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

        // Basic Requirments For Any New Employee
        $request->validate([
            'type'              => 'required',
            'start_date'        => 'required',
            'return_date'       => 'required',
            'annual_ticket'     => 'required',
        ]);

        // Inser To Datatable
        return employees_leaves::create($request->all());

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id) {

        // Laravel Raw MySQL Methode
        $query = $this->leavesQuery . (" 
                    WHERE
                        leaves.eid = ?
                ");

        // Executing The Query
        $results = DB::select($query, [$id]);

        // Return The Results
        return $results;

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function valid($id) {

        // Laravel Raw MySQL Methode
        $query = $this->leavesQuery . ("
                    WHERE
                        applier.id = ?
                        AND
                        current_date() BETWEEN date(start_date) and date(return_date)
                ");

        // Executing The Query
        $results = DB::select($query, [$id]);

        // Return The Results
        return $results;

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function findByDuration($id, $start, $end) {

        // Laravel Raw MySQL Methode
        $query = $this->leavesQuery . ("
                    WHERE
                        applier.id = ?
                        AND
                        current_date() BETWEEN date(?) and date(?)
                ");

        // Executing The Query
        $results = DB::select($query, [$id, $start, $end]);

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
        $leaves = employees_leaves::find($id);
        $leaves->update($request->all());
        return $leaves;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id) {
        return employees_leaves::destroy($id);
    }

}
