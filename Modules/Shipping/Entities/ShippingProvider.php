<?php

namespace Modules\Shipping\Entities;

use App\Models\Model;
use App\Traits\ModelTraits\hasFiles;
use Modules\GeoLocale\Entities\Country;
use Modules\MediaManager\Http\Models\ObjectFile;

class ShippingProvider extends Model
{
    use hasFiles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'country_id',
        'tracking_base_url',
        'tracking_url_method',
        'status',
    ];

    /**
     * timestamps
     *
     * @var bool
     */
    public $timestamps = false;

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Shipping Provider File
     */
    public function logoFile($size = 'small')
    {
        $shippingImage = \DB::table('files')
            ->join('object_files', 'object_files.file_id', '=', 'files.id')
            ->where('object_files.object_type', 'shipping_providers')
            ->where('object_files.object_id', $this->id)
            ->select('files.id', 'files.file_name as fileUrl')
            ->first();

        $image = defaultImage('shipping_providers');

        if (! empty($shippingImage?->fileUrl) && file_exists(public_path('uploads/sizes/' . $size . '/' . $shippingImage?->fileUrl))) {
            $image = asset('public/uploads/sizes/' . $size . '/' . $shippingImage?->fileUrl);
        }

        return asset($image);
    }

    /**
     * Store Shipping Provider
     *
     * @param  array  $data
     * @return bool
     */
    public function store($data = [])
    {
        if (parent::insert($data)) {
            if (request()->has('file_id')) {
                foreach (request()->file_id as $data) {
                    $fileIds[] = $data;
                }
                ObjectFile::storeInObjectFiles($this->objectType(), $this->objectId(), $fileIds);
            }
        }
    }

    /**
     * Update Shipping Provider
     *
     * @param  array  $data
     * @param  null  $id
     * @return bool
     */
    public function update($data = [], $id = null)
    {

        $result = $this->where('id', $id);

        if ($result->exists()) {
            $result->update($data);
        }

        if (request()->file_id) {
            return $result->first()->updateFiles(['isUploaded' => false, 'isOriginalNameRequired' => true, 'thumbnail' => true]);
        } else {
            return $result->first()->deleteFromMediaManager();
        }
    }

    /**
     * Delete Shipping Provider
     *
     * @param  int  $id
     * @return array
     */
    public function remove($id = null)
    {
        $record = parent::where('id', $id);
        if (($record->exists())) {
            $record->first()->deleteFromMediaManager();
            $record->delete();
        }
    }

    /**
     * Get all shipping provider
     *
     * @param  mixed  $name
     * @param  mixed  $status
     * @return void
     */
    protected function getAllShippingProvider($name = null, $status = null)
    {
        $provider = ShippingProvider::with('country');

        if (! empty($name)) {
            $provider->where('name', $name);
        }
        if (! empty($status)) {
            $provider->where('status', $status);
        }

        return $provider;

    }
}
