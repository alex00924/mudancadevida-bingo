<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \DateTime;
use Efi\EfiPay;
use Efi\Exception\EfiException;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            if (auth()->user()->hasRole("admin")) {
                return redirect(route("admin.order.list"));
            }
            if (auth()->user()->hasRole("seller")) {
                return redirect(route("seller.order.list"));
            }
        }
        return redirect(route("order.new"));
    }

    public function checkPaymentStatus() {
        $date = new DateTime;
        $date->modify('-5 minutes');
        $formatted_date = $date->format('Y-m-d H:i:s');

        $orders = \App\Models\Orders::where('payment_status', 0)->where('created_at', '<=', $formatted_date)->get();

        \MercadoPago\SDK::setAccessToken(env('PIX_ACCESS_TOKEN'));

        foreach($orders as $order) {
            $paymentResult = \MercadoPago\SDK::get("/v1/payments/$order->payment_id");
            $status = '';
            try {
                $status = $paymentResult['body']['status'];
            } catch (\Exception) {}

            if ($status == 'approved') {
                $order->payment_status = 1;
                $order->save();
            } else {
                $order->orderDetails()->delete();
                $order->delete();
            }
        }
    }

    public function checkEFIPaymentStatus() {
        $date = new DateTime;
        $date->modify('-5 minutes');
        $formatted_date = $date->format('Y-m-d H:i:s');
        $efi = new EfiPay(config('efi'));   // config holds clientId/secret/cert/sandbox/scope

        $orders = \App\Models\Orders::where('payment_status', 0)->where('created_at', '<=', $formatted_date)->get();

        foreach($orders as $order) {
            $status = '';
            try {
                $resp = $efi->pixDetailCharge(['txid' => $order->payment_id]);
                $status = $resp['status'];
            } catch (\Exception) {}

            if ($status == 'CONCLUIDA') {
                $order->payment_status = 1;
                $order->save();
            } else {
                $order->orderDetails()->delete();
                $order->delete();
            }
        }
    }
}
