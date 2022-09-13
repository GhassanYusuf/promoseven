<?php

    // To Display Missing If Null Value Is There
    if(!function_exists('display')) {
        function display($data) {
            if(!is_null($data)) {
                return $data;
            } else {
                return "MISSING";
            }
        }
    }

    // Date Formating To 01-May-22
    if(!function_exists('makeDate')) {
        function makeDate($date) {
            if(!is_null($date)) {
                $date = date_create($date);
                return strtoupper(date_format($date,"d-M-y"));
            } else {
                return "MISSING";
            }
        }
    }

    // Date Formating To 01-May-22
    if(!function_exists('makeTime')) {
        function makeTime($date) {
            if(!is_null($date)) {
                $date = date_create($date);
                return strtoupper(date_format($date,"g:i a"));
            } else {
                return "MISSING";
            }
        }
    }

    // Check Employee Experiance
    if(!function_exists('checkExperiance')) {
        function checkExperiance($data) {
            if(!is_null($data->start)) {
                $day    = NULL;
                $month  = NULL;
                $year   = NULL;
                if($data->experiance->y != 0) { $year = $data->experiance->y . " <sub>YEARS</sub> "; }
                if($data->experiance->m != 0) { $month = $data->experiance->m . " <sub>MONTHS</sub> "; }
                if($data->experiance->d != 0) { $day = $data->experiance->d . " <sub>DAYS</sub> "; }
                return $year . $month . $day;
            } else {
                return "MISSING INFO";
            }
        }
    }

    // Makes Validity 
    if(!function_exists('checkValidity')) {
        function checkValidity($data) {
            if(!is_null($data->expire)) {

                $day    = NULL;
                $month  = NULL;
                $year   = NULL;

                if($data->validity->y != 0) { $year = $data->validity->y . " <sub>YEARS</sub> "; }
                if($data->validity->m != 0) { $month = $data->validity->m . " <sub>MONTHS</sub> "; }
                if($data->validity->d != 0) { $day = $data->validity->d . " <sub>DAYS</sub> "; }

                return $year . $month . $day;
            } else {
                return "MISSING INFO";
            }
        }
    }

    // Years Of Work
    if(!function_exists('checkExperiance')) {
        function checkExperiance($work) {
            if(!is_null($work->experiance)) {

                $day    = NULL;
                $month  = NULL;
                $year   = NULL;

                if($data->experiance->y != 0) { $year = $data->validity->y . " <sub>YEARS</sub> "; }
                if($data->experiance->m != 0) { $month = $data->validity->m . " <sub>MONTHS</sub> "; }
                if($data->experiance->d != 0) { $day = $data->validity->d . " <sub>DAYS</sub> "; }

                return $year . $month . $day;
            } else {
                return "MISSING INFO";
            }
        }
    }

    // Check Picture
    if(!function_exists('checkPicture')) {
        function checkPicture($user) {
            if(!is_null($user->picture)) {
                return $user->picture;
            } else {
                if($user->gender == "M" || $user->gender == "MALE") {
                    return asset('dist/img/avatar/male.png');
                } elseif($user->gender == "F" || $user->gender == "FEMALE") {
                    return asset('dist/img/avatar/female.png');
                } else {
                    return asset('dist/img/avatar/male.png');
                }
            }
        }
    }

    // Check Whick Color To Put
    if(!function_exists('colorSelect')) {
        function colorSelect($data) {
            if($data == 'G') {
                return "success";
            } elseif($data == 'Y') {
                return "warning";
            } elseif($data == 'R') { 
                return "danger";
            }  elseif($data == 'I') { 
                return "info";
            } else {
                return "danger";
            }
        }
    }

?>