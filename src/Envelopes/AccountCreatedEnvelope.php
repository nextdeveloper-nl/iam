<?php

namespace Envelopes;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Envelope;

class AccountCreatedEnvelope extends Mailable
{
    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.account-created',
            data: [
                'user' => $this->user
            ]
        );
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Account Created',
            to: [
                new Address(
                    //  User email
                )
            ],
            from: new Address(
                'no-reply@plusclouds.com'
            ),
            replyTo: [
                new Address(
                    'support@plusclouds.com'
                )
            ],
        );
    }

    public function build()
    {
        return $this->view('emails.account-created');
    }
}
