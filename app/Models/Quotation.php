<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'country_id',
        'phone_number',
        'email',
        'category_id',
        'notes',
        'pdf_file',
    ];
}
