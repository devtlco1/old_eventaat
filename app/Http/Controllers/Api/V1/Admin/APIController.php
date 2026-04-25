<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Functions;
use App\Http\Controllers\Controller;
use App\Mail\Register;
use App\Models\Booking;
use App\Models\City;
use App\Models\Event;
use App\Models\Favorite;
use App\Models\Feature;
use App\Models\KitchenType;
use App\Models\LoginModel;

use App\Models\Notification;
use App\Models\Offer;
use App\Models\Pag;
use App\Models\Privacy;
use App\Models\Restaurant;
use App\Models\Story;
use App\Models\Team;
use App\Models\User;
use App\Models\Contact;
use App\Traits\FCMTrait;
use App\Traits\HelperTrait;
use Carbon\Carbon;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;
use App\Services\FirebaseService;
use Google\Auth\Credentials\ServiceAccountCredentials;

class APIController extends Controller
{
    // login not using a provider
    use  HelperTrait , FCMTrait;
    public function __construct(FirebaseService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }
    public function prepareLogin(Request $request){
        $code = $this->getLoginToken();
        LoginModel::create([
            'fcm_token'=>$_POST['token'],
            'auth_code'=>$code,
        ]);
        return $this->returnSuccessWithData('success' , $code);
    }

    public function Registration(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'lat' => 'nullable|numeric',
            'lng' => 'nullable|numeric',
            'gender' => 'required',
            'city_id' => 'required|exists:cities,id',
            'country_code' => 'required|string|max:10',
            'mobile' => 'required|numeric|unique:users,mobile',
        ]);
        $user = new User();
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->password = bcrypt($validatedData['password']);
        $user->lat = $validatedData['lat'];
        $user->lng = $validatedData['lng'];
        $user->gender = $validatedData['gender'];
        $user->city_id = $validatedData['city_id'];
        $user->country_code = $validatedData['country_code'];
        $user->mobile = $validatedData['mobile'];
        $user->active = false;
//        $user->roles()->attach($validatedData['role_id']);
        $user->save();
        Contact::create([
            'position' => $user->name,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->country_code . $user->mobile
        ]);
        $user->roles()->attach(2);
        $token = $user->createToken('AuthToken')->plainTextToken;
        $user->token = $token;
        $user->load(['city','roles']);
        return  $this->returnSuccessWithData('Successful Registration' , $user);
    }

    public function login(Request $request){
        $record = LoginModel::where('fcm_token', $_POST['token'])
            ->where('auth_code','=',$_POST['otp_code'])
            ->whereNotNull("user_id")->first();

        if (!$record) {
            return $this->returnError('fail');
        }
        $user = User::findOrFail($record->user_id);
        $user->active = true;
        $user->save();
        Contact::create([
            'position' => $user->name,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->country_code . $user->mobile
        ]);
        $user->roles()->attach(2);
        $record->delete();
        $data  =  $this->getUserAndToken($user);
        $token = $user->fcm_token;
        $title = "تسجيل الدخول بنجاح";
        $body = "مرحباً، لقد قمت بتسجيل الدخول بنجاح.";
        $this->sendFcmNotification($token ,$title,$body);
        Notification::create([
            'user_id' => $user->id,
            'registration_id' => $user->fcm_token,
            'title' => $title,
            'message_text' => $body,
            'alarm_id' => 1,
            'status' => "pending",
        ]);
        return $this->returnSuccessWithData('Successful Login' ,$data);
    }
    public function loginNew(Request $request){
        $validatedData = $request->validate([
            'country_code' => 'required|string|max:5',
            'mobile' => 'required|string|min:7|max:15',
            'password' => 'required|min:8',
        ]);
        if (Auth::attempt(['mobile' => $validatedData['mobile'] ,'country_code'=>$validatedData['country_code'], 'password' => $validatedData['password']])) {
            $user = Auth::user();
            if ($request->has('fcm_token') && !empty($request->fcm_token)) {
                $user->fcm_token = $request->fcm_token;
            }
            $user->save();
            $token = $user->createToken('AuthToken')->plainTextToken;
            $user->token = $token;
            $user->load(['city','roles']);

           $token = $user->fcm_token;
           $title = "تسجيل الدخول بنجاح";
           $body = "مرحباً، لقد قمت بتسجيل الدخول بنجاح.";
           $this->sendFcmNotification($token ,$title,$body);
            Notification::create([
                'user_id' => $user->id,
                'registration_id' => $user->fcm_token,
                'title' => $title,
                'message_text' => $body,
                'alarm_id' => 1,
                'status' => "pending",
            ]);
            return  $this->returnSuccessWithData('Login successful' ,$user);
        }else {
            return  $this->returnError('Invalid country_code or mobile number or password');
        }
    }
    public function getMyProfile(){
        $user = User::where('id','=', Auth::user()->id)->with(['restaurants','city','roles'])->first();
        return  $this->returnSuccessWithData('Successful Get Profile' , $user);
    }
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $updateData = [];
        if ($request->has('country_code') && !empty($request->country_code)) {
            $updateData['country_code'] = $request->country_code;
        }
        if ($request->has('mobile') && !empty($request->mobile)) {
            $updateData['mobile'] = $request->mobile;
        }

        if ($request->has('name') && !empty($request->name)) {
            $updateData['name'] = $request->name;
        }

        if ($request->has('email') && !empty($request->email)) {
            $updateData['email'] = $request->email;
        }

        if ($request->has('lat') && !empty($request->lat)) {
            $updateData['lat'] = $request->lat;
        }

        if ($request->has('lng')&& !empty($request->lng)) {
            $updateData['lng'] = $request->lng;
        }

        if ($request->has('city_id')&& !empty($request->city_id)) {
            $updateData['city_id'] = $request->city_id;
        }

        if ($request->has('gender')&& !empty($request->gender)) {
            $updateData['gender'] = $request->gender;
        }
        if ($request->has('password')&& !empty($request->password)) {
            $updateData['password'] = Hash::make($request->password);
        }
        $user->update($updateData);
        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $ext = $file->getClientOriginalExtension();
            $newname = "user_" . $user->id . "." . $ext;
            $target = storage_path('tmp/uploads/' . $newname);
            $file->move(storage_path('tmp/uploads/'), $newname);
            $user->addMedia($target)->toMediaCollection('user_image');
        }
        return  $this->returnSuccessWithData('Successful Update Profile' , $user);
    }
    public function getCityList(){
        return $this->returnSuccessWithData('Successful Get City List' , City::all());
    }
    public function getStories(){
        $Stores = Story::whereDate('created_at','>',now()->subHours(24))->with(['restaurant'])->get();
        return $this->returnSuccessWithData('Success Get Stores', $Stores);
    }

    public function createStory(){
//        $user = Auth::user();
//        $user->load('roles');
        $story = Story::create([
            'restaurant_id'=>$_POST["restaurant_id"],
            'title'=>$_POST["title"],
        ]);
        if(!empty($_FILES)) {
            for ($i = 0; $i < count($_FILES); $i++) {
                $info = pathinfo($_FILES['img'.$i]['name']);
                $ext = $info['extension']; // get the extension of the file
                $newname = "story_".$story->id."_".$i.".".$ext;
                $target = storage_path('tmp/uploads/'.$newname);
                move_uploaded_file( $_FILES['img'.$i]['tmp_name'], $target);
                $story->addMedia($target)->toMediaCollection('images');
            }
        }
        return $this->returnSuccessWithData('Success Create Story', $story);
    }

    public function updateStory($id){
        $story = Story::findOrFail($id);
        $story->update([
            'restaurant_id' => $_POST["restaurant_id"],
            'title' => $_POST["title"],
        ]);
        if (!empty($_FILES)) {
            for ($i = 0; $i < count($_FILES); $i++) {
                $info = pathinfo($_FILES['img'.$i]['name']);
                $ext = $info['extension'];
                $newname = "story_".$story->id."_".$i.".".$ext;
                $target = storage_path('tmp/uploads/'.$newname);
                move_uploaded_file($_FILES['img'.$i]['tmp_name'], $target);
                $story->addMedia($target)->toMediaCollection('images');
            }
        }
        return $this->returnSuccessWithData('Success Update Story', $story);
    }

    public function deleteStory(){
        $story = Story::findOrFail($_POST["story_id"]);
        $story->delete();
        return $this->returnSuccess('Success Delete Story');
    }

    public function getRestaurantList()
    {
        // جلب جميع المطاعم
        $restaurants = Restaurant::all();

        foreach ($restaurants as $restaurant) {
            // فك JSON للحصول على قائمة الخصوصيات
            $privacyIds = json_decode($restaurant->privacies_id, true); // تحويل النص إلى مصفوفة
            $kitchenTypeIds = json_decode($restaurant->kitchen_types_id, true); // تحويل النص إلى مصفوفة
            $featureIds = json_decode($restaurant->features_id, true); // تحويل النص إلى مصفوفة

            // تحقق من أن الخصوصيات عبارة عن مصفوفة قبل جلب البيانات
            if (is_array($privacyIds)) {
                $privacies = [];
                foreach ($privacyIds as $privacyId) {
                    $privacies[] = Privacy::find($privacyId);
                }
                $restaurant->privacies = $privacies;
            } else {
                $restaurant->privacies = [];
            }

            // تحقق من أن kitchen_types عبارة عن مصفوفة قبل جلب البيانات
            if (is_array($kitchenTypeIds)) {
                $kitchen = [];
                foreach ($kitchenTypeIds as $kitchenTypeId) {
                    $kitchen[] = KitchenType::find($kitchenTypeId);
                }
                $restaurant->kitchen_types = $kitchen;
            } else {
                $restaurant->kitchen_types = [];
            }

            // تحقق من أن features عبارة عن مصفوفة قبل جلب البيانات
            if (is_array($featureIds)) {
                $features = [];
                foreach ($featureIds as $featureId) {
                    $features[] = Feature::find($featureId);
                }
                $restaurant->features = $features;
            } else {
                $restaurant->features = [];
            }
        }

        return $this->returnSuccessWithData('Success Get All Restaurants', $restaurants);
    }



    public function getCityRestaurantList(){
        $restaurants = Restaurant::where('city_id',$_POST["city_id"])->get();
        foreach ($restaurants as $restaurant) {
            // فك JSON للحصول على قائمة الخصوصيات
            $privacyIds = json_decode($restaurant->privacies_id, true); // تحويل النص إلى مصفوفة
            $kitchenTypeIds = json_decode($restaurant->kitchen_types_id, true); // تحويل النص إلى مصفوفة
            $featureIds = json_decode($restaurant->features_id, true); // تحويل النص إلى مصفوفة

            // تحقق من أن الخصوصيات عبارة عن مصفوفة قبل جلب البيانات
            if (is_array($privacyIds)) {
                $privacies = [];
                foreach ($privacyIds as $privacyId) {
                    $privacies[] = Privacy::find($privacyId);
                }
                $restaurant->privacies = $privacies;
            } else {
                $restaurant->privacies = [];
            }

            // تحقق من أن kitchen_types عبارة عن مصفوفة قبل جلب البيانات
            if (is_array($kitchenTypeIds)) {
                $kitchen = [];
                foreach ($kitchenTypeIds as $kitchenTypeId) {
                    $kitchen[] = KitchenType::find($kitchenTypeId);
                }
                $restaurant->kitchen_types = $kitchen;
            } else {
                $restaurant->kitchen_types = [];
            }

            // تحقق من أن features عبارة عن مصفوفة قبل جلب البيانات
            if (is_array($featureIds)) {
                $features = [];
                foreach ($featureIds as $featureId) {
                    $features[] = Feature::find($featureId);
                }
                $restaurant->features = $features;
            } else {
                $restaurant->features = [];
            }
        }
        return $this->returnSuccessWithData('Success Get All Restaurants From city', $restaurants);
    }

    public function getRestaurantDetails(){
        $restaurantId = request('restaurant_id');
//        $rest = Restaurant::where('id', '=', $restaurantId)
//            ->with(['events', 'city', 'stories', 'offers', 'contacts', 'user', 'chain'])
//            ->first();
//        if (!$rest) {
//            return $this->returnError('Restaurant not found', 404);
//        }
//        $privacy = Privacy::all();
//        $kitchentypes = KitchenType::all();
//        $features = Feature::all();
//        $rest->Privacy = $privacy;
//        $rest->Kitchentypes = $kitchentypes;
//        $rest->features = $features;





        $restaurants = Restaurant::where('id', $restaurantId)
            ->with(['events', 'city', 'stories', 'offers', 'contacts', 'user', 'chain'])
            ->get();
        foreach ($restaurants as $restaurant) {
            // فك JSON للحصول على قائمة الخصوصيات
            $privacyIds = json_decode($restaurant->privacies_id, true); // تحويل النص إلى مصفوفة
            $kitchenTypeIds = json_decode($restaurant->kitchen_types_id, true); // تحويل النص إلى مصفوفة
            $featureIds = json_decode($restaurant->features_id, true); // تحويل النص إلى مصفوفة

            // تحقق من أن الخصوصيات عبارة عن مصفوفة قبل جلب البيانات
            if (is_array($privacyIds)) {
                $privacies = [];
                foreach ($privacyIds as $privacyId) {
                    $privacies[] = Privacy::find($privacyId);
                }
                $restaurant->privacies = $privacies;
            } else {
                $restaurant->privacies = [];
            }

            // تحقق من أن kitchen_types عبارة عن مصفوفة قبل جلب البيانات
            if (is_array($kitchenTypeIds)) {
                $kitchen = [];
                foreach ($kitchenTypeIds as $kitchenTypeId) {
                    $kitchen[] = KitchenType::find($kitchenTypeId);
                }
                $restaurant->kitchen_types = $kitchen;
            } else {
                $restaurant->kitchen_types = [];
            }

            // تحقق من أن features عبارة عن مصفوفة قبل جلب البيانات
            if (is_array($featureIds)) {
                $features = [];
                foreach ($featureIds as $featureId) {
                    $features[] = Feature::find($featureId);
                }
                $restaurant->features = $features;
            } else {
                $restaurant->features = [];
            }
        }
        return $this->returnSuccessWithData('Success Get Restaurant Details', $restaurants);
    }
    public function getPages(){
        $pages = Pag::all();
        return $this->returnSuccessWithData('Success Get Pages', $pages);
    }
    public function getOffers(){
        $offers = Offer::whereDate('ending_at', '>',date('Y-m-d H:i:s'))->with(['restaurant'])->get();
        return $this->returnSuccessWithData('Success Get All Offers', $offers);
    }
    public function getEvents(){
        $events = Event::whereDate('ending_at','>',now())->with(['restaurant', 'eventBookings', 'privacy', 'features'])->get();
        foreach ($events as $event) {
                // فك JSON للحصول على قائمة الخصوصيات
                $privacyIds = json_decode($event->restaurant->privacies_id, true); // تحويل النص إلى مصفوفة
                $kitchenTypeIds = json_decode($event->restaurant->kitchen_types_id, true); // تحويل النص إلى مصفوفة
                $featureIds = json_decode($event->restaurant->features_id, true); // تحويل النص إلى مصفوفة

                // تحقق من أن الخصوصيات عبارة عن مصفوفة قبل جلب البيانات
                if (is_array($privacyIds)) {
                    $privacies = [];
                    foreach ($privacyIds as $privacyId) {
                        $privacies[] = Privacy::find($privacyId);
                    }
                    $event->restaurant->privacies = $privacies;
                } else {
                    $event->restaurant->privacies = [];
                }

                // تحقق من أن kitchen_types عبارة عن مصفوفة قبل جلب البيانات
                if (is_array($kitchenTypeIds)) {
                    $kitchen = [];
                    foreach ($kitchenTypeIds as $kitchenTypeId) {
                        $kitchen[] = KitchenType::find($kitchenTypeId);
                    }
                    $event->restaurant->kitchen_types = $kitchen;
                } else {
                    $event->restaurant->kitchen_types = [];
                }

                // تحقق من أن features عبارة عن مصفوفة قبل جلب البيانات
                if (is_array($featureIds)) {
                    $features = [];
                    foreach ($featureIds as $featureId) {
                        $features[] = Feature::find($featureId);
                    }
                    $event->restaurant->features = $features;
                } else {
                    $event->restaurant->features = [];
                }
        }

        return $this->returnSuccessWithData('Success Get All Events', $event);
    }
    public function getEventById(){
        if (empty($_POST['event_id'])){
            return $this->returnError('Event id is required');
        }
        $event = Event::with(['restaurant', 'eventBookings', 'privacy', 'features'])
            ->find($_POST['event_id']);
        if (empty($event)){
            return $this->returnError('Event not found');
        }
        return $this->returnSuccessWithData('Success Get Event', $event);
    }
    public function toggleFavorite(Request $request)
    {
        $userId = Auth::id();
        $restaurantId = $request->input('restaurant_id');
        $favorite = Favorite::where('user_id', $userId)->where('restaurant_id', $restaurantId)->first();
        if ($favorite) {
            $favorite->delete();
            return $this->returnSuccess('Success Removed from favorites');
        } else {
            Favorite::create([
                'user_id' => $userId,
                'restaurant_id' => $restaurantId,
            ]);
            return $this->returnSuccess('Success Added to favorites');
        }
    }
    public function getFavorites()
    {
        $userId = Auth::id();
        $favorites = Favorite::where('user_id', $userId)
            ->with('restaurant')
            ->get();
        return $this->returnSuccessWithData('Success Get All favorites' , $favorites);
    }
    public function getMyRestaurants(){
        // جلب جميع المطاعم
        $restaurants = Auth::user()->restaurants;
        foreach ($restaurants as $restaurant) {
            // فك JSON للحصول على قائمة الخصوصيات
            $privacyIds = json_decode($restaurant->privacies_id, true); // تحويل النص إلى مصفوفة
            $kitchenTypeIds = json_decode($restaurant->kitchen_types_id, true); // تحويل النص إلى مصفوفة
            $featureIds = json_decode($restaurant->features_id, true); // تحويل النص إلى مصفوفة

            // تحقق من أن الخصوصيات عبارة عن مصفوفة قبل جلب البيانات
            if (is_array($privacyIds)) {
                $privacies = [];
                foreach ($privacyIds as $privacyId) {
                    $privacies[] = Privacy::find($privacyId);
                }
                $restaurant->privacies = $privacies;
            } else {
                $restaurant->privacies = [];
            }

            // تحقق من أن kitchen_types عبارة عن مصفوفة قبل جلب البيانات
            if (is_array($kitchenTypeIds)) {
                $kitchen = [];
                foreach ($kitchenTypeIds as $kitchenTypeId) {
                    $kitchen[] = KitchenType::find($kitchenTypeId);
                }
                $restaurant->kitchen_types = $kitchen;
            } else {
                $restaurant->kitchen_types = [];
            }

            // تحقق من أن features عبارة عن مصفوفة قبل جلب البيانات
            if (is_array($featureIds)) {
                $features = [];
                foreach ($featureIds as $featureId) {
                    $features[] = Feature::find($featureId);
                }
                $restaurant->features = $features;
            } else {
                $restaurant->features = [];
            }
        }
        return $this->returnSuccessWithData('Success Get All restaurants from User' ,$restaurants);
    }

    public function createAnEvent(Request $request){
        $request->merge(['seats' => $request->input('seats', 0)]);
        $validatedData = $request->validate([
            'restaurant_id' => 'required|integer|exists:restaurents,id',
            'title' => 'required|string|max:255',
            'free' => 'required|numeric|in:1,0',
            'price' => 'required_if:free,1|nullable|numeric|min:0',
            'starting_at' => 'required|date|after_or_equal:today',
            'ending_at' => 'required|date|after:starting_at',
            'discreption' => 'nullable|string|max:500',
            'numberChildren' => 'nullable|numeric|min:0',
            'seats' => 'required|integer|min:0',
        ]);

        $event = Event::create($validatedData);
        $event->features()->sync( json_decode($_POST['features']) , []);

        if(!empty($_FILES)) {
            for ($i = 0; $i < count($_FILES); $i++) {
                $info = pathinfo($_FILES['img'.$i]['name']);
                $ext = $info['extension']; // get the extension of the file
                $newname = "event_".$event->id."_".$i.".".$ext;
                $target = storage_path('tmp/uploads/'.$newname);
                move_uploaded_file( $_FILES['img'.$i]['tmp_name'], $target);
                $event->addMedia($target)->toMediaCollection('images');
            }
        }

        return $this->returnSuccessWithData('Success Create Event', $event);
    }

    public function updateAnEvent(Request $request)
    {
        $validatedData = $request->validate([
            'event_id' => 'required|integer|exists:events,id',
            'restaurant_id' => 'required|integer|exists:restaurents,id',
            'title' => 'required|string|max:255',
            'free' => 'required|numeric|in:1,0',
            'price' => 'required_if:free,1|nullable|numeric|min:0',
            'starting_at' => 'required|date|after_or_equal:today',
            'ending_at' => 'required|date|after:starting_at',
            'discreption' => 'nullable|string|max:500',
            'numberChildren' => 'nullable|numeric|min:0',
            'seats' => 'required|integer|min:0',
        ]);

        $event = Event::findOrFail($request->input('event_id'));
        if ($event ==null){
            return $this->returnError('Event not found');
        }


        $event->update([
            'restaurant_id' => $validatedData['restaurant_id'],
            'title' => $validatedData['title'],
            'free' => $validatedData['free'],
            'discreption' => $validatedData['discreption'] ?? null,
            'starting_at' => $validatedData['starting_at'],
            'ending_at' => $validatedData['ending_at'],
            'price' => $validatedData['price'] ?? null,
            'numberChildren' => $validatedData['numberChildren'],
            'seats' => $validatedData['seats'],
        ]);

        $event->features()->sync( json_decode($_POST['features']) , []);

        if (count($event->images) > 0) {
            foreach ($event->images as $media) {
                if (! in_array($media->file_name, $_FILES)) {
                    $media->delete();
                }
            }
        }

        if (!empty($_FILES)) {
            foreach ($_FILES as $key => $file) {
                $info = pathinfo($file['name']);
                $ext = $info['extension'];
                $newname = "event_".$event->id."_".$key.".".$ext;
                $target = storage_path('tmp/uploads/'.$newname);

                move_uploaded_file($file['tmp_name'], $target);
                $event->addMedia($target)->toMediaCollection('images');
            }
        }

        return $this->returnSuccessWithData('Success Update Event', $event);
    }
    public function deleteAnEvent(){
        $event = Event::findOrFail($_POST["event_id"]);
        if ($event ==null){
            return $this->returnError('Event not found');
        }
        $event->delete();

        return $this->returnSuccess('Success Delete Event');

    }
    public function getMyBookings(){
        return $this->returnSuccessWithData('Success Get Bookings From User' , Auth::user()->clientBookings);
    }

    public function createBooking(Request $request){
        $request->merge(['status' => $request->input('status', 0)]);
        $validatedData = $request->validate([
            'event_id' => 'nullable|integer|exists:events,id',
            'restaurant_id' => 'nullable|integer|exists:restaurents,id',
            'appointment' => 'required|date|after:today',
            'adult' => 'required|integer|min:1',
            'children' => 'required|integer|min:0',
            'type' => 'required|integer|in:1,2',
            'type1' => 'required|integer|in:1,2',
            'paymentType' => 'required|integer|in:1,2',
        ]);
        $restaurant = Restaurant::where('id' ,$request->input('restaurant_id'))->first();
//        if ($restaurant->numberolder <= 0)
//        {
//
//        }
        $user = Auth::user();
        $customer_number = substr($user->mobile, -3);
        $booking_type = 'N';
        $booking_date = Carbon::parse($request->input('appointment'))->format('dmY');
        $client_name = $customer_number . $booking_type . $booking_date;
        $booking = Booking::create([
            'event_id' => $request->input('event_id'),
            'restaurant_id' => $request->input('restaurant_id'),
            'client_id' => Auth::user()->id,
            'appointment' => $request->input('appointment'),
            'adolt' => $request->input('adult'),
            'children' => $request->input('children', 0),
            'type' => $request->input('type'),
            'type1' => $request->input('type1'),
            'paymentType' => $request->input('paymentType'),
            'status' => $request->status,
            'client_name' => $client_name
        ]);
        if ($restaurant && $restaurant->numberolder > 0) {
            $restaurant->update([
                'numberolder' => $restaurant->numberolder - 1
            ]);
        }
        return $this->returnSuccessWithData('Success Create Booking', $booking);
    }
    public function updateBooking(Request $request){
        $validatedData = $request->validate([
            'booking_id' => 'nullable|integer|exists:bookings,id',
            'event_id' => 'nullable|integer|exists:events,id',
            'restaurant_id' => 'required|integer|exists:restaurents,id',
            'appointment' => 'required|date|after:today',
            'adult' => 'required|integer|min:1',
            'children' => 'required|integer|min:0',
            'type' => 'required|integer|in:1,2',
            'type1' => 'required|integer|in:1,2',
            'paymentType' => 'required|integer|in:1,2',
            'status' => 'required|integer|in:1,2,3',
        ]);
        $booking = Booking::findOrFail($_POST["booking_id"]);
        $booking->update([
            'event_id' => $request->input('event_id'),
            'restaurant_id' => $request->input('restaurant_id'),
            'appointment' => $request->input('appointment'),
            'adolt' => $request->input('adult'),
            'children' => $request->input('children', 0),
            'type' => $request->input('type'),
            'type1' => $request->input('type1'),
            'paymentType' => $request->input('paymentType'),
            'status' => $request->status
        ]);

        return $this->returnSuccessWithData('Success Update Booking', $booking);
    }
    public function deleteBooking(){
        if ($_POST["booking_id"] == null){
            return $this->returnError('Booking not found');
        }
        $booking = Booking::findOrFail($_POST["booking_id"]);
        if ($booking == null){
            return $this->returnError('Booking not found');
        }
        $booking->delete();

        return $this->returnSuccess('Success Delete Booking');
    }
    public function getAttendEvents(){
        return $this->returnSuccessWithData('Success Get All team events from User' ,Auth::user()->clientBookings);
    }

    public function getAnEventBookings(){
        if ($_POST["event_id"] == null){
            return $this->returnError('event_id not found');
        }
        $event = Event::findOrFail($_POST["event_id"]);
        if ($event == null){
            return $this->returnError('Event not found');
        }
        return $this->returnSuccessWithData('Success Get An Event Bookings' , $event->eventBookings);
    }
    public function acceptBooking(){
        if ($_POST["booking_id"] == null){
            return $this->returnError('booking_id not found');
        }
        $booking = Booking::findOrFail($_POST["booking_id"]);
        if ($booking == null){
            return $this->returnError('Booking not found');
        }
        $booking->update([
            'status'=>2,
        ]);
        return $this->returnSuccessWithData('Success Accept Booking' , $booking);

    }

    public function ConformBooking(){
        if ($_POST["booking_id"] == null){
            return $this->returnError('booking_id not found');
        }
        if ($_POST["children"] == null){
            return $this->returnError('children not found');
        }
        $booking = Booking::findOrFail($_POST["booking_id"]);
        if ($booking == null){
            return $this->returnError('Booking not found');
        }
        $booking->update([
            'status'=>4,
            'children' => $_POST["children"]
        ]);
        return $this->returnSuccessWithData('Success Accept Booking' , $booking);

    }

    public function rejectBooking(){
        if ($_POST["booking_id"] == null){
            return $this->returnError('booking_id not found');
        }
        $booking = Booking::findOrFail($_POST["booking_id"]);
        if ($booking == null){
            return $this->returnError('Booking not found');
        }
        $booking->update([
            'status'=>3,
        ]);
        $restaurant = $booking->restaurant;
        if ($restaurant && $restaurant->numberolder > 0) {
            $restaurant->update([
                'numberolder' => $restaurant->numberolder + 1
            ]);
        }
        return $this->returnSuccessWithData('Success Reject Booking' , $booking);
    }

    public function reBooking(){
        if (empty($_POST["booking_id"])) {
            return $this->returnError('Booking ID not found');
        }
        $booking = Booking::find($_POST["booking_id"]);
        if (empty($booking) || $booking->status != 2) {
            return $this->returnError('Booking not found or not eligible for rebooking');
        }
        $user = Auth::user();
        $customer_number = substr($user->mobile, -3);
        $booking_type = 'N';
        $booking_date = Carbon::parse($booking->appointment)->format('dmY');
        $client_name = $customer_number . $booking_type . $booking_date;
        $newBooking = Booking::create([
            'event_id' => $booking->event_id,
            'restaurant_id' => $booking->restaurant_id,
            'client_id' => $booking->client_id,
            'appointment' => $booking->appointment,
            'adult' => $booking->adult,
            'children' => $booking->children,
            'type' => $booking->type,
            'type1' => $booking->type1,
            'paymentType' => $booking->paymentType,
            'status' => 0,
            'client_name' => $client_name
        ]);
        $booking->delete();
        return $this->returnSuccessWithData('Success ReBooking Booking' , $newBooking);
    }
    public function getAnEventWaitingBookings(){
        $event = Event::findOrFail($_POST["event_id"]);

        return $this->returnSuccessWithData('Success Get An Event Waiting Bookings' ,
            $event->hasMany(Booking::class, 'event_id', 'id')->whereNull('status')->with('privacy')->get());
    }
    public function filter(Request $request) {
        $query = Event::query();

        // فلترة الفعاليات
        if ($request->has('city_id') && !empty($request->city_id)) {
            $query->whereHas('restaurant', function ($q) use ($request) {
                $q->where('city_id', $request->input('city_id'));
            });
        }
        if ($request->has('free') && !empty($request->free)) {
            $query->where('free', $request->input('free'));
        }
        if ($request->has('privacy_id') && !empty($request->privacy_id)) {
            $privacyIds = is_array($request->input('privacy_id'))
                ? $request->input('privacy_id')
                : explode(',', str_replace(['[', ']'], '', $request->input('privacy_id')));
            $privacyIds = array_map('trim', $privacyIds);

            $query->where(function ($q) use ($privacyIds) {
                foreach ($privacyIds as $privacyId) {
                    $q->orWhere('privacy_id', $privacyId);
                }
            });
        }

        $events = $query->with(['restaurant', 'features', 'privacy'])->get();

        // فلترة المطاعم
        $restaurantQuery = Restaurant::query();
        if ($request->has('city_id') && !empty($request->city_id)) {
            $restaurantQuery->where('city_id', $request->input('city_id'));
        }

        $restaurants = $restaurantQuery->get();

        // فك وترجمة الحقول المخزنة كـ JSON
        foreach ($restaurants as $restaurant) {
            // فك الحقول JSON
            $privacyIds = json_decode($restaurant->privacies_id, true);
            $kitchenTypeIds = json_decode($restaurant->kitchen_types_id, true);
            $featureIds = json_decode($restaurant->features_id, true);

            // إرجاع الخصوصيات
            if (is_array($privacyIds)) {
                $privacies = [];
                foreach ($privacyIds as $privacyId) {
                    $privacies[] = Privacy::find($privacyId);
                }
                $restaurant->privacies = $privacies;
            } else {
                $restaurant->privacies = [];
            }

            // إرجاع أنواع المطابخ
            if (is_array($kitchenTypeIds)) {
                $kitchen = [];
                foreach ($kitchenTypeIds as $kitchenTypeId) {
                    $kitchen[] = KitchenType::find($kitchenTypeId);
                }
                $restaurant->kitchen_types = $kitchen;
            } else {
                $restaurant->kitchen_types = [];
            }

            // إرجاع المزايا
            if (is_array($featureIds)) {
                $features = [];
                foreach ($featureIds as $featureId) {
                    $features[] = Feature::find($featureId);
                }
                $restaurant->features = $features;
            } else {
                $restaurant->features = [];
            }
        }

        $data = [
            'events' => $events,
            'restaurants' => $restaurants
        ];

        return $this->returnSuccessWithData('Success Filter Events and Restaurants', $data);
    }


    public function getPrivacyAndfeature(){
        $getfeature = Feature::get();
        $getPrivcy = Privacy::get();
        $data = [
            'Feature' => $getfeature,
            'Privacy' => $getPrivcy
        ];

        return $this->returnSuccessWithData('Success Privacy And feature' , $data);

    }
    function getLoginToken(){
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789#-_*";
        for($i=0;$i<10;$i++){
            $token .= $codeAlphabet[rand(0,strlen($codeAlphabet)-1)];
        }
        return $token;
    }
    public function getUserAndToken(User $user, $device_name = "device_name"){
        $user2  = User::where('id','=',$user->id)->first();
        $user->tokens()->delete();
        $user->load(['city','roles']);
        $user2->token = $user->createToken($device_name)->plainTextToken;
        return $user2;
    }



    public function getAllBooking(Request $request){
        $user = Auth::user();
        if ($user->role != 5) {
            $validatedData = $request->validate([
                'restaurant_id' => 'required|integer|exists:restaurents,id',
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
            ]);
            $startDate = $request->start_date ? $request->start_date : '1970-01-01';
            $endDate = $request->end_date ? $request->end_date : now();
            $bookings = Booking::where('restaurant_id', $request->restaurant_id)
                ->whereBetween('appointment', [$startDate, $endDate])
                ->with('client', 'restaurant')
                ->get();

            $bookingCount = $bookings->count();
            $remainingReservationsCount = 0;
            if ($bookingCount > 0 && isset($bookings[0]->restaurant->numberolder)) {
                $remainingReservationsCount = $bookings[0]->restaurant->numberolder - $bookingCount;
            }
            $data = [
                'booking_count' => $bookingCount,
                'RemainingReservations_count' => $remainingReservationsCount,
                'bookings' => $bookings
            ];
            return $this->returnSuccessWithData('Bookings retrieved successfully', $data);
        }else{
            return $this->returnError('Unauthorized User');
        }
    }


    public function logout()
    {
        $user = Auth::user();
        $tokens = $user->tokens;
        foreach ($tokens as $token) {
            $token->delete();
        }
        return $this->returnSuccess('Logged out successfully');
    }






    protected function getMyChainRestaurants(){
        return $this->returnSuccessWithData('Success Get All team restaurants from User' , Auth::user()->team->restaurants);
    }
    protected function getFeatures(){
        return response()->json ([
            'result'=>"success",
            'privacy' => Feature::all()
        ]);
    }
    protected function getMyRestaurantEvents(){
        return response()->json([
            'result' => "success",
            'events' => Auth::user()->restaurantsWithEvents
        ]);
    }

    protected function getMyChainEvents(){
        return response()->json ([
            'result'=>"success",
            'restaurants' => Auth::user()->chain->restaurantsWithEvents()
        ]);
    }
    protected function getMyRestaurantsBookings(){
        return response()->json ([
            'result'=>"success",
            'bookings' => Booking::with('privacy_id')->get()
        ]);
    }
    protected function getRestaurantOffers(){
        $rest = Restaurant::findOrFail($_POST('restaurant_id'));

        return response()->json ([
            'result'=>"success",
            'offers' => $rest->restaurantOffers->whereDate('ending_at', '>',date('Y-m-d H:i:s'))->get()
        ]);
    }
    protected function getChainOffers(){
        $team = Team::findOrFail($_POST['chain_id']);

        return response()->json ([
            'result'=>"success",
            'offers' => $team->restaurantsWithEvents()
        ]);
    }
}
