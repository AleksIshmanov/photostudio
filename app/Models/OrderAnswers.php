<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderAnswers extends Model
{
    protected $fillable = [
        'header', 'text'
    ];
}
