<?php

namespace App\Http\Controllers;

use App\Models\Announcements;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnnouncementsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index() {

        // Laravel Raw MySQL Methode
        $query = ("SELECT * FROM announcements");

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
            'title'         => 'required',
            'body'          => 'required',
            'start_date'    => 'required',
            'end_date'      => 'required'
        ]);

        // Inser To Datatable
        return announcements::create($request->all());

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id) {
        return announcements::find($id);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function valid() {

        // Laravel Raw MySQL Methode
        $query = ("
                    SELECT
                        *
                    FROM
                        announcements
                    WHERE
                        current_date() BETWEEN date(start_date) and date(end_date)
                ");

        // Executing The Query
        $results = DB::select($query);

        // Return The Results
        return $results;
        
     }

    /**
     * Display the specified resource.
     *
     * @param  int  $date
     * @return \Illuminate\Http\Response
     */

    public function findByDuration($start, $end) {

        // Laravel Raw MySQL Methode
        $query = ("SELECT * FROM announcements WHERE start_date BETWEEN ? and ?");

        // Executing The Query
        $results = DB::select($query, [$start, $end]);

        // Return The Results
        return $results;

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $date
     * @return \Illuminate\Http\Response
     */

    public function findByTitle($title) {

        // Laravel Raw MySQL Methode
        $query = ("SELECT * FROM announcements WHERE title LIKE concat('%', ?, '%')");

        // Executing The Query
        $results = DB::select($query, [$title]);

        // Return The Results
        return $results;

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $date
     * @return \Illuminate\Http\Response
     */

    public function findByBody($body) {

        // Laravel Raw MySQL Methode
        $query = ("SELECT * FROM announcements WHERE body LIKE concat('%', ? ,'%')");

        // Executing The Query
        $results = DB::select($query, [$body]);

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
        $announcements = announcements::find($id);
        $announcements->update($request->all());
        return $announcements;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id) {
        return announcements::destroy($id);
    }
    
}
