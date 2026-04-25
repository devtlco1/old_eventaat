<?php
namespace App;

use App\Http\Controllers\Controller;
use PHPMailer\PHPMailer\PHPMailer;

class Functions extends Controller{

    static function sendNotification($serverKey, $FcmToken, $msgText, $alarmId)
    {
        $url = 'https://fcm.googleapis.com/v1/projects/amjad-a610c/messages:send';
        $headers = [
            'Authorization: Bearer ' . $serverKey,
            'Content-Type: application/json',
        ];

        $data = [
            "message" => [
                "token" => $FcmToken,
                "notification" => [
                    "title" => "إنتبه",
                    "body" => (string)$msgText,
                ],
                "data" => [
                    "msg" => (string)$msgText,
                    "alarmId" => (string)$alarmId,
                    "sound" => "default"
                ]
            ]
        ];
        $encodedData = json_encode($data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
        $result = curl_exec($ch);
dd($result);
        if ($result === false) {
            Log::error('Curl error: ' . curl_error($ch));
        }

        curl_close($ch);
        return $result;
    }


    function sendEMail($card,$email){

        $msg= str_replace("@guest",$card->EmailTemplate::findOrFail(1)->text);

        $msg = wordwrap($msg,70);

        $mail = new PHPMailer;
        $mail->CharSet = 'UTF-8';
        $mail->isSMTP();
        $mail->SMTPDebug = 0;
        $mail->SMTPSecure = "ssl";
        $mail->Host = 'box5251.bluehost.com';
        $mail->Port = 465;
        $mail->SMTPAuth = true;
        $mail->Username = 'noreply@trd-co.com';
        $mail->Password = 'I0}93Zch=dOF';
        $mail->Authentication = 'I0}93Zch=dOF';
        $mail->setFrom('noreply@trd-co.com');
        $mail->addReplyTo('noreply@trd-co.com');
        $mail->addAddress($email, $email);
        $mail->Subject = 'TRD-Co';
        $mail->msgHTML($msg);
        $mail->send();
        // return back();
        // if (!$mail->send()) {
        //     return 'Mailer Error: ' . $mail->ErrorInfo;
        //     // echo 'Mailer Error: ' . $mail->ErrorInfo;
        // } else {
        //     // echo 'done';
        //     return 'The email message was sent.';
        // }
    }

    static function sendWhatsApp($mobile,$msg){
        $mobile = intval($mobile);
        $data = '{"message_body":"'.$msg.'","phone_number":"'.$mobile.'"}';

        $authorization = "Authorization: Bearer Yyctisbi2ZmlhLJufs27qUvbivsN5jP6rkgS9nSCkC35JVgtyjLwezLU6v3opCCX";

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://wapp.dishalive.com/api/addc1e99-93a4-4858-986c-ed544815a775/contact/send-message');
        curl_setopt($curl, CURLOPT_POST, true );
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSLVERSION, 3);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 20);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));

        $data2 = curl_exec($curl);
        if(curl_errno($curl)){
            echo 'Curl error: ' . curl_error($curl);
        }
        curl_close($curl);
        return $data2;
    }

}

?>
