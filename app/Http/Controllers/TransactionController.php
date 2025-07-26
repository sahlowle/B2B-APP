<?php

namespace App\Http\Controllers;

use App\DataTables\TransactionListDataTable;
use App\Exports\TransactionListExport;
use App\Models\Transaction;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Excel;

class TransactionController extends Controller
{
    /**
     * Transaction List
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(TransactionListDataTable $dataTable)
    {
        $data['types'] = Transaction::select('transaction_type')->distinct()->get();

        $users = Transaction::where('user_id', '!=', null)->whereHas('user', function ($query) {
            $query->where('status', 'Active');
        });

        if ($users->exists()) {
            $data['users'] = $users->select('user_id')->distinct()->with('user:id,name')->get();
        }

        $vendorIds = Transaction::select('vendor_id')->where('vendor_id', '!=', null)->distinct()->pluck('vendor_id');
        $data['vendors'] = Vendor::select('id', 'name')->whereIn('id', $vendorIds)->get();

        $data['statuses'] = Transaction::select('status')->distinct()->get();

        return $dataTable->render('admin.transactions.index', $data);
    }

    /**
     * Transaction edit
     *
     * @param  Request  $request
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $data['transaction'] = Transaction::where('id', $id)->first();
        if (empty($data['transaction'])) {
            return redirect()->back()->withErrors(__('Transaction does not found.'));
        }

        return view('admin.transactions.edit', $data);
    }

    /**
     * Transaction update
     *
     * @param  int  $id
     * @return redirect view
     */
    public function update(Request $request, $id)
    {
        $validator = Transaction::updateValidation($request->all());
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $response = (new Transaction())->updateData($request->only('status'), $id);

        $this->setSessionValue($response);

        return redirect()->route('transaction.index');
    }

    /**
     * Transaction list pdf
     *
     * @return html static page
     */
    public function pdf()
    {
        $data['transactions'] = Transaction::getAll();

        return printPDF(
            $data,
            'transaction_list' . time() . '.pdf',
            'admin.transactions.pdf',
            view('admin.transactions.pdf', $data),
            'pdf'
        );
    }

    /**
     * Transaction list csv
     *
     * @return html static page
     */
    public function csv()
    {
        return Excel::download(new TransactionListExport(), 'transaction' . time() . '.csv');
    }
}
