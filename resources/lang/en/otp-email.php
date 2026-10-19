<?php

/*
 * The e-mail with the one-time code of the sign-in page (NewEmailOtpGeneratedEnvelope). The same code
 * signs the user in ("Use an e-mail code instead") or proves the address before a new password is set
 * ("Forgot password?"). Application templates (emails.authentication.email-otp) may use these lines.
 */
return [
    'subject' => 'Your sign-in code',
    'heading' => 'Your one-time sign-in code',
    'intro' => 'Enter this code on the sign-in page to sign in or to set a new password.',
    'validity' => 'The code works once. When you ask for a new code, this one stops working.',
    'ignore' => 'If you did not ask for this code, you can ignore this e-mail.',
    'text' => ':app: your one-time sign-in code is :code. The code works once. If you did not ask for it, ignore this e-mail.',
];
