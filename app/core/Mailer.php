<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mailer
{
    private PHPMailer $mail;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);

        $this->mail->isSMTP();
        $this->mail->Host       = MAIL_HOST;
        $this->mail->SMTPAuth   = true;
        $this->mail->Username   = MAIL_USERNAME;
        $this->mail->Password   = MAIL_PASSWORD;
        $this->mail->SMTPSecure = MAIL_ENCRYPTION === 'ssl' ? PHPMailer::ENCRYPTION_SMTPS : PHPMailer::ENCRYPTION_STARTTLS;
        $this->mail->Port       = MAIL_PORT;
        $this->mail->CharSet    = 'UTF-8';

        $this->mail->setFrom(MAIL_FROM_ADDRESS, MAIL_FROM_NAME);
    }

    public function to(string $address, string $name = ''): static
    {
        $this->mail->addAddress($address, $name);
        return $this;
    }

    public function subject(string $subject): static
    {
        $this->mail->Subject = $subject;
        return $this;
    }

    public function html(string $body): static
    {
        $this->mail->isHTML(true);
        $this->mail->Body    = $body;
        $this->mail->AltBody = strip_tags($body);
        return $this;
    }

    public function text(string $body): static
    {
        $this->mail->isHTML(false);
        $this->mail->Body = $body;
        return $this;
    }

    public function attach(string $path, string $name = ''): static
    {
        $this->mail->addAttachment($path, $name);
        return $this;
    }

    public function send(): bool
    {
        try {
            return $this->mail->send();
        } catch (Exception $e) {
            error_log('Mailer error: ' . $this->mail->ErrorInfo);
            return false;
        }
    }

    // ── Static shorthand ──────────────────────────────────────

    public static function make(): static
    {
        return new static();
    }
}
