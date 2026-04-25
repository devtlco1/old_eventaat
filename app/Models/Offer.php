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

class Offer extends Model implements HasMedia
{
//    use SoftDeletes, MultiTenantModelTrait, HasFactory, InteractsWithMedia;
    use SoftDeletes, HasFactory, InteractsWithMedia;

    public $table = 'offers';

    protected $appends = [
        'images',
    ];

    protected $dates = [
        'created_at',
        'starting_at',
        'ending_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'restaurant_id',
        'title',
        'disception',
        'created_at',
        'starting_at',
        'ending_at',
        'public',
        'updated_at',
        'deleted_at',
        'team_id',
        'approved',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class, 'restaurant_id');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function getImagesAttribute()
    {
        $files = $this->getMedia('offer_images');
        $files->each(function ($item) {
            $item->url       = $item->getUrl();
            $item->thumbnail = $item->getUrl('thumb');
            $item->preview   = $item->getUrl('preview');
        });

        return $files;
    }

    public function getStartingAtAttribute($value)
    {
        try {
            // إذا كانت القيمة موجودة، نقوم بتحويلها إلى تنسيق التاريخ والوقت المناسب
            return $value
                ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format'))
                : null;
        } catch (\Exception $e) {
            // في حال حدوث خطأ في التحويل (مثل تنسيق غير صحيح)
            \Log::error("Invalid starting_at date format: " . $e->getMessage());
            return null; // أو يمكنك إرجاع قيمة افتراضية أخرى أو تركها فارغة
        }
//        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setStartingAtAttribute($value)
    {
        try {
            // إذا كانت القيمة موجودة، نقوم بتحويلها إلى التنسيق المناسب
            $this->attributes['starting_at'] = $value
                ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s')
                : null;
        } catch (\Exception $e) {
            // إذا كان التنسيق غير صحيح أو حدث خطأ، نعيد القيمة إلى null أو نتركها فارغة
            \Log::error("Invalid starting_at date format: " . $e->getMessage());
            $this->attributes['starting_at'] = null; // أو قيمة افتراضية
        }
//        $this->attributes['starting_at'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function getEndingAtAttribute($value)
    {
        try {
            // إذا كانت القيمة موجودة، نقوم بتحويلها إلى التنسيق المناسب
            return $value
                ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format'))
                : null;
        } catch (\Exception $e) {
            // في حالة حدوث خطأ في التنسيق، نعيد القيمة إلى null أو نص فارغ
            \Log::error("Invalid ending_at date format: " . $e->getMessage());
            return null;
        }
//        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setEndingAtAttribute($value)
    {
        try {
            // إذا كانت القيمة موجودة، نحولها إلى التنسيق المناسب
            $this->attributes['ending_at'] = $value
                ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s')
                : null;
        } catch (\Exception $e) {
            // في حالة حدوث خطأ، يتم تسجيل الخطأ وإرجاع قيمة null
            \Log::error("Invalid ending_at date format: " . $e->getMessage());
            $this->attributes['ending_at'] = null;
        }
//        $this->attributes['ending_at'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }
}
