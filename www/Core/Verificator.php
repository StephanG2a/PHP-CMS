<?php

namespace App\Core;

class Verificator
{

    public static function form(array $config, array $data): array
    {
        $listOfErrors = [];
        if (count($config["inputs"]) != count($data) - 1) {
            die("Tentative de Hack");
        }


        foreach ($config["inputs"] as $name => $input) {

            if (!isset($data[$name])) {
                die("Tentative de Hack");
            }

            $value = $data[$name];

            // Check for email type and validate
            if ($input["type"] == "email" && !self::checkEmail($value)) {
                $listOfErrors[] = $input["error"];
            }

            // Check for minimum length
            if (isset($input["min"]) && strlen($value) < $input["min"]) {
                $listOfErrors[] = $input["error"];
            }

            // Check for maximum length
            if (isset($input["max"]) && strlen($value) > $input["max"]) {
                $listOfErrors[] = $input["error"];
            }

            // Check for password confirmation
            if (isset($input["confirm"]) && $value !== $data[$input["confirm"]]) {
                $listOfErrors[] = $input["error"];
            }

            // if (empty($data[$name])) {
            //     die("Tentative de Hack");
            // }

            // if ($input["type"] == "email" && !self::checkEmail($data[$name])) {
            //     $listOfErrors[] = $input["error"];
            // }
        }

        return $listOfErrors;
    }

    public static function checkEmail($email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
}
