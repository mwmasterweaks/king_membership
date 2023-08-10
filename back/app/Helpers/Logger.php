<?php

namespace App\Helpers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Logger
{
    public function log($date, $userID, $ControllerName, $functionName, $logType, $message)
    {
        $filenameDate = date("mY");
        $myfile = fopen("logs/log" . $filenameDate . ".txt", "a") or die("Unable to open file!");
        $txt = $date . "\t--\t" . $userID . "\t--\t" .  "\t--\t" . $ControllerName .
            "\t--\t" . $functionName . "\t--\t" . $logType . "\t--\t" . $message . "\r\n\r\n";
        fwrite($myfile, $txt);
        fclose($myfile);
        return "ok";
    }

    public function logError($date, $userID, $ControllerName, $functionName, $logType, $message)
    {
        $filenameDate = date("mY");
        $myfile = fopen("logs/Errorlog" . $filenameDate . ".txt", "a") or die("Unable to open file!");
        $txt = $date . "\t--\t" . $userID . "\t--\t" . "\t--\t" . $ControllerName .
            "\t--\t" . $functionName . "\t--\t" . $logType . "\t--\t" . $message . "\r\n\r\n";
        fwrite($myfile, $txt);
        fclose($myfile);
        return "ok";
    }

    public function mailer($subject, $message, $sender, $senderName, $sendTo, $recipient)
    {


        // // Server settings
        // // $mail->SMTPDebug = 0;
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        // $mail->isSMTP();

        // $mail->Host = 'smtp.gmail.com';
        // $mail->SMTPAuth = true;
        // $mail->Username = 'kingmcoop@gmail.com';
        // $mail->Password = 'kingmcoop123';
        // $mail->SMTPSecure = 'tls';
        // $mail->Port = 25;
        // $mail->CharSet = 'utf-8';
        // $mail->SMTPOptions = array(
        //     'ssl' => array(
        //         'verify_peer' => false,
        //         'verify_peer_name' => false,
        //         'allow_self_signed' => true
        //     )
        // );

        // $mail->setFrom('micemorta@gmail.com', $senderName . " " . $sender);
        // $mail->addAddress($sendTo, $recipient);


        // $mail->isHTML(true);                                                                     // Set email format to HTML
        // $mail->Subject = $subject;
        // $mail->Body    = $message;
        // $mail->send();
        $mail = new PHPMailer(true);
        $mail->isSMTP(); // tell to use smtp
        $mail->CharSet = "utf-8"; // set charset to utf8
        $mail->SMTPAuth = true;  // use smpt auth
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->SMTPSecure = "tls"; // or ssl
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587; // most likely something different for you. This is the mailtrap.io port i use for testing.
        $mail->Username = "kingmcoop@gmail.com";
        $mail->Password = "kingmcoop123";
        $mail->setFrom("kingmcoop@gmail.com", "King Multipurpose Cooperative");
        $mail->Subject = "Test";
        $mail->MsgHTML("This is a test");
        $mail->addAddress("micedianne@gmail.com", "Test Applicant");
        $mail->send();
    }

    public function mailerGmail($subject, $message, $sender, $senderName, $sendTo, $recipient, $CCTO = [], $BCC = [], $ReplyTo = [], $attachment = null)
    {
        //$admin_email = 'jay.boco.kmpc@gmail.com';
        //$admin_name = 'jay.boco.kmpc';


        $mail = new PHPMailer();
        // Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->isSMTP();

        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPSecure = "tls";
        $mail->SMTPAuth = true;
        $mail->Username = 'kingmpc.marketing@gmail.com';
        $mail->Password = 'flsvmmnulkzlqxkt';


        $mail->setFrom('kingmcoop@gmail.com', $senderName . " " . $sender);
        $mail->addAddress($sendTo, $recipient);
        if ($CCTO != null)
            if (is_array($CCTO)) {
                foreach ($CCTO as $item) {
                    $item = (object) $item;
                    $mail->addCC($item->email, $item->name);
                }
            } else
                $mail->addCC($CCTO);
        if ($BCC != null)
            if (is_array($BCC)) {
                foreach ($BCC as $item) {
                    $item = (object) $item;
                    $mail->addBCC($item->email);
                }
            } else
                $mail->addCC($BCC);

        if ($ReplyTo != null)
            if (is_array($ReplyTo)) {
                foreach ($ReplyTo as $item) {
                    $item = (object) $item;
                    $mail->addReplyTo($item->email);
                }
            } else
                $mail->addCC($ReplyTo);
        if ($attachment != null)
            $mail->addAttachment($attachment);
        $mail->isHTML(true);                                                                     // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $message;

        if (!$mail->send()) {
            return 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            return 'Message sent!';
        }
    }

    public function send_text($number, $message)
    {
        // $username = 'TR-KINGM282651_7QR1M';
        // $password = '@bresg)du9';

        // $ch = curl_init();
        // $itexmo = array('1' => $number, '2' => $message, '3' => $apicode, 'passwd' => $passwd);
        // curl_setopt($ch, CURLOPT_URL, "https://www.itexmo.com/php_api/api.php");
        // curl_setopt($ch, CURLOPT_POST, 1);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($itexmo));
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // return curl_exec($ch);
        // curl_close($ch);

        $user = "jboco@kingmpc.com";
        $pass = "P4ssw0rd";

        $smsgatewaydata = "https://messagingsuite.smart.com.ph/cgphttp/servlet/sendmsg?" .
            http_build_query([
                'username' => $user,
                'password' => $pass,
                'destination' => $number,
                'text' => $message
            ]);

        //"username=" . $user . "&password=" . $pass . "&destination= " . $number . "&text=" . urlencode($message);
        $url = $smsgatewaydata;
        //7d6190ad6afde3a9f45683d9600d5dc8
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $ret = curl_exec($ch); //get error
        curl_close($ch);

        if (!$ret) {
            return file_get_contents($smsgatewaydata);
        } else {
            return $ret;
        }


        // https://messagingsuite.smart.com.ph/cgphttp/servlet/sendmsg?username=jboco@kingmpc.com&password=P4ssw0rd&destination=09092104014&text=initial+test+message
    }

    public static function instance()
    {
        return new Logger();
    }
}
