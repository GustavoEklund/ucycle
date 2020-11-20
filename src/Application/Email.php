<?php

namespace Application;

use Exception;
use PHPMailer\PHPMailer\PHPMailer;

/**
 * Class Email
 * @package Application
 */
class Email
{
    private PHPMailer $mail;
    private string $subject;
    private string $body;
    private string $recipient_name;
    private string $recipient_email;
    private array $attachments;
    private Exception $error;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);

        $this->mail->isSMTP();
        $this->mail->isHTML();
        $this->mail->setLanguage('br');

        $this->mail->SMTPAuth = true;
        $this->mail->SMTPSecure = 'tls';
        $this->mail->CharSet = 'utf-8';

        $this->mail->Host = $_ENV['EMAIL_HOST'];
        $this->mail->Port = $_ENV['EMAIL_PORT'];
        $this->mail->Username = $_ENV['EMAIL_USER_NAME'];
        $this->mail->Password = $_ENV['EMAIL_PASSWORD'];
    }

    public function attach(string $file_path, string $file_name): Email
    {
        $this->attachments[$file_path] = $file_name;
        return $this;
    }

    public function send(string $from_name = '', string $from_email = ''): bool
    {
        if (empty($from_name)) {
            $from_name = $_ENV['EMAIL_FROM_NAME'];
        }

        if (empty($from_email)) {
            $from_email = $_ENV['EMAIL_FROM_EMAIL'];
        }

        try {
            $this->mail->Subject = $this->subject;
            $this->mail->msgHTML($this->body);
            $this->mail->addAddress($this->recipient_email, $this->recipient_name);
            $this->mail->setFrom($from_email, $from_name);

            if (!empty($this->attachments)) {
                foreach ($this->attachments as $path => $name) {
                    $this->mail->addAttachment($path, $name);
                }
            }

            $this->mail->send();

            return true;
        } catch (Exception $exception) {
            $this->error = $exception;
            return false;
        }
    }

    public function getError(): ?Exception
    {
        return $this->error ?? null;
    }

    public function getMail(): PHPMailer
    {
        return $this->mail;
    }

    public function setMail(PHPMailer $mail): Email
    {
        $this->mail = $mail;
        return $this;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): Email
    {
        $this->subject = $subject;
        return $this;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function setBody(string $body): Email
    {
        $this->body = $body;
        return $this;
    }

    public function getRecipientName(): string
    {
        return $this->recipient_name;
    }

    public function setRecipientName(string $recipient_name): Email
    {
        $this->recipient_name = $recipient_name;
        return $this;
    }

    public function getRecipientEmail(): string
    {
        return $this->recipient_email;
    }

    public function setRecipientEmail(string $recipient_email): Email
    {
        $this->recipient_email = $recipient_email;
        return $this;
    }
}
