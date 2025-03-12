<?php

class EmailSender
{
    public function sendEmail(string $to, string $message): void
    {
        echo "Sending email to $to: $message\n";
    }
}

class NotificationService
{
    private EmailSender $emailSender;

    public function __construct()
    {
        $this->emailSender = new EmailSender();
    }

    public function sendNotification(string $to, string $message): void
    {
        $this->emailSender->sendEmail($to, $message);
    }
}

$notificationService = new NotificationService();
$notificationService->sendNotification('student@example.com', 'Your assignment is due tomorrow');
