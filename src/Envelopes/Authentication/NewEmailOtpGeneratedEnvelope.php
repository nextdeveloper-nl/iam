<?php

namespace NextDeveloper\IAM\Envelopes\Authentication;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use NextDeveloper\I18n\Helpers\i18n;
use NextDeveloper\IAM\Database\Models\Users;

class NewEmailOtpGeneratedEnvelope extends Mailable
{
    public $loginMechanism;

    private $user;

    public $subject;

    public function __construct($loginMechanism)
    {
        $this->loginMechanism = $loginMechanism;
        $this->user = Users::withoutGlobalScopes()
            ->where('id', $loginMechanism->iam_user_id)
            ->first();
    }

    public function content(): Content
    {
        $this->subject = i18n::t('We generated new password for you!');

        $otp = $this->loginMechanism->login_data['tempPassword'];

        $text = $otp;

        return new Content(
            html: 'emails.authentication.email-otp',
            text: 'emails.authentication.email-otp-text',
            with: [
                'subject' => $this->subject,
                'text' => $text,
                'html' => [
                    'otp' => $otp,
                ],
            ]
        );
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
            to: [
                new Address(
                    $this->user->email
                )
            ],
            from: new Address(
                config('leo.mail.from')
            ),
            replyTo: [
                new Address(
                    config('leo.mail.reply_to')
                )
            ],
        );
    }

    public function build()
    {
        return $this->view('emails.account-created');
    }
}
