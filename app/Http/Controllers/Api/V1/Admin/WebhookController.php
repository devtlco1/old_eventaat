<?php

namespace App\Http\Controllers\Api\V1\Admin;
use App\Http\Controllers\Controller;
use App\Models\LoginModel;
use App\Models\User;
use App\Functions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class WebhookController extends Controller
{
    protected function action(){
            $update = json_decode(file_get_contents('php://input'));
            if (!$update) exit;
            if(!isset($update->message)) exit();
            $message = $update->message->body;
            $contact = $update->contact ?? null;
        
            if ($contact) {
                $name = ($contact->first_name ?? '') . ' ' . ($contact->last_name ?? '');
                $phone_number = $contact->phone_number ?? 'Unknown';
                $country_code = substr($phone_number, 0, 3);
                $mobile = substr($phone_number, 3);
                $email = $contact->email ?? 'Unknown';
                if(empty($email) || $email == "" || $email == null){
                    $email = 'Unknown';
                }
                Log::error('email :: ' . json_encode($email));
                if ($email === 'Unknown') {
                    $baseEmail = 'Unknown';
                    $counter = 1;

                    // Check if the email already exists in the database
                    while (\DB::table('users')->where('email', $email)->exists()) {
                        $email = $baseEmail . '_' . $counter++;
                    }
                }
            } else {
                $name = 'Unknown';
                $mobile = 'Unknown';

                $baseEmail = 'Unknown';
                $email = 'Unknown';
                $counter = 1;

                // Handle "Unknown" email for cases where no contact is available
                while (\DB::table('users')->where('email', $email)->exists()) {
                    $email = $baseEmail . '_' . $counter++;
            }
        }
        
        Log::error('contact :: ' . json_encode($contact));
        
        $code = trim(explode(":",$message)[1]);
        if(str_contains($message, "login with code:")) return $this->login($name,$code,$country_code,$mobile,$email);

        return true;
    }


    public function login($name,$code,$country_code,$mobile,$email){
        $login = LoginModel::where("auth_code",'=',$code)->first();
        if(!$login) return false;

        $user = User::where('mobile','=',$mobile)->first();

        if(!$user){
            $user = User::create([
                'mobile'=>$mobile,
                'country_code'=>$country_code,
                'name'=>$name,
                'email'=>$email,
                'active'=> 1,
                'fcm_token'=>$login->fcm_token
            ]);


            Functions::sendWhatsApp($mobile,"Your account has been created successfully, back to Eventaat app and enjoy.");
        }else{
            $user->update([
                'name'=>$name,
                'country_code'=>$country_code,
                'email'=>$email,
                'active'=>1,
                'fcm_token'=>$login->fcm_token
            ]);
            Functions::sendWhatsApp($mobile,"Welcome Back. You become in, back to Eventaat app and enjoy.");
        }

        $login->update([
            "user_id"=>$user->id
        ]);
        return true;
    }

}
