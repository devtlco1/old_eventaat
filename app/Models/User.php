<?php

namespace App\Models;

use App\Traits\MultiTenantModelTrait;
use Carbon\Carbon;
use DateTimeInterface;
use Hash;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * @property int $id
 */

class User extends Authenticatable implements HasMedia
{
    use SoftDeletes, Notifiable, InteractsWithMedia, HasFactory;
    use HasApiTokens;

    public $table = 'users';

    protected $appends = [
        'image',
    ];

    public const GENDER_SELECT = [
        '0' => 'male',
        '1' => 'female',
    ];

    protected $hidden = [
        'remember_token',
        'password',
    ];

    protected $dates = [
        'email_verified_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'verified',
        'verified_at',
        'verification_token',
        'remember_token',
        'fcm_token',
        'created_at',
        'credit',
        'mobile',
        'country_code',
        'cc',
        'updated_at',
        'deleted_at',
        'team_id',
        'activation_code',
        'token',
        'city_id',
        'gender',
        'lat',
        'lng',
        'Cap'
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function getIsAdminAttribute()
    {
        return $this->roles()->where('id', 1)->exists();
    }

    public function clientBookings()
    {
        return $this->hasMany(Booking::class, 'client_id', 'id')->with('restaurant');
    }

    public function restaurants()
    {
        return $this->hasMany(Restaurant::class, 'mobile', 'mobile');
    }

    public function getGenderLabelAttribute($value)
    {
        return static::GENDER_SELECT[$this->gender] ?? null;
    }

    public function restaurantsWithEvents()
    {
        return $this->hasMany(Restaurant::class, 'mobile', 'mobile')->with('restaurantEvents')->get();
    }


    public function getEmailVerifiedAtAttribute($value)
    {
        if (!$value) {
            return null;
        }

        try {
            return Carbon::createFromFormat('Y-m-d H:i:s', $value)
                ->format(config('panel.date_format') . ' ' . config('panel.time_format'));
        } catch (\Exception $e) {
            // سجل الخطأ لتتبع المشاكل المحتملة
            \Log::error("Invalid email_verified_at format: " . $e->getMessage());
            return null;
        }
//        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setEmailVerifiedAtAttribute($value)
    {
        if (!$value) {
            $this->attributes['email_verified_at'] = null;
            return;
        }

        try {
            $this->attributes['email_verified_at'] = Carbon::createFromFormat(
                config('panel.date_format') . ' ' . config('panel.time_format'),
                $value
            )->format('Y-m-d H:i:s');
        } catch (\Exception $e) {
            // سجل الخطأ لتتبع المشاكل المحتملة
            \Log::error("Invalid email_verified_at format: " . $e->getMessage());
            $this->attributes['email_verified_at'] = null;
        }
//        $this->attributes['email_verified_at'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function setPasswordAttribute($input)
    {
        if ($input) {
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
        }
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function getImageAttribute()
    {
        $file = $this->getMedia('user_image')->last();
        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview   = $file->getUrl('preview');
        }

        return $file;
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    public function chain()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }
}
