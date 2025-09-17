<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use Illuminate\Http\Request;

class AdminQuotationController extends Controller
{
    public function index()
    {
        return view('admin.quotations.index');
    }

    public function show(Quotation $quotation)
    {
        return view('admin.quotations.show', compact('quotation'));
    }
}
