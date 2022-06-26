<?php

return [

'driver'     => env('MAIL_DRIVER', 'sendmail'),
'host'       => env('MAIL_HOST', 'smtp.gmail.com'),
'port'       => env('MAIL_PORT', 587),
'from'       => ['address' =>'hidayaalzahok@gmail.com', 'name' => 'hedaya'],
'encryption' => env('MAIL_ENCRYPTION', 'tls'),
'username'   => env('MAIL_USERNAME','hidayaalzahok@gmail.com'),
'password'   => env('MAIL_PASSWORD','ayaahmad'),
'sendmail'   => '/usr/sbin/sendmail -bs',];
