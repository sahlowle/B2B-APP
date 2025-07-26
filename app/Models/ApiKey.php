<?php

namespace App\Models;

class ApiKey extends Model
{
    protected $fillable = [
        'name',
        'access_token',
    ];
}
