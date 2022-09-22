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
                (SELECT COUNT(*) FROM users WHERE users.cpr_expire between CURRENT_DATE() AND DATE_ADD(CURRENT_DATE(), INTERVAL 1 MONTH) OR users.passport_expire between CURRENT_DATE() AND DATE_ADD(CURRENT_DATE(), INTERVAL 6 MONTH) OR users.visa_expire between CURRENT_DATE() AND DATE_ADD(CURRENT_DATE(), INTERVAL 1 MONTH) AND users.end_date IS NULL) as 'Expiries',
                (SELECT COUNT(*) FROM users WHERE passport IS NULL OR passport_expire IS NULL OR cpr IS NULL OR cpr_expire IS NULL OR company IS NULL OR (visa IS NULL AND nationality <> 'BHR') OR (visa_expire IS NULL AND nationality <> 'BHR')) as 'Incompletes',
                (SELECT COUNT(*) FROM (SELECT *, (SELECT state FROM employees_passport_transactions WHERE eid = users.id ORDER BY employees_passport_transactions.created_at DESC LIMIT 1) as state FROM users WHERE users.nationality <> 'BHR') as users WHERE users.state = 'IN') as 'Deposits',
                (SELECT COUNT(*) FROM users WHERE users.end_date IS NULL AND users.gender = 'M') as 'Males',
                (SELECT COUNT(*) FROM users WHERE users.end_date IS NULL AND users.gender = 'F') as 'Females',
                (SELECT COUNT(*) FROM users WHERE users.end_date IS NOT NULL) as 'ExEmployees',
                (SELECT COUNT(*) FROM employees_leaves LEFT JOIN users as applier ON applier.id = employees_leaves.eid WHERE applier.end_date IS NULL AND ( employees_leaves.approval = 'A' AND employees_leaves.status = 'L')) as 'OnLeave',
                (SELECT COUNT(*) FROM employees_leaves AS leaves LEFT JOIN users ON leaves.eid = users.id WHERE leaves.approval IS NULL) as 'LeavesPending',
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
                (SELECT COUNT(*) FROM users WHERE passport IS NULL OR passport_expire IS NULL OR cpr IS NULL OR cpr_expire IS NULL OR company IS NULL OR (visa IS NULL AND nationality <> 'BHR') OR (visa_expire IS NULL AND nationality <> 'BHR')) as 'Incompletes',
                (SELECT COUNT(*) FROM (SELECT *, (SELECT state FROM employees_passport_transactions WHERE eid = users.id ORDER BY employees_passport_transactions.created_at DESC LIMIT 1) as state FROM users WHERE users.nationality <> 'BHR') as users WHERE users.state = 'IN') as 'Deposits',
                (SELECT COUNT(*) FROM users WHERE users.end_date IS NULL AND users.gender = 'M') as 'Males',
                (SELECT COUNT(*) FROM users WHERE users.end_date IS NULL AND users.gender = 'F') as 'Females',
                (SELECT COUNT(*) FROM users WHERE users.end_date IS NOT NULL) as 'ExEmployees',
                (SELECT COUNT(*) FROM employees_leaves LEFT JOIN users as applier ON applier.id = employees_leaves.eid WHERE applier.end_date IS NULL AND ( employees_leaves.approval = 'A' AND employees_leaves.status = 'L')) as 'OnLeave',
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
                        applier.id as 'id',
                        applier.picture as 'picture',
                        applier.name as 'name',
                        applier.gender as 'gender',
                        UPPER(applier.position) as 'position',
                        company.name as 'company',
                        employees_leaves.return_date as 'return',
                        JSON_OBJECT(
                            'y', if(applier.end_date IS NULL, UPPER(CONCAT(timestampdiff(year, applier.join_date, now()))), UPPER(CONCAT( timestampdiff(year, applier.join_date, applier.end_date)))),
                            'm', if(applier.end_date IS NULL, UPPER(CONCAT(timestampdiff (month, applier.join_date, now()) % 12)), UPPER(CONCAT(timestampdiff (month, applier.join_date, applier.end_date) % 12))),
                            'd', if(applier.end_date IS NULL, UPPER(CONCAT(floor(timestampdiff(day, applier.join_date, now()) % 30.4375))), UPPER(CONCAT(floor(timestampdiff(day, applier.join_date, applier.end_date) % 30.4375))))
                        ) as 'experiance'
                    FROM 
                        employees_leaves 
                    LEFT JOIN 
                        users as applier ON applier.id = employees_leaves.eid 
                    LEFT JOIN 
                        companies as company ON applier.company = company.id
                    WHERE 
                        applier.end_date IS NULL AND ( employees_leaves.approval = 'A' AND employees_leaves.status = 'L');
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
                        users.id as 'id',
                        users.picture as 'picture',
                        users.name as 'name',
                        users.position as 'position',
                        users.gender as 'gender',
                        users.join_date as 'join',
                        company.name as 'company',
                        JSON_OBJECT(
                            'y', if(users.end_date IS NULL, UPPER(CONCAT( timestampdiff(year, users.join_date, now()))), UPPER(CONCAT( timestampdiff(year, users.join_date, users.end_date)))),
                            'm', if(users.end_date IS NULL, UPPER(CONCAT(timestampdiff (month, users.join_date, now()) % 12)), UPPER(CONCAT(timestampdiff (month, users.join_date, users.end_date) % 12))),
                            'd', if(users.end_date IS NULL, UPPER(CONCAT(floor(timestampdiff(day, users.join_date, now()) % 30.4375))), UPPER(CONCAT(floor(timestampdiff(day, users.join_date, users.end_date) % 30.4375))))
                        ) as 'experiance'
                    FROM 
                        users
                    LEFT JOIN
                    	companies AS company ON company.id = users.company
                    WHERE 
                        MONTH(join_date) = MONTH(CURDATE()) 
                        AND 
                        YEAR(join_date) != YEAR(CURDATE()) 
                        AND 
                        end_date IS NULL;
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
                        users.id as 'id',
                        users.picture as 'picture',
                        users.name as 'name',
                        users.gender as 'gender',
                        users.join_date as 'join',
                        UPPER(users.position) as 'position',
                        company.name as 'company',
                        JSON_OBJECT(
                            'y', if(users.end_date IS NULL, UPPER(CONCAT( timestampdiff(year, users.join_date, now()))), UPPER(CONCAT( timestampdiff(year, users.join_date, users.end_date)))),
                            'm', if(users.end_date IS NULL, UPPER(CONCAT(timestampdiff (month, users.join_date, now()) % 12)), UPPER(CONCAT(timestampdiff (month, users.join_date, users.end_date) % 12))),
                            'd', if(users.end_date IS NULL, UPPER(CONCAT(floor(timestampdiff(day, users.join_date, now()) % 30.4375))), UPPER(CONCAT(floor(timestampdiff(day, users.join_date, users.end_date) % 30.4375))))
                        ) as 'experiance'
                    FROM 
                        users
                    LEFT JOIN
                    	companies AS company ON company.id = users.company
                    WHERE 
                        users.join_date IS NOT NULL 
                        AND 
                        users.join_date between DATE_ADD(NOW(), INTERVAL -90 DAY) 
                        AND 
                        users.end_date IS NULL
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
                        users.id as 'id',
                        users.picture as 'picture',
                        users.name as 'name',
                        users.gender as 'gender',
                        ROUND(DATEDIFF(CURRENT_DATE, STR_TO_DATE(users.birthdate, '%Y-%m-%d'))/365, 0) AS 'age',
                        users.birthdate as 'birthday',
                        UPPER(users.position) as 'position',
                        company.name as 'company',
                        JSON_OBJECT(
                            'y', if(users.end_date IS NULL, UPPER(CONCAT( timestampdiff(year, users.join_date, now()))), UPPER(CONCAT( timestampdiff(year, users.join_date, users.end_date)))),
                            'm', if(users.end_date IS NULL, UPPER(CONCAT(timestampdiff (month, users.join_date, now()) % 12)), UPPER(CONCAT(timestampdiff (month, users.join_date, users.end_date) % 12))),
                            'd', if(users.end_date IS NULL, UPPER(CONCAT(floor(timestampdiff(day, users.join_date, now()) % 30.4375))), UPPER(CONCAT(floor(timestampdiff(day, users.join_date, users.end_date) % 30.4375))))
                        ) as 'experiance'
                    FROM 
                        users
                    LEFT JOIN
                    	companies AS company ON company.id = users.company
                    WHERE 
                        MONTH(birthdate) = MONTH(CURDATE()) 
                        AND 
                        end_date IS NULL
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
                        users
                    LEFT JOIN
                        companies as company on company.id = users.company
                    WHERE
                        users.end_date is NULL
                    GROUP BY
                        company.name
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
                                employees_passport_transactions.type,
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
