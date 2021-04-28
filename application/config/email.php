<?php defined('BASEPATH') OR exit('No direct script access allowed');

$config = array(
    'protocol' => 'smtp', // 'mail', 'sendmail', or 'smtp'
    'smtp_host' => 'smtp.office365.com',
    'smtp_port' => 587,
    'smtp_user' => 'no-reply@emb.gov.ph',
    'smtp_pass' => '3mb_m@1lr7',
        // 'starttls' => TRUE,
    'smtp_crypto' => 'tls', //can be 'ssl' or 'tls' for example$config['starttls'] = TRUE;
    'mailtype' => 'html', //plaintext 'text' mails or 'html'
    'smtp_timeout' => '4', //in seconds
    'charset' => 'iso-8859-1',
    'wordwrap' => TRUE
);





// $config = Array(
//     'protocol' => 'smtp',
//     'smtp_host' => 'ssl://smtp.googlemail.com',
//     'smtp_port' => 465,
//     'smtp_user' => 'xxx',
//     'smtp_pass' => 'xxx',
//     'mailtype'  => 'html',
//     'charset'   => 'iso-8859-1'
// );

// $config2 = array(
//   'protocol' => 'smtp', // 'mail', 'sendmail', or 'smtp'
//   'smtp_host' => 'ssl://smtp.gmail.com',
//   'smtp_port' => '465',
//   'smtp_timeout' => '7',
//   'smtp_user' => 'crs.emb.2020@gmail.com',
//   'smtp_pass' => 'emb7stephen',
//   'mailtype' => 'html', //plaintext 'text' mails or 'html'
//   'validation' => TRUE,
//   'wordwrap' => TRUE
// );

?>
