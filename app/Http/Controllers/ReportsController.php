<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private function groth($past, $current) {

        // If Denominator = 0 Then Error
        if($past == 0)
            return "ERROR";

        // Calculate The Growth 
        $groth = ($current - $past) / $past;
        
        // Return The Result
        return $groth;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function boxes() {
        
        // Lite Query That Gets Only The Numbers Requires
        $query = ("
            SELECT
                (SELECT COUNT(*) FROM users WHERE users.end_date IS NULL) as 'Employees',
                (SELECT COUNT(*) FROM users WHERE users.end_date IS NULL AND users.nationality = 'BHR') as 'Natives',
                (SELECT COUNT(*) FROM users WHERE users.end_date IS NULL AND users.nationality <> 'BHR') as 'Expatriates',
                (SELECT COUNT(*) FROM users AS employee LEFT JOIN employees_uppraisals AS position ON position.eid = employee.id WHERE employee.cpr_expire between CURRENT_DATE() AND DATE_ADD(CURRENT_DATE(), INTERVAL 1 MONTH) OR employee.passport_expire between CURRENT_DATE() AND DATE_ADD(CURRENT_DATE(), INTERVAL 6 MONTH) OR (SELECT visa_expire FROM employees_uppraisals WHERE eid = employee.id ORDER BY start_date DESC LIMIT 1) between CURRENT_DATE() AND DATE_ADD(CURRENT_DATE(), INTERVAL 1 MONTH) AND employee.end_date IS NULL) as 'Expiries',
                (SELECT COUNT(*) FROM users AS employee LEFT JOIN employees_uppraisals AS position ON position.eid = employee.id LEFT JOIN companies_departments AS department ON position.did = department.id WHERE passport IS NULL OR passport_expire IS NULL OR cpr IS NULL OR cpr_expire IS NULL OR position.did IS NULL OR ((SELECT vid FROM employees_uppraisals WHERE eid = employee.id ORDER BY start_date DESC LIMIT 1) IS NULL AND employee.nationality <> 'BHR') OR ((SELECT visa_expire FROM employees_uppraisals WHERE eid = employee.id ORDER BY start_date DESC LIMIT 1) IS NULL AND employee.nationality <> 'BHR')) as 'Incompletes',
                (SELECT COUNT(*) FROM (SELECT *, (SELECT state FROM employees_passport_transactions WHERE eid = users.id ORDER BY employees_passport_transactions.created_at DESC LIMIT 1) as state FROM users WHERE users.nationality <> 'BHR') as users WHERE users.state = 'IN') as 'Deposits',
                (SELECT COUNT(*) FROM users WHERE users.end_date IS NULL AND users.gender = 'M') as 'Males',
                (SELECT COUNT(*) FROM users WHERE users.end_date IS NULL AND users.gender = 'F') as 'Females',
                (SELECT COUNT(*) FROM users WHERE users.end_date IS NOT NULL) as 'ExEmployees',
                (SELECT COUNT(*) FROM employees_leaves LEFT JOIN users as applier ON applier.id = employees_leaves.eid WHERE applier.end_date IS NULL AND ( employees_leaves.hApproval = 'A' AND employees_leaves.status = 'L')) as 'OnLeave',
                (SELECT COUNT(*) FROM employees_leaves AS leaves LEFT JOIN users ON leaves.eid = users.id WHERE leaves.hApproval IS NULL AND leaves.mApproval = 'A') as 'LeavesPending',
                (SELECT COUNT(*) FROM users WHERE users.join_date IS NOT NULL AND users.join_date between DATE_ADD(NOW(), INTERVAL -90 DAY) AND users.end_date IS NULL) as 'Probation',
                (SELECT COUNT(*) FROM users WHERE MONTH(join_date) = MONTH(CURDATE()) AND YEAR(join_date) != YEAR(CURDATE()) AND end_date IS NULL) as 'Anniversary',
                (SELECT COUNT(*) FROM users WHERE MONTH(birthdate) = MONTH(CURDATE()) AND end_date IS NULL) as 'Birthdays'
        ");

        // Executing The Query
        $result = DB::select($query);

        // Return Values
        return $result[0];

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function companyBoxes() {
        
        // Lite Query That Gets Only The Numbers Requires
        $query = ("
            SELECT
                (SELECT COUNT(*) FROM users WHERE users.end_date IS NULL) as 'Employees',
                (SELECT COUNT(*) FROM users WHERE users.end_date IS NULL AND users.nationality = 'BHR') as 'Natives',
                (SELECT COUNT(*) FROM users WHERE users.end_date IS NULL AND users.nationality <> 'BHR') as 'Expatriates',
                (SELECT COUNT(*) FROM users WHERE users.cpr_expire between CURRENT_DATE() AND DATE_ADD(CURRENT_DATE(), INTERVAL 1 MONTH) OR users.passport_expire between CURRENT_DATE() AND DATE_ADD(CURRENT_DATE(), INTERVAL 6 MONTH) OR users.visa_expire between CURRENT_DATE() AND DATE_ADD(CURRENT_DATE(), INTERVAL 1 MONTH) AND users.end_date IS NULL) as 'Expiries',
                (SELECT COUNT(*) FROM users LEFT JOIN companies_departments as department ON department.id = users.department LEFT JOIN companies AS company ON company.id = department.cid WHERE users.passport IS NULL OR users.passport_expire IS NULL OR users.cpr IS NULL OR users.cpr_expire IS NULL OR users.department IS NULL OR (users.visa IS NULL AND users.nationality <> 'BHR') OR (users.visa_expire IS NULL AND users.nationality <> 'BHR')) as 'Incompletes',
                (SELECT COUNT(*) FROM (SELECT *, (SELECT state FROM employees_passport_transactions WHERE eid = users.id ORDER BY employees_passport_transactions.created_at DESC LIMIT 1) as state FROM users WHERE users.nationality <> 'BHR') as users WHERE users.state = 'IN') as 'Deposits',
                (SELECT COUNT(*) FROM users WHERE users.end_date IS NULL AND users.gender = 'M') as 'Males',
                (SELECT COUNT(*) FROM users WHERE users.end_date IS NULL AND users.gender = 'F') as 'Females',
                (SELECT COUNT(*) FROM users WHERE users.end_date IS NOT NULL) as 'ExEmployees',
                (SELECT COUNT(*) FROM employees_leaves LEFT JOIN users as applier ON applier.id = employees_leaves.eid WHERE applier.end_date IS NULL AND ( employees_leaves.hApproval = 'A' AND employees_leaves.status = 'L')) as 'OnLeave',
                (SELECT COUNT(*) FROM users WHERE users.join_date IS NOT NULL AND users.join_date between DATE_ADD(NOW(), INTERVAL -90 DAY) AND users.end_date IS NULL) as 'Probation',
                (SELECT COUNT(*) FROM users WHERE MONTH(join_date) = MONTH(CURDATE()) AND YEAR(join_date) != YEAR(CURDATE()) AND end_date IS NULL) as 'Anniversary',
                (SELECT COUNT(*) FROM users WHERE MONTH(birthdate) = MONTH(CURDATE()) AND end_date IS NULL) as 'Birthdays'
        ");

        // Executing The Query
        $result = DB::select($query);

        // Return Values
        return $result[0];

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function OnLeaveLite() {
        
        // Lite Query That Gets Only The Numbers Requires
        $query = ("
                    SELECT
                        employee.id as 'id',
                        employee.cpr as 'cpr',
                        employee.picture as 'picture',
                        employee.name as 'name',
                        employee.gender as 'gender',
                        UPPER(position.position) as 'position',
                        company.name as 'company',
                        department.name as 'department',
                        employees_leaves.return_date as 'return',
                        JSON_OBJECT(
                            'y', if(employee.end_date IS NULL, UPPER(CONCAT(timestampdiff(year, employee.join_date, now()))), UPPER(CONCAT( timestampdiff(year, employee.join_date, employee.end_date)))),
                            'm', if(employee.end_date IS NULL, UPPER(CONCAT(timestampdiff (month, employee.join_date, now()) % 12)), UPPER(CONCAT(timestampdiff (month, employee.join_date, employee.end_date) % 12))),
                            'd', if(employee.end_date IS NULL, UPPER(CONCAT(floor(timestampdiff(day, employee.join_date, now()) % 30.4375))), UPPER(CONCAT(floor(timestampdiff(day, employee.join_date, employee.end_date) % 30.4375))))
                        ) as 'experiance'
                    FROM 
                        employees_leaves
                    LEFT JOIN 
                        users as employee ON employee.id = employees_leaves.eid
                    LEFT JOIN
                        employees_uppraisals AS position ON position.eid = employee.id
                    LEFT JOIN
                        companies_departments AS department ON department.id = position.did
                    LEFT JOIN 
                        companies as company ON department.cid = company.id
                    WHERE 
                        employee.end_date IS NULL AND ( employees_leaves.hApproval = 'A' AND employees_leaves.status = 'L');
        ");

        // Executing The Query
        $result = DB::select($query);

        // Return Values
        return $result;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function AnniversaryLite() {
        
        // Lite Query That Gets Only The Numbers Requires
        $query = ("
                    SELECT 
                        employee.id as 'id',
                        employee.cpr as 'cpr',
                        employee.picture as 'picture',
                        employee.name as 'name',
                        position.position as 'position',
                        employee.gender as 'gender',
                        employee.join_date as 'join',
                        company.name as 'company',
                        department.name as 'department',
                        JSON_OBJECT(
                            'y', if(employee.end_date IS NULL, UPPER(CONCAT( timestampdiff(year, employee.join_date, now()))), UPPER(CONCAT( timestampdiff(year, employee.join_date, employee.end_date)))),
                            'm', if(employee.end_date IS NULL, UPPER(CONCAT(timestampdiff (month, employee.join_date, now()) % 12)), UPPER(CONCAT(timestampdiff (month, employee.join_date, employee.end_date) % 12))),
                            'd', if(employee.end_date IS NULL, UPPER(CONCAT(floor(timestampdiff(day, employee.join_date, now()) % 30.4375))), UPPER(CONCAT(floor(timestampdiff(day, employee.join_date, employee.end_date) % 30.4375))))
                        ) as 'experiance'
                    FROM 
                        users AS employee
                    LEFT JOIN
                        employees_uppraisals AS position ON employee.id = position.eid
                    LEFT JOIN
                        companies_departments AS department ON position.did = department.id
                    LEFT JOIN
                        companies AS company ON company.id = department.cid
                    WHERE 
                        MONTH(employee.join_date) = MONTH(CURDATE()) 
                        AND 
                        YEAR(employee.join_date) != YEAR(CURDATE()) 
                        AND 
                        employee.end_date IS NULL;
        ");

        // Executing The Query
        $result = DB::select($query);

        // Return Values
        return $result;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function ProbationLite() {
        
        // Lite Query That Gets Only The Numbers Requires
        $query = ("
                    SELECT 
                        employee.id as 'id',
                        employee.cpr as 'cpr',
                        employee.picture as 'picture',
                        employee.name as 'name',
                        employee.gender as 'gender',
                        employee.join_date as 'join',
                        UPPER(position.position) as 'position',
                        company.name as 'company',
                        department.name as 'department',
                        JSON_OBJECT(
                            'y', if(employee.end_date IS NULL, UPPER(CONCAT( timestampdiff(year, employee.join_date, now()))), UPPER(CONCAT( timestampdiff(year, employee.join_date, employee.end_date)))),
                            'm', if(employee.end_date IS NULL, UPPER(CONCAT(timestampdiff (month, employee.join_date, now()) % 12)), UPPER(CONCAT(timestampdiff (month, employee.join_date, employee.end_date) % 12))),
                            'd', if(employee.end_date IS NULL, UPPER(CONCAT(floor(timestampdiff(day, employee.join_date, now()) % 30.4375))), UPPER(CONCAT(floor(timestampdiff(day, employee.join_date, employee.end_date) % 30.4375))))
                        ) as 'experiance'
                    FROM 
                        users AS employee
					LEFT JOIN
						employees_uppraisals AS position ON position.eid = employee.id
                    LEFT JOIN
                        companies_departments AS department ON department.id = position.did
                    LEFT JOIN
                        companies AS company ON company.id = department.cid
                    WHERE 
                        employee.join_date IS NOT NULL 
                        AND 
                        employee.join_date between DATE_ADD(NOW(), INTERVAL -90 DAY) 
                        AND 
                        employee.end_date IS NULL
                ");

        // Executing The Query
        $result = DB::select($query);

        // Return Values
        return $result;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function BirthdayLite() {
        
        // Lite Query That Gets Only The Numbers Requires
        $query = ("
                    SELECT 
                        employee.id as 'id',
                        employee.cpr as 'cpr',
                        employee.picture as 'picture',
                        employee.name as 'name',
                        employee.gender as 'gender',
                        ROUND(DATEDIFF(CURRENT_DATE, STR_TO_DATE(employee.birthdate, '%Y-%m-%d'))/365, 0) AS 'age',
                        employee.birthdate as 'birthday',
                        UPPER(position.position) as 'position',
                        company.name as 'company',
                        department.name as 'department',
                        department.mid as 'managerId', 
                        JSON_OBJECT(
                            'y', if(employee.end_date IS NULL, UPPER(CONCAT( timestampdiff(year, employee.join_date, now()))), UPPER(CONCAT( timestampdiff(year, employee.join_date, employee.end_date)))),
                            'm', if(employee.end_date IS NULL, UPPER(CONCAT(timestampdiff (month, employee.join_date, now()) % 12)), UPPER(CONCAT(timestampdiff (month, employee.join_date, employee.end_date) % 12))),
                            'd', if(employee.end_date IS NULL, UPPER(CONCAT(floor(timestampdiff(day, employee.join_date, now()) % 30.4375))), UPPER(CONCAT(floor(timestampdiff(day, employee.join_date, employee.end_date) % 30.4375))))
                        ) as 'experiance'
                    FROM 
                        users AS employee
                    LEFT JOIN
						employees_uppraisals AS position ON position.eid = employee.id
                    LEFT JOIN
                        companies_departments AS department ON department.id = position.did
                    LEFT JOIN
                        companies_departments AS manager ON manager.id = department.mid
                    LEFT JOIN
                        companies AS company ON company.id = department.cid
                    WHERE 
                        MONTH(employee.birthdate) = MONTH(CURDATE()) 
                        AND 
                        employee.end_date IS NULL
        ");

        // Executing The Query
        $result = DB::select($query);

        // Return Values
        return $result;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function company() {

        // Building The Query
        $query = ("
                    SELECT 
                        if(company.name is NULL, 'UNSET', company.name) as 'company',
                        count(*) as 'count',
                        ROUND((count(*)/(select count(*) from users)) * 100, 1) as 'percentage'
                    FROM
                        users AS employee
					LEFT JOIN
						employees_uppraisals AS position ON position.eid = employee.id
                    LEFT JOIN
                        companies_departments AS department ON department.id = position.did
                    LEFT JOIN
                        companies AS company ON department.cid = company.id
                    WHERE
                        employee.end_date IS NULL
                    GROUP BY
                        employee.name
                    ORDER BY
                        count(*) DESC
                ");

        // Executing The Query
        $result = DB::select($query);

        // Return Values
        return $result;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function gender() {

        // Building The Query
        $query = ("
            SELECT
                if(users.gender = 'M', 'male', 'female') as 'gender',
                count(*) as 'count',
                ROUND((count(*)/(select count(*) from users)) * 100, 1) as 'percentage'
            FROM
                users
            WHERE
                users.end_date is NULL
            GROUP BY 
                users.gender
        ");

        // Executing The Query
        $result = DB::select($query);

        // Return Values
        return $result;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function passport() {

        // Building The Query
        $query = ("
                    SELECT
                        passports.state,
                        count(*) as 'count',
                        ROUND((count(*)/(select distinct count(*) from employees_passport_transactions)) * 100, 1) as 'percentage'
                    FROM
                        (
                            SELECT
                                users.id,
                                users.name,
                                users.end_date,
                                (select state from employees_passport_transactions WHERE eid = users.id ORDER BY employees_passport_transactions.created_at DESC LIMIT 1) as state
                            FROM 
                                employees_passport_transactions
                            LEFT JOIN
                                users on users.id = employees_passport_transactions.eid
                            GROUP BY
                                users.name
                            ORDER BY
                                users.id asc
                        ) as passports
                    WHERE
                        passports.end_date IS NULL
                        AND
                        passports.state IS NOT NULL
                    GROUP BY
                        passports.state
        ");

        // Executing The Query
        $result = DB::select($query);

        // Return Values
        return $result;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function country() {

        // Building The Query
        $query = ("
                    SELECT
                        country.name as 'country',
                        users.nationality as 'iso3',
                        COUNT(*) as 'count',
                        ROUND((COUNT(*)/(SELECT COUNT(*) FROM users)) * 100, 1) as 'percentage'
                    FROM
                        users
                    LEFT JOIN
                        countries AS country ON country.iso3 = users.nationality
                    GROUP BY
                        users.nationality
                    ORDER BY
                        COUNT(*)
                        DESC
        ");

        // Executing The Query
        $result = DB::select($query);

        // Return Values
        return $result;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function visa() {

        // Building The Query
        $query = ("
                    SELECT
                        visa.name as 'visa',
                        COUNT(*) as 'count',
                        ROUND((COUNT(*)/(SELECT COUNT(*) FROM users)) * 100, 1) as 'percentage'
                    FROM
                        users
                    LEFT JOIN
                        employees_visas AS visa ON visa.id = users.visa
                    WHERE
                        visa.name IS NOT NULL
                    GROUP BY
                        visa.name
                    ORDER BY
                        COUNT(*)
                        DESC
        ");

        // Executing The Query
        $result = DB::select($query);

        // Return Values
        return $result;

    }

}