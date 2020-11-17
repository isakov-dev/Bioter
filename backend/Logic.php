<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'Exception.php';
require 'PHPMailer.php';
require 'reCaptcha.php';


class Logic {

    public static function SendForm($data) {

        $reCaptcha = new ReCaptcha('6LcV2OMZAAAAADMIoXpm9FCx9pRcWVoeQm47AN2Q');
        $verify = $reCaptcha->verifyResponse($_SERVER['REMOTE_ADDR'], $data['reCaptchaToken']);

        if ($verify->success=='false'|| floatval($verify->score) < 0.5) {

            http_response_code(403);
            return array('success' => false);

        } else {

            // Instantiation and passing `true` enables exceptions
            $mail = new PHPMailer(true);

            try {

                $mail->CharSet = "utf-8";
                $mail->setFrom('mail@bioter.tmweb.ru', 'Bioter');
                $mail->addAddress('isakov.n@digitalaround.ru');
                $mail->isHTML(true);
                $mail->Subject = 'Заявка с Биотэр';

                $mailBody = "Имя: {$data['name']}<br>Телефон: {$data['phone']}";
                if ($data['company'])
                    $mailBody .= "<br>Компания: {$data['company']}";
                $mail->Body = $mailBody;

                $mail->send();
                return array('success' => true);

            } catch (Exception $e) {
                http_response_code(500);
                return array('success' => false);
            }

        }

    }

}