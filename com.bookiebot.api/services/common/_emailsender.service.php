<?php

if(!defined('APP')) {
    die();
}

require_once ROOT_DIR."/vendor/phpmailer/phpmailer/PHPMailerAutoload.php";


class _Emailsender extends Service {



    public function sendEmail($subject,$message,$from = "no-reply@bookiebot.com") {
        $mail = new PHPMailer;

        $user_data = $this->loadService("user/session")->checkSession();

        if($user_data['code']!==10) {
            return false;
        }

        $current_user = $user_data['user'];


        $mail->From = $from;
        $mail->FromName = 'BookieBot.Com';

        $mail->addAddress($current_user['email']);
        $mail->isHTML(true);


        $mail->Subject = $subject;
        $mail->Body    = '
            <html>
                <head>
                    <meta charset="utf8" />
                </head>
                <body>
                	<div style="padding:5px;margin-bottom:10px;">
						<img src="https://bookiebot.com/app/templates/default/view/_media/images/logo1-blue.png?1412184445" />
					</div>
					<div style="padding:10px;position:relative;">
						<p style="padding-top:0px">
							Hello Dear, '.$current_user['username'].'
						</p>
							<p style="padding-top:0px">
							'.$message.'
						</p>
					</div>

                </body>
            </html>
        ';

        $sent = $mail->send();
        if(!$sent) {
            var_export($mail->ErrorInfo);
        }

        return $sent;
    }




    public function sendPublicMail($to,$subject,$message,$from = "no-reply@bookiebot.com") {
        $mail = new PHPMailer;

        $mail->setFrom($from, 'Bookiebot');
        $mail->addAddress($to);
        $mail->Subject = $subject;
        $mail->msgHTML('
            <html>
                <head>
                    <meta charset="utf8" />
                </head>
                <body>
                	<div style="padding:5px;margin-bottom:10px;">
						<img src="https://bookiebot.com/app/templates/default/view/_media/images/logo1-blue.png?1412184445" />
					</div>
					<div style="padding:10px;position:relative;">
						<p style="padding-top:0px">
						</p>
							<p style="padding-top:0px">
							'.$message.'
						</p>
					</div>

                </body>
            </html>
        ');

        $sent = $mail->send();
        if(!$sent) {
            var_export($mail->ErrorInfo);
        }

        return $sent;
    }


}