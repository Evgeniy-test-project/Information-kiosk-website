<?php
# app/routes/console.php
# php artisan send-mail
/*
use Illuminate\Support\Facades\Artisan;
use Mailtrap\Helper\ResponseHelper;
use Mailtrap\MailtrapClient;
use Mailtrap\Mime\MailtrapEmail;
use Symfony\Component\Mime\Address;

Artisan::command('send-mail', function () {
    $email = (new MailtrapEmail())
        ->from(new Address('hello@demomailtrap.co', 'Mailtrap Test'))
        ->to(new Address('stilmaster0@gmail.com'))
        ->subject('You are awesome!')
        ->category('Integration Test')
        ->text('Congrats for sending test email with Mailtrap!')
    ;

    $response = MailtrapClient::initSendingEmails(
        apiKey: '1d161311b73b51f7b5dd7a1062728603'
    )->send($email);

    var_dump(ResponseHelper::toArray($response));
})->purpose('Send Mail');*/
