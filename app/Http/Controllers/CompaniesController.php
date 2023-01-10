<?php

namespace App\Http\Controllers;

use App\Models\companies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompaniesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index() {

        // Query
        $query = ("SELECT DISTINCT * FROM companies GROUP BY name ORDER BY name ASC;");

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
        $result = companies::create($request->all());

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
        $query = ("SELECT * FROM companies WHERE id = ?");

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

    public function update(Request $request, $id) {
        
        // Find The Note By Its ID
        $results = companies::find($id);
        
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
        return companies::destroy($id);

    }

}
