<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Muhammad AR Zihad <[zihad.techvill@gmail.com]>
 *
 * @created 06-02-2022
 */

namespace Modules\Moyasar\Views;

use Modules\Gateway\Contracts\PaymentViewInterface;
use Modules\Gateway\Services\GatewayHelper;
use Modules\Gateway\Traits\ApiResponse;
use Modules\Moyasar\Entities\Moyasar;

class MoyasarView implements PaymentViewInterface
{
    use ApiResponse;

    public static function paymentView($key)
    {
        $helper = GatewayHelper::getInstance();

        try {

            $purchaseData = $helper->getPurchaseData($key);
            $price = $purchaseData->total;

            if($purchaseData->currency_code == 'SAR') {
                $price =  intval(round(($price * 100)));
            } else {
                $price =  intval(round(($price)));
            }

            $moyasar = Moyasar::firstWhere('alias', 'moyasar')->data;

            return view('moyasar::pay', [
                'publishableKey' => $moyasar->publishableKey,
                'instruction' => $moyasar->instruction,
                'purchaseData' => $purchaseData,
                'price' => $price,
            ]);
            
        } catch (\Exception $e) {
            return back()->withErrors(['error' => __('Purchase data not found.')]);
        }
    }

    public static function paymentResponse($key)
    {
        $helper = GatewayHelper::getInstance();

        $stripe = Stripe::firstWhere('alias', 'stripe')->data;

        return [
            'publishableKey' => $stripe->publishableKey,
            'instruction' => $stripe->instruction,
            'purchaseData' => $helper->getPurchaseData($key),
        ];
    }
}
