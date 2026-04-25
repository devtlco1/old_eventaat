<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Income extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'incomes';

    protected $dates = [
        'entry_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'income_category_id',
        'entry_date',
        'amount',
        'description',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function income_category()
    {
        return $this->belongsTo(IncomeCategory::class, 'income_category_id');
    }

    public function getEntryDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setEntryDateAttribute($value)
    {
        try {
            // إذا كانت القيمة موجودة، نقوم بتحويلها إلى التاريخ بتنسيق Y-m-d
            $this->attributes['entry_date'] = $value
                ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d')
                : null;
        } catch (\Exception $e) {
            // في حال حدوث خطأ في التحويل (مثل تنسيق غير صحيح)
            \Log::error("Invalid date format for entry_date: " . $e->getMessage());
            // يمكن إرجاع قيمة null أو قيمة بديلة حسب الحاجة
            $this->attributes['entry_date'] = null;
        }
//        $this->attributes['entry_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }
}
