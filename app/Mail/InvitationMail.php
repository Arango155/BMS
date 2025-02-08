<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class InvitationMail extends Mailable
{
    public $empresa;
    public $token;

    public function __construct($empresa, $token)
    {
        $this->empresa = $empresa;
        $this->token = $token;
    }

    public function build()
    {
        return $this->subject("Invitación a {$this->empresa->nombre}")
            ->markdown('emails.invitation', [
                'empresa' => $this->empresa,
                'url' => route('invite.accept', $this->token)
            ]);
    }
}
