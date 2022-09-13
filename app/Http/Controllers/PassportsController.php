<?php

namespace App\Http\Controllers;

use App\Models\employees_passport_transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PassportsController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index() {

        // Laravel Raw MySQL Methode
        $query = ("SELECT * FROM employees_passport_transactions");

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
            'eid'           => 'required',
            'state'         => 'required',
            // 'done_by'       => 'required',
        ]);

        // Inser To Datatable
        return employees_passport_transactions::create($request->all());

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id) {

        // Laravel Raw MySQL Methode
        $query = ("SELECT * FROM employees_passport_transactions WHERE eid = ? ORDER BY created_at DESC");

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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id) {
        //
    }
}
