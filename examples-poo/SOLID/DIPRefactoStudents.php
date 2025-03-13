<?php

abstract class Sender
{
    abstract public function send(string $to, string $message): void;
}

class EmailSender extends Sender
{
    public function send(string $to, string $message): void
    {
        echo "Sending email to $to: $message\n";
    }
}

class SMSSender extends Sender
{
    public function send(string $to, string $message): void
    {
        echo "Sending SMS to $to: $message\n";
    }
}

class NotificationService
{
    private Sender $sender;

    public function __construct(Sender $sender)
    {
        $this->sender = $sender;
    }

    public function sendNotification(string $to, string $message): void
    {
        $this->sender->send($to, $message);
    }
}

$notificationService = new NotificationService(new EmailSender());
$notificationService->sendNotification('student@example.com', 'Your assignment is due tomorrow');

$smsNotificationService = new NotificationService(new SMSSender());
$smsNotificationService->sendNotification('student@example.com', 'Your assignment is due tomorrow');
