<?php


namespace App\Traits;

use App\Models\Device;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

trait FCMTrait
{


    protected $serverKey = 'gLWr7xOADYRcV03Ok2Tcr4Ft6YEoC4wWN6aS41P-T54';

    public function PushNotification($user_id, array $data)
    {

        $Notification=Notification::create([
            'user_id' => $user_id,
            'registration_id' => 6,
            'message_text' => $data['body'] ??  null ,
            'title' => $data['title'] ??  null ,
            'alarm_id' => 1 ,
            'status' => 'pending' ,
        ]) ;
        $data['notification_id']=$Notification->id ;
        if (is_array($user_id)){
            foreach ($user_id as $user_idItem)
                $Notification->users()->create([
                    'user_id'=>$user_idItem,
                ]);
        }else{
            $Notification->users()->create([
                'user_id'=>$user_id,
            ]);
        }
        $this->FCMNotification($user_id, $data);
        return ;

    }
    public function sendFcmNotification($fcm ,$title , $description)
    {

        if (!$fcm) {
            return response()->json(['message' => 'User does not have a device token'], 400);
        }

        $projectId = "eventaat-iq";

        $credentialsFilePath = Storage::path('json/file.json');
        $client = new \Google_Client();
        $client->setAuthConfig($credentialsFilePath);
        $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
        $client->refreshTokenWithAssertion();
        $token = $client->getAccessToken();

        $access_token = $token['access_token'];

        $headers = [
            "Authorization: Bearer $access_token",
            'Content-Type: application/json'
        ];

        $data = [
            "message" => [
                "token" => $fcm,
                "notification" => [
                    "title" => $title,
                    "body" => $description,
                ],
            ]
        ];
        $payload = json_encode($data);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_VERBOSE, true); // Enable verbose output for debugging
        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
//dd($response);
        if ($err) {
            return response()->json([
                'message' => 'Curl Error: ' . $err
            ], 500);
        } else {
            return response()->json([
                'message' => 'Notification has been sent',
                'response' => json_decode($response, true)
            ]);
        }
    }

}
