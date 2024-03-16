<?php

namespace App\Http\Controllers\Website;

use Illuminate\Http\Request;
use App\Services\GrossService;
use App\Http\Controllers\Controller;

class GrossController extends Controller
{
    private $service;

    public function __construct(GrossService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('web.admin.reports.grosses.index');
    }

    public function show(Request $request)
    {
        return view('web.admin.reports.grosses.index',[
            'grosses'=>$this->service->getByDates($request),
            'fromDate' => $request->input('fromDate'),
            'toDate' => $request->input('toDate')
        ]);
    }
}
