<?php

namespace App\Http\Controllers\Website;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\TransactionService;

class TransactionController extends Controller
{
    private $service;

    public function __construct(TransactionService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('web.admin.reports.transactions.index');
    }

    public function show(Request $request)
    {
        return view('web.admin.reports.transactions.index',[
            'transactions'=>$this->service->getByDates($request),
            'fromDate' => $request->input('fromDate'),
            'toDate' => $request->input('toDate')
        ]);
    }
}
