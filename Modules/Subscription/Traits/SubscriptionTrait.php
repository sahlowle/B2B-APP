<?php

/**
 * @package SubscriptionTrait
 * @author TechVillage <support@techvill.org>
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 * @created 16-02-2023
 */

 namespace Modules\Subscription\Traits;

use Modules\Subscription\Entities\PackageSubscription;
use Modules\Subscription\Entities\PackageSubscriptionMeta;

 trait SubscriptionTrait
 {
    /**
     * Success Status
     *
     * @var string
     */
    private string $successStatus = 'success';

    /**
     * Fail Status
     *
     * @var string
     */
    private string $failStatus = 'fail';

    /**
     * Get Instance
     *
     * @var object
     */
    protected static $instance;

    /**
     * Get Instance for subscription meta
     *
     * @var object
     */
    protected static $subscriptionMetaInstance;

    /**
     * Subscription meta feature
     *
     * @var string
     */
    protected static $subscriptionMetaFeature;

    /**
     * Old Subscription Id
     *
     * @var string
     */
    protected static $oldSubscriptionId;

    /**
     * Get data
     *
     * @return mix
     */
    public function __get($name)
    {
        $val = parent::__get($name);

        if ($val <> null) {
            return $val;
        }

        $data = $this->metadata()->where('key', $name)->first();

        if ($data) {
            return $data->value;
        }
    }

    /**
     * Get Instance
     *
     * @return object
     */
    public static function getInstance(string $type, int $id, bool $newInstance)
    {
        if ($newInstance || is_null(static::$instance) || static::$oldSubscriptionId != $id) {
            static::$oldSubscriptionId = $id;

            $filteredInstance = PackageSubscription::where($type, $id)->orderBy('id', 'desc')->first();

            // dd($filteredInstance);

            static::$instance = $filteredInstance;
        }

        return static::$instance;
    }

    /**
     * Feature Subscription Meta
     *
     * @return array
     */
    public static function featureSubscriptionMeta(int $subscription_id, string $feature)
    {
        if (is_null(static::$subscriptionMetaInstance) || static::$subscriptionMetaFeature != $feature) {
            static::$subscriptionMetaFeature = $feature;

            static::$subscriptionMetaInstance = PackageSubscriptionMeta::where('package_subscription_id', $subscription_id)
                ->where('type', 'feature_' . $feature)
                ->pluck('value', 'key')
                ->toArray();
        }

        return static::$subscriptionMetaInstance;
    }

    /**
     * Not found response
     *
     * @return array
     */
    protected function notFoundResponse(): array
    {
        return [
            'status' => $this->failStatus,
            'message' => __(':x does not exist.', ['x' => $this->service])
        ];
    }

    /**
     * Save success response
     *
     * @return array
     */
    protected function saveSuccessResponse(): array
    {
        return [
            'status' => $this->successStatus,
            'message' => __('The :x has been successfully saved.', ['x' => $this->service])
        ];
    }

    /**
     * Save fail response
     *
     * @return array
     */
    protected function saveFailResponse(): array
    {
        return [
            'status' => $this->failStatus,
            'message' => __('Failed to save :x, please try again.', ['x' => $this->service])
        ];
    }

    /**
     * Delete success response
     *
     * @return array
     */
    protected function deleteSuccessResponse(): array
    {
        return [
            'status' => $this->successStatus,
            'message' => __('The :x has been successfully deleted.', ['x' => $this->service])
        ];
    }

    /**
     * Delete fail response
     *
     * @return array
     */
    protected function deleteFailResponse(): array
    {
        return [
            'status' => $this->failStatus,
            'message' => __('Failed to delete :x, please try again.', ['x' => $this->service])
        ];
    }
 }
