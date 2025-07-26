<?php

namespace App\Models;

class VendorAssociatedUser extends Model
{
    /**
     * The table associated with the model.
     */
    protected $table = 'vendor_associated_users';

    /**
     * Indicates if the model should be timestamped.
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['user_id', 'vendor_id'];

    /**
     * Foreign key with Vendor model
     */
    public function vendor()
    {
        return $this->belongsTo('App\Models\Vendor', 'vendor_id');
    }

    /**
     * Foreign key with User model
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    /**
     * Store
     *
     * @param  array  $data
     * @return bool
     */
    public static function store($userId, $vendorId = null)
    {
        if (isSuperAdmin()) {
            return false;
        }

        $vendorId = isset($vendorId) ? $vendorId : auth()->user()->vendor()?->vendor_id;

        $data = [
            'user_id' => $userId,
            'vendor_id' => $vendorId,
        ];

        return self::create($data);
    }
}
