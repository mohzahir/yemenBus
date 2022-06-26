<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | This option controls the default authentication "guard" and password
    | reset options for your application. You may change these defaults
    | as required, but they're a perfect start for most applications.
    |
    */

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],
 
    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | Next, you may define every authentication guard for your application.
    | Of course, a great default configuration has been defined for you
    | here which uses session storage and the Eloquent user provider.
    |
    | All authentication drivers have a user provider. This defines how the
    | users are actually retrieved out of your database or other storage
    | mechanisms used by this application to persist your user's data.
    |
    | Supported: "session", "token"
    |
    */

       'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'api' => [
            'driver' => 'token',
            'provider' => 'users',
            'hash' => false,
        ],
        'admin' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],
        'marketer' => [
            'redirectTo' => 'marketers.archive',
            'driver' => 'session',
            'provider' => 'marketers',
           ],
            'provider' => [
            'redirectTo' => 'dashboard.provider.showAccountInfo',
            'driver' => 'session',
            'provider' => 'providerss',
           ],
           'lab' => [
            'redirectTo' => 'dashboard.lab.index',
            'driver' => 'session',
            'provider' => 'labs',
           ],
           'passenger' => [
            'driver' => 'session',
            'provider' => 'passengers',
           ],
    ],
    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | All authentication drivers have a user provider. This defines how the
    | users are actually retrieved out of your database or other storage
    | mechanisms used by this application to persist your user's data.
    |
    | If you have multiple user tables or models you may configure multiple
    | sources which represent each model / table. These sources may then
    | be assigned to any extra authentication guards you have defined.
    |
    | Supported: "database", "eloquent"
    |
    */
    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\User::class,
        ],

        'marketers' => [
            'driver' => 'eloquent',
            'model' => App\Marketer::class,
           ],

           'providerss' => [
            'driver' => 'eloquent',
            'model' => App\Provider::class,
           ],
           'passengers' => [
            'driver' => 'eloquent',
            'model' => App\Passenger::class,
           ],

        'admins' => [
           'driver' => 'eloquent',
           'model' => App\Admin::class,
         ]
         , 'labs' => [
           'driver' => 'eloquent',
           'model' => App\Lab::class,
         ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    |
    | You may specify multiple password reset configurations if you have more
    | than one user table or model in the application and you want to have
    | separate password reset settings based on the specific user types.
    |
    | The expire time is the number of minutes that the reset token should be
    | considered valid. This security feature keeps tokens short-lived so
    | they have less time to be guessed. You may change this as needed.
    |
    */

   'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_resets',
            'expire' => 60,
        ],
        'marketers' => [
            'provider' => 'marketers',
            'table' => 'password_resets',
            'expire' => 60,
        ],'admin' => [
            'provider' => 'admins',
            'table' => 'password_resets',
            'expire' => 60,
        ],'provider' => [
            'provider' => 'providerss',
            'table' => 'password_resets',
            'expire' => 60,
        ],'passenger' => [
            'provider' => 'passengers',
            'table' => 'password_resets',
            'expire' => 60,
        ],'lab' => [
            'provider' => 'labs',
            'table' => 'password_resets',
            'expire' => 60,
          ],
    ],
    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    |
    | Here you may define the amount of seconds before a password confirmation
    | times out and the user is prompted to re-enter their password via the
    | confirmation screen. By default, the timeout lasts for three hours.
    |
    */

    'password_timeout' => 10800,

];
