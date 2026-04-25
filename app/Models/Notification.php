<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    public $table = 'notifications';

    protected $fillable = [
        'user_id',
        'registration_id',
        'title',
        'message_text',
        'alarm_id',
        'status',
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }

}
