<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Kabir Ahmed <[kabir.techvill@gmail.com]>
 *
 * @created 29-01-2022
 */

namespace Modules\CMS\Http\Models;

use App\Models\Model;
use App\Traits\HasTranslations;
use App\Traits\ModelTrait;
use App\Traits\ModelTraits\hasFiles;
use Modules\MediaManager\Http\Models\ObjectFile;

class ThemeOption extends Model
{
    use hasFiles;
    use HasTranslations;
    use ModelTrait;

    public $incrementing = false;

    protected $fillable = ['name', 'value'];

    public $timestamps = false;

    public $translatable = ['value'];

    public static $loadData = null;

    /**
     * Relation with File Model
     *
     * @var bool
     */
    public function image()
    {
        return $this->hasOne('App\Models\File', 'object_id')->where('object_type', 'themeOption');
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

        if (collect(explode('_', parent::getAttributeValue('name')))->last() != 'footer') {
            return $this->attributes[$key];
        }
        $translatedValue = $this->getTranslation($key, request()->input('lang', $this->getLocale()), $this->useFallbackLocale());

        if ($translatedValue) {
            return json_validate($this->attributes[$key] ?? '') ? json_decode($translatedValue, true) : $translatedValue;
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

    /**
     * Store theme data
     *
     * @param  array  $data
     * @return bool
     */
    public function store($data = [], $layout = 'default')
    {
        $deletedFileIds = $data['delete_file_ids'] ?? [];
        $lang = $data['lang'] ?? 'en';

        unset($data['delete_file_ids']);
        unset($data['lang']);

        collect($data)->each(function ($value, $key) use ($lang) {
            $value = is_array($value) ? json_encode($value) : $value;

            if (str_ends_with($key, '_footer')) {
                $appearance = parent::firstOrNew(['name' => $key]);
                $appearance->setTranslation('value', $lang, $value);
                $appearance->save();
            } else {
                parent::updateOrInsert(['name' => $key], ['value' => $value]);
            }
        });

        if (! empty($deletedFileIds)) {
            ObjectFile::whereIn('id', $deletedFileIds)->delete();
        }

        $images = ['footer_logo', 'payment_methods', 'google_play', 'app_store', 'header_logo', 'header_mobile_logo', 'download_google_play_logo', 'download_app_store_logo'];
        foreach ($images as &$image) {
            $image = $layout . '_template_' . $image;
        }

        if (! empty($data['file_id']) && is_array($data['file_id'])) {
            foreach ($images as $key => $value) {
                if (! in_array($data[$value], $data['file_id'])) {
                    continue;
                }

                $result = parent::where('name', $value);

                request()->file_id = [$data[$value]];
                if (! is_null($result)) {
                    $result->first()->updateFiles(['isUploaded' => false, 'isOriginalNameRequired' => true, 'thumbnail' => true]);
                }
            }
        }
        self::forgetCache();

        return true;
    }

    /**
     * Get attribute
     *
     * @return array $this->value
     */
    public function getKeyValueAttribute()
    {
        if ($this->isJson($this->value)) {
            return json_decode($this->value, true);
        }

        return $this->value;
    }

    /**
     * Check Json
     *
     * @param  string  $string
     * @return bool
     */
    public function isJson($string)
    {
        return is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
    }

    /**
     * Store layout data
     *
     * @param  array  $data
     * @return bool
     */
    public function layoutStore($layout)
    {
        $layout = strtolower(str_replace(' ', '_', $layout));

        $dataList = parent::where('name', 'like', 'default_%')->get()->toArray();
        foreach ($dataList as &$data) {
            $data = ['name' => str_replace('default', $layout, $data['name']), 'value' => $data['value']];
        }

        $copyLayout = 'default';
        $images = ['footer_logo', 'payment_methods', 'google_play', 'app_store', 'header_logo', 'header_mobile_logo', 'download_google_play_logo', 'download_app_store_logo'];
        foreach ($images as &$image) {
            $image = $copyLayout . '_template_' . $image;
        }

        $defaultImageData = parent::whereIn('name', $images)
            ->join('object_files', 'theme_options.id', '=', 'object_files.object_id')
            ->having('object_files.object_type', 'theme_options')
            ->get();

        if (parent::insert($dataList)) {
            $images = ['footer_logo', 'payment_methods', 'google_play', 'app_store', 'header_logo', 'header_mobile_logo', 'download_google_play_logo', 'download_app_store_logo'];
            foreach ($images as &$image) {
                $image = $layout . '_template_' . $image;
            }

            $data = [];
            foreach (parent::whereIn('name', $images)->get() as $newImageData) {
                $imageColumn = str_replace($layout . '_template_', '', $newImageData->name);
                $objectFile = $defaultImageData->where('name', 'like', 'default_template_' . $imageColumn)->first();
                if (is_null($objectFile)) {
                    continue;
                }

                $data[] = [
                    'object_type' => 'theme_options',
                    'object_id' => $newImageData->id,
                    'file_id' => $objectFile->file_id,
                ];
            }
            ObjectFile::insert($data);

            self::forgetCache();

            return true;
        }

        return false;
    }

    /**
     * Update layout data
     *
     * @param  array  $layout
     * @return bool
     */
    public function layoutUpdate($layout)
    {
        $old = strtolower(str_replace(' ', '_', $layout['old_layout']));
        $new = strtolower(str_replace(' ', '_', $layout['name']));

        $result = parent::where('name', 'LIKE', $old . '%')
            ->update(['name' => \DB::raw("REPLACE(name,  '$old', '$new')")]);

        if ($result) {
            Page::where('layout', $old)->update(['layout' => $new]);
            self::forgetCache();

            return true;
        }

        return false;
    }

    /**
     * Delete layout data
     *
     * @param  string  $layout
     * @return bool
     */
    public function layoutDelete($layout)
    {
        $layoutIds = parent::where('name', 'LIKE', $layout . '%')->get(['id'])->toArray();
        foreach ($layoutIds as $key => &$value) {
            $value = $value['id'];
        }

        if (parent::whereIn('id', $layoutIds)->delete()) {
            Page::where('layout', $layout)->update(['layout' => 'default']);
            ObjectFile::where('object_type', 'theme_options')->whereIn('object_id', $layoutIds)->delete();
            self::forgetCache();

            return true;
        }

        return false;
    }

    /**
     * Get all layout name
     *
     * @return array
     */
    public static function layouts()
    {
        $layouts = parent::where('name', 'like', '%_template_%')->get()->toArray();

        $layoutName = [];
        foreach ($layouts as $key => $value) {
            $layout = explode('_template_', $value['name'])[0];
            if (! in_array($layout, $layoutName)) {
                $layoutName[] = $layout;
            }
        }

        return $layoutName;
    }

    /**
     * StoreOrUpdate primary color
     *
     * @param  array  $data
     * @return bool
     */
    public function storePrimaryColor($data)
    {
        if (parent::updateOrInsert(['name' => $data['name']], ['value' => $data['value']])) {
            self::forgetCache();

            return true;
        }

        return false;
    }

    /**
     * Get font list
     *
     * @return array
     */
    public static function fontFamilies()
    {
        //Comma ',' is must in font family
        return [
            'DM Sans, sans-serif',
            'Roboto, sans-serif',
            'Poppins, sans-serif',
            'Inter, sans-serif',
            'Roboto Slab, sans-serif',
            'Playfair Display, sans-serif',
            'Montserrat, sans-serif',
            'Pathway Extreme, sans-serif',
            'Plus Jakarta Sans, sans-serif',
            'Manrope, sans-serif',
            'Cabin, sans-serif',
            'Titillium Web, sans-serif',
            'Dosis, sans-serif',
            'Carlito, sans-serif',
            'Archivo, sans-serif',
            'Play, sans-serif',
            'Mukta, sans-serif',
            'Lato, sans-serif',
            'Barlow, sans-serif',
            'Noto sans, sans-serif',
            'Rubik, sans-serif',
        ];
    }

    /**
     * Get all theme options
     *
     * @return array
     */
    public static function singletons()
    {
        if (self::$loadData) {
            return self::$loadData;
        }

        return self::$loadData =  \Cache::remember('theme_options', now()->addMinutes(1), function () {
            return self::getAll()->pluck('key_value', 'name')->toArray();
        });
    }
}
