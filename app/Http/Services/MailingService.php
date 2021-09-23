<?php declare(strict_types=1);

namespace App\Http\Services;

class MailingService
{
    public function sendMail(array $data): void
    {
        $headers = 	"From: Contact Form <contact@mydomain.com>" . "\r\n" .
            "Reply-To: ". $data['email'] . "\r\n" .
            "MIME-Version: 1.0\r\n" .
            "Content-Type: text/html; charset=iso-8859-1\n";
        $to = 'contact@hyvor.com';
        $subject = 'Contacting you';

        mail($to, $subject, $data['message'] , $headers);
    }
}
