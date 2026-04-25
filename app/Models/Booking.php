<?php

namespace App\Models;

use App\Traits\MultiTenantModelTrait;
use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use SoftDeletes, MultiTenantModelTrait, HasFactory;

    public $table = 'bookings';

    public const STATUS_SELECT = [
        '1' => 'Approved',
        '2' => 'Decline',
    ];

    protected $dates = [
        'appointment',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'event_id',
        'client_id',
        'appointment',
        'adolt',
        'children',
        'call_action',
        'created_at',
        'updated_at',
        'deleted_at',
        'team_id',
        'status',
        'privacy_id',
        'restaurant_id',
        'client_name',
        'type',
        'type1',
        'paymentType',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class, 'restaurant_id');
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function privacy()
    {
        return $this->belongsTo(Privacy::class, 'privacy_id');
    }


    public function getAppointmentAttribute($value)
    {
        if (!$value) {
            return null;
        }

        try {
            return Carbon::createFromFormat('Y-m-d H:i:s', $value)
                ->format(config('panel.date_format') . ' ' . config('panel.time_format'));
        } catch (\Exception $e) {
            // يمكنك تسجيل الخطأ إذا كانت القيمة غير صحيحة أو أي مشكلة أخرى
            \Log::error("Failed to format date: " . $e->getMessage());
            return null;
        }
       // return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setAppointmentAttribute($value)
    {
        if (!$value) {
            $this->attributes['appointment'] = null;
            return;
        }

        try {
            $this->attributes['appointment'] = Carbon::createFromFormat(
                config('panel.date_format') . ' ' . config('panel.time_format'),
                $value
            )->format('Y-m-d H:i:s');
        } catch (\Exception $e) {
            // تسجيل الخطأ لتتبع المشكلة إذا كانت القيمة لا تتبع التنسيق المتوقع
            \Log::error("Invalid appointment format: " . $e->getMessage());
            $this->attributes['appointment'] = null;
        }
//        $this->attributes['appointment'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function getStatusLabelAttribute()
    {
        return static::STATUS_SELECT[$this->status] ?? null;
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }
}
