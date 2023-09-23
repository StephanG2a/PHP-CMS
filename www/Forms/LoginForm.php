<?php

namespace App\Forms;

use App\Forms\Abstract\AForm;

class LoginForm extends AForm
{
    protected $method = "POST";

    public function getConfig(): array
    {
        return [
            "config" => [
                "method" => $this->getMethod(),
                "action" => "/login",
                "submit" => "Login",
                "cancel" => "Cancel"
            ],
            "inputs" => [
                "email" => [
                    "type" => "email",
                    "placeholder" => "Your email",
                    "error" => "Invalid email format"
                ],
                "password" => [
                    "type" => "password",
                    "placeholder" => "Your password",
                    "error" => "Invalid password"
                ]
            ]
        ];
    }
}
