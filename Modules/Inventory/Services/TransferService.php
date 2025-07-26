<?php

namespace Modules\Inventory\Services;

use App\Models\Product;
use Modules\Inventory\Entities\Log;
use Modules\Inventory\Entities\Purchase;
use Modules\Inventory\Entities\StockManagement;
use DB;
use Modules\Inventory\Entities\Transfer;
use Modules\Inventory\Entities\TransferDetail;

class TransferService
{
    public static $instance;

    protected $request;

    protected $vendorId = null;

    protected $fromLocationId = null;

    /**
     * purchase service instance
     *
     * @return PurchaseService
     */
    public static function getInstance($request = null, $vendorId = null, $fromLocationId = null)
    {
        if (self::$instance == null) {
            self::$instance = new TransferService($request, $vendorId, $fromLocationId);
        }

        return self::$instance;
    }

    /**
     * constructor
     */
    public function __construct($request = null, $vendorId = null, $fromLocationId = null)
    {
        $this->request = $request;
        $this->vendorId = $vendorId;
        $this->fromLocationId = $fromLocationId;
    }

    /**
     * product search
     *
     * @return \Illuminate\Http\JsonResponse\
     */
    public function search()
    {
        $data['status']  = 0;
        $data['message']    = __('No Item Found');
        $vendorId = $this->vendorId;
        $locationId = $this->fromLocationId;
        $request = $this->request;
        $search = $request->search;

        $response = StockManagement::select('*', DB::raw('sum(quantity) as available'))
            ->whereHas('product', function ($q) use ($search) {
                $q->whereLike('name', $search)->where('manage_stocks', 1);
            })
            ->whereHas('location', function ($q) use ($vendorId) {
                $q->where('vendor_id', $vendorId);
            })->with('location')
            ->where('location_id', $locationId)
            ->whereIn('type', stockKeyword())
            ->groupBy('product_id')
            ->get()
            ->map(function ($products) {
                if ($products->available > 0) {
                    return [
                        'id' => $products->product_id,
                        'name' => $products->product?->name,
                        'sku' => $products->product?->sku ?? '',
                        'total_quantity' => $products->available,
                    ];
                }
            });

        if (! $response->isEmpty()) {
            $data['status'] = 1;
            $data['message'] = __('Product Found');
            $data['products'] = $response;
        }

        return response()->json($data);
    }

    public function transferStore(): array
    {
        $response = ['status' => true];

        try {
            DB::beginTransaction();
            $reference = Transfer::getTransferReference();
            $request = $this->request;
            $transferDetails = [];
            $stockManagement = [];

            $productReq = collect($this->request->product_qty);
            $totalQty = $productReq->sum(function ($value) {
                return $value;
            });

            $transfer = [
                'reference' => $reference,
                'vendor_id' => $this->vendorId,
                'from_location_id' => $request->from_location_id,
                'to_location_id' => $request->to_location_id,
                'shipping_carrier' => $request->shipping_carrier,
                'tracking_number' => $request->tracking_number,
                'arrival_date' => $request->arrival_date,
                'note' => $request->note,
                'quantity' => $totalQty,
                'status' => 'Pending',
            ];

            $transferId = Transfer::store($transfer);

            $transfer['transfer_id'] = $transferId;
            $transfer['transaction_type'] = 'transfer_store';
            $transfer['log_type'] = 'transfer';
            $this->logStore($transfer);

            if ($transferId) {

                foreach ($request->product_id as $key => $productId) {

                    $transferDetails[] = [
                        'transfer_id' => $transferId,
                        'product_id' => $productId,
                        'quantity' => $request->product_qty[$key],
                    ];

                    $stockManagement[] = [
                        'location_id' => $request->from_location_id,
                        'product_id' => $productId,
                        'quantity' => -($request->product_qty[$key]),
                        'type' => 'transfer',
                        'date' => DbDateFormat(date('Y-m-d')),
                        'status' => 'approve',
                    ];

                    $log = [
                        'location_id' => $request->from_location_id,
                        'product_id' => $productId,
                        'transfer_id' => $transferId,
                        'quantity' => -($request->product_qty[$key]),
                        'transaction_type' => 'moved',
                        'log_type' => 'transfer',
                    ];

                    $this->logStore($log);

                }

                StockManagement::store($stockManagement);
                TransferDetail::store($transferDetails);
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $response = ['status' => false, 'message' => $e->getMessage()];
        }

        return $response;
    }

    /**
     * store log
     *
     * @return false
     */
    protected function logStore($data)
    {
        $data['transaction_date'] = DbDateFormat(date('Y-m-d'));
        $response = Log::store($data);

        return $response;
    }

    public function updateTransfer($id): array
    {
        $response = ['status' => true];

        try {
            DB::beginTransaction();

            $request = $this->request;
            $existsProduct = TransferDetail::where('transfer_id', $id)->pluck('product_id', 'id')->toArray();
            $swap = array_flip($existsProduct);
            $updateProduct = [];

            $transferDetails = [];
            $productReq = collect($this->request->product_qty);
            $totalQty = $productReq->sum(function ($value) {
                return $value;
            });

            $transfer = [
                'from_location_id' => $request->from_location_id,
                'to_location_id' => $request->to_location_id,
                'shipping_carrier' => $request->shipping_carrier,
                'tracking_number' => $request->tracking_number,
                'arrival_date' => $request->arrival_date,
                'note' => $request->note,
                'quantity' => $totalQty,
            ];

            $transferId = Transfer::updateTransfer($transfer, $id);

            $transfer['transfer_id'] = $id;
            $transfer['transaction_type'] = 'transfer_update';
            $transfer['log_type'] = 'transfer';
            $this->logStore($transfer);

            if ($transferId) {

                foreach ($request->product_id as $key => $productId) {
                    $updateProduct[] = $productId;

                    if (in_array($productId, $existsProduct)) {
                        $updateDetailData = [
                            'product_id' => $productId,
                            'quantity' => $request->product_qty[$key],
                        ];

                        TransferDetail::updateTransferDetail($updateDetailData, $swap[$productId]);
                    } else {
                        $transferDetails[] = [
                            'transfer_id' => $id,
                            'product_id' => $productId,
                            'quantity' => $request->product_qty[$key],
                        ];
                    }
                }

                if (count($transferDetails) > 0) {
                    TransferDetail::store($transferDetails);
                }

                foreach ($existsProduct as $existsId) {
                    if (! in_array($existsId, $updateProduct)) {
                        TransferDetail::remove($swap[$existsId]);
                    }
                }
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $response = ['status' => false, 'message' => $e->getMessage()];
        }

        return $response;
    }

    public function receiveReject($transferId = null): array
    {
        $response = ['status' => true];
        $transfer = Transfer::where('id', $transferId)->first();

        try {
            DB::beginTransaction();

            $request = $this->request;
            $stock = [];
            $updateQty = 0;

            foreach ($request->products['receive'] as $key => $data) {

                $transferDetails = TransferDetail::where('id', $key)->first();
                $orderQty = $transferDetails->quantity;
                $addedQty = $data + $request->products['reject'][$key];
                $oldRec = $transferDetails->quantity_receive ?? 0;
                $oldRej = $transferDetails->quantity_reject ?? 0;
                $addedQty = $oldRec + $oldRej;

                if ($addedQty > $orderQty) {
                    $response = ['status' => false, 'message' => __('Sum of receive reject value not more that order quantity!')];

                    return $response;
                }

                if ($request->products['reject'][$key] > 0) {

                    $updateQty += $transferDetails->quantity_reject + $request->products['reject'][$key];

                    if (empty($transferDetails->quantity_reject)) {
                        $transferDetails->quantity_reject = $request->products['reject'][$key];
                    } else {
                        $transferDetails->incrementReject($request->products['reject'][$key]);
                    }

                    $log = [
                        'location_id' => $transferDetails->transfer->to_location_id,
                        'product_id' => $transferDetails->product_id,
                        'transfer_id' => $transferDetails->transfer->id,
                        'quantity' => -($request->products['reject'][$key]),
                        'transaction_type' => 'transfer_reject',
                        'log_type' => 'receive_reject',
                    ];

                    $this->logStore($log);
                } else {
                    $updateQty += $transferDetails->quantity_reject;
                }

                if ($data > 0) {

                    $updateQty += $transferDetails->quantity_receive + $data;

                    if (empty($transferDetails->quantity_receive)) {
                        $transferDetails->quantity_receive = $data;
                    } else {
                        $transferDetails->incrementReceive($data);
                    }

                    $stock[] = [
                        'location_id' => $transferDetails->transfer->to_location_id,
                        'product_id' => $transferDetails->product_id,
                        'quantity' => $data,
                        'type' => 'transfer',
                        'date' => DbDateFormat(date('Y-m-d')),
                        'status' => 'approve',
                    ];

                    $log = [
                        'location_id' => $transferDetails->transfer->to_location_id,
                        'product_id' => $transferDetails->product_id,
                        'transfer_id' => $transferDetails->transfer->id,
                        'quantity' => $data,
                        'transaction_type' => 'transfer_receive',
                        'log_type' => 'receive_reject',
                    ];

                    $this->logStore($log);
                } else {
                    $updateQty += $transferDetails->quantity_receive;
                }

                $transferDetails->save();
            }

            StockManagement::store($stock);

            if ($updateQty > $transfer->quantity) {
                $response = ['status' => false, 'message' => __('Quantity mismatch with order quantity!')];

                return $response;
            }

            if ($transfer->status == 'Pending' && $updateQty > 0) {
                $transfer->status = 'Partial';
                $transfer->save();
            }

            if ($transfer->quantity == $updateQty && $updateQty > 0) {
                $transfer->status = 'Received';
                $transfer->save();
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $response = ['status' => false, 'message' => $e->getMessage()];
        }

        return $response;
    }
}
