<?php

/*
 * What protocol to use?
 * mail, sendmail, smtp
 */
$config['protocol'] = 'smtp';

/*
 * SMTP server address and port
 */
$config['smtp_host'] = 'ssl://smtp.googlemail.com';
$config['smtp_port'] = '465';

/*
 * SMTP username and password.
 */
$config['smtp_user']=EmailAddress;
$config['smtp_pass']=EmailPassword;
         
$config['validate'] = TRUE;
$config['mailtype'] = 'html';
$config['smtp_timeout']='60';
$config['charset']='utf-8';
$config['newline']="\r\n";
$config['wordwrap'] = TRUE;

/*
 * Heroku Sendgrid information.
 */
/*
$config['protocol'] = 'smtp';
$config['smtp_host'] = 'smtp.sendgrid.net';
$config['smtp_port'] = 587;
$config['smtp_user'] = $_SERVER['SENDGRID_USERNAME'];
$config['smtp_pass'] = $_SERVER['SENDGRID_PASSWORD'];
*/