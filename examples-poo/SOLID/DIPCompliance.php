<?php

interface MessageSenderInterface
{
    public function send(string $to, string $message): void;
}

class EmailSender implements MessageSenderInterface
{
    public function send(string $to, string $message): void
    {
        echo "Sending email to $to: $message\n";
    }
}

class SMSSender implements MessageSenderInterface
{
    public function send(string $to, string $message): void
    {
        echo "Sending SMS to $to: $message\n";
    }
}

class NotificationService
{
    private MessageSenderInterface $messageSender;

    public function __construct(MessageSenderInterface $messageSender)
    {
        $this->messageSender = $messageSender;
    }

    public function sendNotification(string $to, string $message): void
    {
        $this->messageSender->send($to, $message);
    }
}

$emailSender = new EmailSender();
$smsSender = new SMSSender();

$emailNotificationService = new NotificationService($emailSender);
$smsNotificationService = new NotificationService($smsSender);

$emailNotificationService->sendNotification('student@example.com', 'Your assignment is due tomorrow');
$smsNotificationService->sendNotification('+1234567890', 'Your assignment is due tomorrow');


/////////////////////////////////////////////////////////////////////////

class MockMessageSender implements MessageSenderInterface
{
    public function send(string $to, string $message): void
    {
        // Do nothing, just for testing
    }
}
