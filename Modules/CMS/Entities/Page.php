<?php

namespace Modules\CMS\Entities;

use App\Models\Model;
use App\Traits\HasTranslations;
use App\Traits\ModelTraits\hasFiles;

class Page extends Model
{
    use hasFiles;
    use HasTranslations;

    protected $fillable = ['name', 'slug', 'description', 'status', 'meta_title', 'layout', 'type', 'meta_description', 'default'];

    public $translatable = ['name', 'meta_title', 'meta_description'];

    protected $casts = [
        'settings' => 'array',
    ];

    public function scopeSlug($query, $slug)
    {
        $query->where('slug', $slug);
    }

    public function scopeHome($query)
    {
        $query->where('type', 'home');
    }

    public function scopeDefault($query, $flag = 1)
    {
        $query->where('default', $flag);
    }

    public function components()
    {
        return $this->hasMany(\Modules\CMS\Entities\Component::class);
    }

    public function storeFiles()
    {
        return $this->uploadFiles(
            [
                'isUploaded' => false,
                'isOriginalNameRequired' => true,
                'isMediaManager' => true,
                'thumbnail' => false,
                'url' => true,
                'pagebuilder' => true,
            ]
        );
    }
}
