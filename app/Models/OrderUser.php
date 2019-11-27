<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderUser extends Model
{
    protected $fillable = [
        'id_order', 'portrait_main', 'portraits',
        'common_photos', 'comment', 'designs'
    ];
}
