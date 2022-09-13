<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\employees_notes;
use Illuminate\Support\Facades\DB;

class NotesController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request) {
        $result = employees_notes::create($request->all());
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
        $query = (" 
                    SELECT
                        employees_notes.id,
                        employees_notes.eid,
                        employees_notes.title,
                        employees_notes.content,
                        users.name as 'done_by',
                        employees_notes.created_at,
                        employees_notes.updated_at
                    FROM 
                        employees_notes
                    LEFT JOIN
                        users on users.id = employees_notes.done_by
                    WHERE 
                        eid = ?
                    ORDER BY 
                        employees_notes.created_at DESC;
                ");

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
        $notes = employees_notes::find($id);
        
        // Update The Note With Request Data
        $notes->update($request->all());

        // Return The Values For Display
        return $notes;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id) {

        // Deleteing The Note By Its ID
        return employees_notes::destroy($id);
        
    }
}
