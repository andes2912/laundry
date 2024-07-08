<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Services\OrderService;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function order(Request $request)
    {
        return $this->orderService->order($request);
    }

    public function listTransaksi()
    {
        return $this->orderService->listTransaksi();
    }

    public function listLaundry()
    {
        return $this->orderService->listLaundry();
    }

    public function listHarga(Request $request)
    {
        return $this->orderService->listHarga($request);
    }
}
