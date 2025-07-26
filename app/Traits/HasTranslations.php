<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 28-04-2024
 */

namespace App\Traits;

use Spatie\Translatable\HasTranslations as BaseHasTranslations;

trait HasTranslations
{
    use BaseHasTranslations;

    /**
     * Get an attribute from the model.
     *
     * @param  string  $key
     */
    public function getAttributeValue($key): mixed
    {
        if (! $this->isTranslatableAttribute($key) || is_numeric($this->attributes[$key])) {
            return parent::getAttributeValue($key);
        }

        if ($translation = $this->getTranslation($key, $this->getLocale(), $this->useFallbackLocale())) {
            return $translation;
        }

        if (json_validate($this->attributes[$key] ?? '')) {
            return array_values(json_decode($this->attributes[$key], true))[0];
        }

        return $this->attributes[$key];
    }

    /**
     * Get translation from the model's custom translation column. If the translation is not found,
     * then fallback to the default translation column.
     *
     * @param  string  $key  translation key
     * @param  string  $locale  locale code
     * @param  bool  $useFallbackLocale  whether to use fallback locale
     * @return mixed translation or default translation
     */
    public function getTranslated(string $key, string $locale, bool $useFallbackLocale = true): mixed
    {
        $value = $this->getAttributeValue($key);

        if (is_numeric($value)) {
            return $value;
        }

        return $this->getTranslation($key, $locale, $useFallbackLocale) ?: $value;
    }

    /**
     * Convert the model instance to an array.
     */
    public function toArray(): array
    {
        $attributes = $this->attributesToArray(); // attributes selected by the query
        // remove attributes if they are not selected
        $translatables = array_filter($this->getTranslatableAttributes(), function ($key) use ($attributes) {
            return array_key_exists($key, $attributes);
        });

        foreach ($translatables as $field) {
            if (is_numeric($this->attributes[$field])) {
                $attributes[$field] = $this->attributes[$field];
            } else {
                $attributes[$field] = $this->getTranslation($field, \App::getLocale()) ?: $this->getAttributeValue($field);
            }
        }

        return array_merge($attributes, $this->relationsToArray());
    }
}
