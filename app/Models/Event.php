<?php

namespace App\Models;

use App\Traits\MultiTenantModelTrait;
use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Event extends Model implements HasMedia
{
    use SoftDeletes, MultiTenantModelTrait, InteractsWithMedia, HasFactory;

    public $table = 'events';

    protected $appends = [
        'images',
    ];

    protected $dates = [
        'starting_at',
        'ending_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'restaurant_id',
        'title',
        'discreption',
        'starting_at',
        'ending_at',
        'old_price',
        'price',
        'approved',
        'created_at',
        'privacy_id',
        'seats',
        'updated_at',
        'deleted_at',
        'team_id',
        'free',
        'currency',
        'type',
        'type1',
        'numberolder',
        'numberChildren',
        'date',
        'paymentType',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

//    public static function boot()
//    {
//        parent::boot();
//        self::observe(new \App\Observers\EventActionObserver);
//    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function eventBookings()
    {
        return $this->hasMany(Booking::class, 'event_id', 'id');
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class, 'restaurant_id');
    }

    public function getStartingAtAttribute($value)
    {
        if (!$value) {
            return null;
        }

        try {
            return Carbon::createFromFormat('Y-m-d H:i:s', $value)
                ->format(config('panel.date_format') . ' ' . config('panel.time_format'));
        } catch (\Exception $e) {
            // تسجيل الخطأ لتسهيل التعقب
            \Log::error("Invalid format for starting_at: " . $e->getMessage());
            return null;
        }
//        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setStartingAtAttribute($value)
    {
        if (!$value) {
            $this->attributes['starting_at'] = null;
            return;
        }

        try {
            // تحويل التاريخ المدخل إلى التنسيق المطلوب 'Y-m-d H:i:s'
            $this->attributes['starting_at'] = Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)
                ->format('Y-m-d H:i:s');
        } catch (\Exception $e) {
            // تسجيل الخطأ إذا كان التنسيق غير صحيح
            \Log::error("Invalid format for starting_at: " . $e->getMessage());
            $this->attributes['starting_at'] = null; // تعيين القيمة كـ null في حال حدوث خطأ
        }
//        $this->attributes['starting_at'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function getEndingAtAttribute($value)
    {
        try {
            return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
        } catch (\Exception $e) {
            // في حال حدوث خطأ بسبب التنسيق الغير صحيح
            \Log::error("Invalid date format for ending_at: " . $e->getMessage());
            return null; // إعادة القيمة null في حال حدوث خطأ
        }
//        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setEndingAtAttribute($value)
    {
        try {
            $this->attributes['ending_at'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
        } catch (\Exception $e) {
            // في حال حدوث خطأ في التحويل
            \Log::error("Invalid date format for ending_at: " . $e->getMessage());
            $this->attributes['ending_at'] = null; // تعيين القيمة إلى null في حال وجود خطأ
        }
//        $this->attributes['ending_at'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function getImagesAttribute()
    {
        $files = $this->getMedia('images');
        $files->each(function ($item) {
            $item->url       = $item->getUrl();
            $item->thumbnail = $item->getUrl('thumb');
            $item->preview   = $item->getUrl('preview');
        });

        return $files;
    }

    public function privacy()
    {
        return $this->belongsTo(Privacy::class, 'privacy_id');
    }

    public function features()
    {
        return $this->belongsToMany(Feature::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }
}
