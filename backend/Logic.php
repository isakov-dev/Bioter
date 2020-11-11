<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'Exception.php';
require 'PHPMailer.php';


class Logic {

    public static function SendForm($data) {

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
            return array('success' => false);
        }

    }

}