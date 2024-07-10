<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Mailer
    |--------------------------------------------------------------------------
    |
    | This option controls the default mailer that is used to send any email
    | messages sent by your application. Alternative mailers may be setup
    | and used as needed; however, this mailer will be used by default.
    |
    */
    'url' => env('APP_URL', 'http://localhost/ProyectoFinal/ProyectoDaw/public'),
    'driver' => env('MAIL_DRIVER', 'smtp'),


    'host'=> env('MAIL_HOST','smtp.gmail.com'),

    'port'=>env('MAIL_PORT',465),


    'from' => [
        'address' => 'retrogames12341234@gmail.com',
        'name' =>  'RETROGAMES',
    ],


    'encryption'=> 'ssl',


    'username'=>env('MAIL_USERNAME'),

    'password'=>env('MAIL_PASSWORD'),

    'sendmail'=>'/usr/sbin/sendmail -bs',

    'pretend'=>false,

];
