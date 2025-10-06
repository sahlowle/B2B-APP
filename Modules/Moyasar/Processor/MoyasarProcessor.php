<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Muhammad AR Zihad <[zihad.techvill@gmail.com]>
 *
 * @created 06-02-2022
 */

namespace Modules\Moyasar\Processor;

use Illuminate\Support\Facades\Http;
use Modules\Gateway\Services\GatewayHelper;
use Modules\Moyasar\Entities\Moyasar as MoyasarModel;
use Modules\Moyasar\Response\MoyasarResponse;

use Modules\Gateway\Contracts\{
    PaymentProcessorInterface,
    RequiresCallbackInterface
};

class MoyasarProcessor implements PaymentProcessorInterface, RequiresCallbackInterface
{
    private $secret;

    private $key;

    private $helper;

    private $purchaseData;

    private $success_url;

    private $cancel_url;

    public function __construct()
    {
        $this->helper = GatewayHelper::getInstance();
    }

    
    public function pay($request)
    {

        $this->moyasarSetup($request);

        $charge = $this->charge();
        if (! $charge) {
            throw new \Exception(__('Payment Request failed due to some issues. Please try again later.'));
        }

        $this->setStripeSessionId($charge->id);

        return redirect($charge->url);
    }

    /**
     * Stripe data setup
     *
     * @param \Illuminate\Http\Request
     *
     * return mixed
     */
    private function moyasarSetup($request)
    {
        try {
            
            $this->key = $this->helper->getPaymentCode();
            $moyasar = MoyasarModel::firstWhere('alias', 'moyasar')->data;
            $this->secret = $moyasar->clientSecret;
            $this->purchaseData = $this->helper->getPurchaseData($this->key);
          

        } catch (\Exception $e) {
            paymentLog($e);

            throw new \Exception(__('Error while trying to setup moyasar.'));
        }
    }

  

    private function setStripeSessionId($id)
    {
        session(['stripe_session_id' => $id]);
    }

    private function getStripeSessionId()
    {
        return session('stripe_session_id');
    }

    public function validateTransaction($request)
    {
        $this->moyasarSetup($request);

        $line_item = $this->fetchPayment($request->id);

        return new MoyasarResponse($this->purchaseData, $line_item);
    }

    public function cancel($request)
    {
        throw new \Exception(__('Payment cancelled from stripe.'));
    }

    private function fetchPayment($id)
    {
        $url = 'https://api.moyasar.com/v1/payments/' . $id;
        Http::withBasicAuth($this->publishableKey,'')->get($url);
    }
}
