<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\employees_visas;
use Illuminate\Support\Facades\DB;


class VisasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index() {

        // Laravel Raw MySQL Methode
        $query = ("SELECT DISTINCT * FROM employees_visas GROUP BY name ORDER BY name ASC;");

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
        $result = employees_visas::create($request->all());
        return $result;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id) {

        // Laravel Raw MySQL Methode
        $query = ("SELECT * FROM employees_visas WHERE id = ?");

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
        $results = employees_visas::find($id);
        
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
        return employees_visas::destroy($id);
    }
}
