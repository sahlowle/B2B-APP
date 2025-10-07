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
    private $clientSecret;

    private $helper;

    private $purchaseData;

    private $baseUrl = 'https://api.moyasar.com/v1';


    public function __construct()
    {
        $this->helper = GatewayHelper::getInstance();
        $code = $this->helper->getPaymentCode();
        $this->purchaseData = $this->helper->getPurchaseData($code);

        $moyasar = MoyasarModel::firstWhere('alias', 'moyasar')->data;
        $this->clientSecret = $moyasar->clientSecret;
    }

    
    public function pay($request)
    {
        $payment_id = $request->payment_id;

        $this->purchaseData->payment_id = $payment_id;
        $this->purchaseData->save();

        $this->setMoyasarSessionId($payment_id);

        return response()->json(['success' => true, 'message' => 'Payment initiated successfully']);

    }
  
    private function setMoyasarSessionId($id)
    {
        session(['moyasar_session_id' => $id]);
    }

    private function getMoyasarSessionId()
    {
        return session('moyasar_session_id');
    }

    public function validateTransaction($request)
    {
        $line_item = $this->fetchPayment($request->id);

        return new MoyasarResponse($this->purchaseData, $line_item);
    }

    public function cancel($request)
    {
        throw new \Exception(__('Payment cancelled from stripe.'));
    }

    private function fetchPayment($paymentId)
    {
        $url = "{$this->baseUrl}/payments/{$paymentId}";

        $response = Http::withBasicAuth($this->clientSecret,'')->acceptJson()->get($url);

        if($response->failed()) {
            throw new \Exception(__('Payment failed from moyasar.'));
        }

        $payment = $response->object();

        return $payment;
    }

    public function refundPayment($paymentId)
    {
        try {
            $data = [];
           

            $response = Http::withBasicAuth($this->clientSecret, '')
                ->acceptJson()
                ->post("{$this->baseUrl}/payments/{$paymentId}/refund", $data);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json()
                ];
            }

            return [
                'success' => false,
                'message' => $response->json('message') ?? 'Refund failed'
            ];

        } catch (\Exception $e) {
            Log::error('Moyasar Refund Error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'An error occurred while processing refund'
            ];
        }
    }
}
