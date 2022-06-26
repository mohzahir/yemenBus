<?php

return [
    'username' => env('JAWALY_USERNAME', 'username'),
    'password' => env('JAWALY_PASSWORD', 'password'),
    'sender' => env('JAWALY_SENDER', 'sender'),
    /*
      |--------------------------------------------------------------------------
      | Request Type
      |--------------------------------------------------------------------------
      | Sending request type
      | Options: post, get
      |
     */
    'request_type' => 'post',
    /*
      |--------------------------------------------------------------------------
      | Unicode encoding
      |--------------------------------------------------------------------------
      | Determine to encode message body using unicode or not
      |
     */
    'unicode' => true,
    /*
      |--------------------------------------------------------------------------
      | Save log
      |--------------------------------------------------------------------------
      | Determine to save sent sms log
      |
     */
    'save_log' => true,
    /*
      |--------------------------------------------------------------------------
      | Sms log container
      |--------------------------------------------------------------------------
      | Choose sms log container.
      | If database choosen you must migrate migration files of the package
      | Options: file, database
      |
     */
    'log_container' => 'file'
];
