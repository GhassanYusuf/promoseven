<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\countries;
use Illuminate\Support\Facades\DB;

class CountriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index() {

        // Laravel Raw MySQL Methode
        $query = ("SELECT DISTINCT * FROM countries ORDER BY name ASC");

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

        

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id) {
        
        // Laravel Raw MySQL Methode
        $query = ("SELECT * FROM countries WHERE id = ?");

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
