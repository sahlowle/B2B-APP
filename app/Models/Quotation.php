<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelTraits\hasFiles;

class Quotation extends Model
{
    use HasFactory;
    use hasFiles;

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

    public function country()
    {
        return $this->belongsTo(\Modules\GeoLocale\Entities\Country::class, 'country_id')->withDefault([
            'name' => __('N/A'),
        ]);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id')->withDefault([
            'name' => __('N/A'),
        ]);
    }
}
