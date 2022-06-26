<?php
function ToObject($array) {
    $object = new stdClass();
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            $value = ToObject($value);
        }
        if (isset($value)) {
            $object->$key = $value;
        }
    }
    return $object;
}
function NewMail($data = array()){
	global $mail,$config;
    $email_from      = $data['from_email'] = $data['from_email'];
    $to_email        = $data['to_email'] = $data['to_email'];
    $subject         = $data['subject'];
    $data['charSet'] = 'utf-8';
    
    if ($config->smtp_or_mail == 'mail') {
        $mail->IsMail();
    } 

    else if ($config->smtp_or_mail == 'smtp') {
        $mail->isSMTP();
        $mail->Host        = $config->smtp_host;
        $mail->SMTPAuth    = true;
        $mail->Username    = $config->smtp_username;
        $mail->Password    = $config->smtp_password;
        $mail->SMTPSecure  = $config->smtp_encryption;
        $mail->Port        = $config->smtp_port;
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
    } 

    else {
        return false;
    }

    $mail->IsHTML($data['is_html']);
    $mail->setFrom($email_from, $data['from_name']);
    $mail->addAddress($to_email, $data['to_name']);
    $mail->Subject = $subject;
    $mail->CharSet = $data['charSet'];
    $mail->MsgHTML($data['message_body']);
    if ($mail->send()) {
        $mail->ClearAddresses();
        return true;
	}
	return false;
}