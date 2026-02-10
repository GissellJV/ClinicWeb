<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class ResetPasswordMail extends Mailable
{
    public $token;
    public $email;

    public function __construct($token, $email)
    {
        $this->token = $token;
        $this->email = $email;
    }

    public function build()
    {
        return $this->subject('Recuperar contraseña')
            ->view('pacientes.reset_password');
    }
}
