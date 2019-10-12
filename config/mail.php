<?php

return [


    'driver' => env('MAIL_DRIVER', 'smtp'),


    'host' => env('MAIL_HOST', 'smtp.mailgun.org'),


    'port' => env('MAIL_PORT', 587),


    'from' => ['address' => 'mido.15897@gmail.com', 'name' => 'Mohamed Ahmed'],


    'encryption' => 'tls',


    'username' => env('MAIL_USERNAME'),


    'password' => env('MAIL_PASSWORD'),


    'sendmail' => '/usr/sbin/sendmail -bs',


    'pretend' => false,

];