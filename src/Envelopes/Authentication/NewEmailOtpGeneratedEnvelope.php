<?php

namespace NextDeveloper\IAM\Envelopes\Authentication;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Support\Facades\App;
use NextDeveloper\IAM\Database\Models\Users;

/**
 * The e-mail with the one-time code of the sign-in page. The code signs the user in or, after
 * "Forgot password?", proves the address before a new password is set.
 *
 * The mail is written in config('iam.otp_email.locale') (IAM_OTP_EMAIL_LOCALE), or in the application's
 * locale when that is not set. The subject comes from the iam::otp-email translations unless
 * config('iam.otp_email.subject') (IAM_OTP_EMAIL_SUBJECT) gives a fixed one. The application renders the
 * body with its own views emails.authentication.email-otp and email-otp-text, which receive $subject,
 * $text (the code) and $html['otp'] (the code) and may use the iam::otp-email lines.
 */
class NewEmailOtpGeneratedEnvelope extends Mailable
{
    public $loginMechanism;

    private $user;

    public $subject;

    /**
     * @param  mixed  $loginMechanism  The OneTimeEmail login mechanism holding the code.
     * @param  Users|null  $user  The mechanism's user, when the caller already has it.
     */
    public function __construct($loginMechanism, ?Users $user = null)
    {
        $this->loginMechanism = $loginMechanism;
        $this->user = $user ?? Users::withoutGlobalScopes()
            ->where('id', $loginMechanism->iam_user_id)
            ->first();

        $this->locale(self::mailLocale());
    }

    /**
     * The language the mail is written in: the configured one, otherwise the application's.
     */
    public static function mailLocale(): string
    {
        return config('iam.otp_email.locale') ?: App::getLocale();
    }

    public function content(): Content
    {
        $otp = $this->loginMechanism->login_data['tempPassword'];

        return new Content(
            html: 'emails.authentication.email-otp',
            text: 'emails.authentication.email-otp-text',
            with: [
                'subject' => $this->otpSubject(),
                'text' => $otp,
                'html' => [
                    'otp' => $otp,
                ],
            ]
        );
    }

    public function envelope(): Envelope
    {
        $this->subject = $this->otpSubject();

        return new Envelope(
            subject: $this->subject,
            to: [
                new Address(
                    $this->user->email
                ),
            ],
            from: new Address(
                config('leo.mail.from')
            ),
            replyTo: [
                new Address(
                    config('leo.mail.reply_to')
                ),
            ],
        );
    }

    /**
     * The subject in the mail's locale (the mailable renders inside its locale).
     */
    private function otpSubject(): string
    {
        return config('iam.otp_email.subject') ?: __('iam::otp-email.subject');
    }
}
