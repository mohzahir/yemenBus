<?php
//معلومات ايميل الذي سوف يرسل الايميل
$config = ToObject(array(
    'smtp_or_mail'=>'smtp',
    'smtp_host'=>'smtp.gmail.com',
    'smtp_username'=>'yemenbus.2021@gmail.com',
    'smtp_password'=>'yemenbus.2021@@',
    'smtp_encryption'=>'tls',
    'smtp_port'=>'587'
));

//
$data = array('from_email'=>"" ,
    'from_email'=> $config->smtp_username,
    'from_name'=> 'Yamen Bus' ,
    'to_email'=>'yemenbus1@gmail.com', //الايميل الذي سيتسلم الرسالة
    'to_name'=> "Yamen Bus", 
    'is_html'=>true
);
