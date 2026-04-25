<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pag extends Model
{
    use  HasFactory;

    public $table = 'pags';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'id',
        'Key',
        'Value',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
