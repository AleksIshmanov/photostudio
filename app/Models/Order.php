<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
        'portraits_count', 'photo_common', 'photo_individual',
        'client_link', 'confirm_key', 'comment'
    ];
}
