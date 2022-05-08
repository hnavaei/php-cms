<?php
require_once "PHPMailer-master/PHPMailer.php";
require_once "PHPMailer-master/SMTP.php";
require_once "PHPMailer-master/Exception.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

date_default_timezone_set("Asia/Tehran");

function sanitize($inp)
{
    return html_entity_decode(strip_tags(trim($inp)));
}

function calender($day)
{
    $arr = array(
        0 => "یکشنبه",
        1 => "دوشنبه",
        2 => "سه شنبه",
        3 => "چهارشنبه",
        4 => "پنجشنبه",
        5 => "جمعه",
        6 => "شنبه",
    );
    $days = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];

    $current_day = $arr[date("w")];
    if ($current_day == $day) {
        for ($i = 0; $i < 6; $i++) {
            $date[] = jdate(' J F Y', strtotime('+' . 7 * $i . ' day'));
        }
    } else {
        $first_day = jmktime(12, 0, 0, jdate("m", strtotime("next " . $days[array_search($day, $arr)] . "")), jdate("d", strtotime("next " . $days[array_search($day, $arr)] . "")), jdate("Y", strtotime("next " . $days[array_search($day, $arr)] . "")));
        for ($i = 0; $i < 6; $i++) {
            $date[jdate('Y-m-d', strtotime('+' . 7 * $i . ' day', $first_day))] = jdate(' J F Y', strtotime('+' . 7 * $i . ' day', $first_day));
        }
    }
    return $date;
}

function isSendEmail($username, $code)
{
    $mail = new PHPMailer(true);
    try {
        $mail->SMTPDebug = 0;
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->isSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = true;
        $mail->Username = 'nvihani79@gmail.com';
        $mail->Password = '**********';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        $mail->setFrom('nvihani79@gmail.com', 'hnavaei');
        $mail->addAddress($username);
        $mail->isHTML(true);
        $mail->CharSet = "utf-8";
        $mail->ContentType = "text/html;charset=utf-8";
        $mail->Subject = 'رمز عبور کاربر';
        $mail->Body = '<div>
      <div class="text">
       <h2 class="alert-heading">کاربر گرامی اطلاعات شما با موفقیت ثبت شد!</h2>
                <p>رمز عبور :<b>' . $code . '</b></p> 
      </div>
</div>';
        $mail->AltBody = 'کد تایید :<b>' . $code . '';
        $mail->send();
        $mail->SmtpClose();
        return true;

    } catch (Exception $e) {
        return false;
    }

}