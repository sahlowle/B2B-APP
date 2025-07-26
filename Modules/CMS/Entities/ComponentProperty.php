<?php

namespace Modules\CMS\Entities;

use App\Models\Model;
use App\Traits\HasTranslations;
use App\Traits\ModelTraits\Cachable;
use App\Traits\ModelTraits\hasFiles;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ComponentProperty extends Model
{
    use Cachable;
    use HasFactory;
    use hasFiles;
    use HasTranslations;

    public $timestamps = false;

    protected $fillable = ['component_id', 'name', 'type', 'value'];

    public $translatable = ['value'];

    protected static function newFactory()
    {
        return \Modules\CMS\Database\factories\ComponentPropertyFactory::new();
    }

    public function component()
    {
        return $this->belongsTo(Component::class);
    }

    /**
     * Get component property value
     *
     * @param  string  $key
     */
    public function getAttributeValue($key): mixed
    {
        if (! $this->isTranslatableAttribute($key) || is_numeric($this->attributes[$key])) {
            return parent::getAttributeValue($key);
        }

        $translatedValue = $this->getTranslation($key, request()->input('lang', $this->getLocale()), $this->useFallbackLocale());
        $type = $this->attributes['type'] ?? '';

        if ($translatedValue) {
            return ($type == 'array') ? json_decode($translatedValue, true) : $translatedValue;
        }

        return $this->fallbackLocale($key);
    }

    /**
     * Get fallback locale
     *
     * @param  string  $key
     * @return mixed
     */
    private function fallbackLocale($key)
    {
        $jsonValue = $this->attributes[$key] ?? '';

        if (! json_validate($jsonValue)) {
            return $jsonValue;
        }

        $shortLanguages = array_keys(getShortLanguageName(true));
        $decodedJson = json_decode($jsonValue, true);
        $firstKey = current(array_keys($decodedJson));

        if (in_array($firstKey, $shortLanguages) && json_validate($decodedJson[$firstKey] ?? '')) {
            if (is_numeric($decodedJson[$firstKey])) {
                return $decodedJson[$firstKey];
            }

            return json_decode($decodedJson[$firstKey], true);
        }

        if (in_array($firstKey, $shortLanguages)) {
            return $decodedJson[$firstKey];
        }

        return $decodedJson;
    }

    public function getObjectType()
    {
        return $this->objectType();
    }

    public function getObjectId()
    {
        return $this->objectId();
    }

    /**
     * Set translated property value.
     *
     * @param  mixed  $value
     */
    public function setTranslated(string $key, string $locale, $value): ComponentProperty
    {
        $attributeValue = $this->attributes[$key] ?? '';

        if (is_numeric($attributeValue)) {
            $this->attributes[$key] = '';
            $this->save();
        } elseif (json_validate($attributeValue)) {
            $decodedJson = json_decode($attributeValue, true);
            $shortLanguages = array_keys(getShortLanguageName(true));
            $firstKey = current(array_keys($decodedJson));

            if (! in_array($firstKey, $shortLanguages)) {
                $this->attributes[$key] = '';
                $this->save();
            }
        }

        return $this->setTranslation($key, $locale, $value);
    }
}
