<?php

namespace App\EnxRtc;

class Errors
{
    public static $errors = [
        4001 => ["result" => "4001", "error" => "Required parameter missing"],
        4002 => ["result" => "4002", "error" => "Required JSON Body missing"],
        4003 => ["result" => "4003", "error" => "JSON Body Error"],
        4004 => ["result" => "4004", "error" => "Required Key missing in JSON Body"],
        4005 => ["result" => "4005", "error" => "Invalid Key value JSON Body"],
        4006 => ["result" => "4006", "error" => "Forbidden. Not privileged to access data"],
        1001 => ["result" => "1001", "error" => "Authentication failed"],
        1002 => ["result" => "1002", "error" => "Requested Data not found"],
        1003 => ["result" => "1003", "error" => "Mailing Error"],
        1004 => ["result" => "1004", "error" => "Data Error"],
        5001 => ["result" => "5001", "error" => "Invalid HTTP Request"],
        5001 => ["result" => "5002", "error" => "System Settings/DB Setup Issues"],

    ];

    public static function getError($code)
    {
        return self::$errors[$code];
    }

}
