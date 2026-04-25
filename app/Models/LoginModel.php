<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class LoginModel extends Model{
    use SoftDeletes, HasFactory;

    public $table = 'logins';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'fcm_token',
        'auth_code',
        'user_id',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function timestamp()
    {
        try {
            // التأكد من أن الوقت موجود، ثم تحويله إلى طابع زمني
            return $this->time ? Carbon::createFromFormat('Y-m-d H:i:s', $this->time)->getTimestamp() : null;
        } catch (\Exception $e) {
            // في حالة حدوث خطأ في التحويل، قم بتسجيل الخطأ وارجع null
            \Log::error("Invalid time format: " . $e->getMessage());
            return null;
        }
//        return Carbon::createFromFormat('Y-m-d H:i:s', $this->time)->getTimestamp();
    }
}
