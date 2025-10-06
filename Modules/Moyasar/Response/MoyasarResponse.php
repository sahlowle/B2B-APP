<?php



namespace Modules\Moyasar\Response;

use Modules\Gateway\Contracts\HasDataResponseInterface;
use Modules\Gateway\Response\Response;

class MoyasarResponse extends Response implements HasDataResponseInterface
{
    protected $response;

    private $data;

    public function __construct($data, $moyasarResponse)
    {
        $this->data = $data;
        $this->response = $moyasarResponse->jsonSerialize();
        $this->updateStatus();

        return $this;
    }

    public function getRawResponse(): string
    {
        return json_encode($this->response);
    }

    protected function updateStatus()
    {
        if ($this->response['status'] == 'complete') {
            $this->setPaymentStatus('completed');
        } else {
            $this->setPaymentStatus('failed');
        }
    }

    public function getResponse(): string
    {
        return json_encode($this->getSimpleResponse());
    }

    private function getSimpleResponse()
    {
        return [
            'amount' => $this->response['amount_total'] / 100,
            'amount_captured' => $this->response['amount_total'] / 100,
            'currency' => $this->response['currency'],
            'code' => $this->data->code,
        ];
    }

    public function getGateway(): string
    {
        return 'Stripe';
    }

    protected function setPaymentStatus($status)
    {
        $this->status = $status;
    }
}
