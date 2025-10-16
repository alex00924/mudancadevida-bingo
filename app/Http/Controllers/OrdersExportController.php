<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Exports\OrdersExport;
// use Maatwebsite\Excel\Facades\Excel;
use App\Models\Orders as OrdersModel;

class OrdersExportController extends Controller
{
    public function export()
    {
        // Increase memory and execution time for large exports
        ini_set('memory_limit', '512M');
        set_time_limit(0);

        $headers = [
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Content-type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename=pedidos.csv',
            'Expires'             => '0',
            'Pragma'              => 'public',
        ];

        $isAdmin = auth()->user()->hasRole('admin');

        $callback = function() use ($isAdmin) {
            // Disable output buffering for streaming
            if (function_exists('ob_end_clean')) {
                while (ob_get_level() > 0) {
                    ob_end_clean();
                }
            }
            $FH = fopen('php://output', 'w');
            // Write CSV header
            $header = [
                'IDVENDA',
                'CARTELAS',
                'NOMECILENTE',
                'FONECLIENTE',
                'CIDADE',
                'VENDEDOR',
                'VALOR',
                'SITUACAO',
                'DATA',
            ];
            fputcsv($FH, $header, ";");

            $query = OrdersModel::query();
            if (!$isAdmin) {
                $query->where('seller_id', auth()->user()->id);
            }

            $query->chunk(50, function($orders) use ($FH) {
                foreach ($orders as $order) {
                    $orderDetail = [];
                    $orderDetail['IDVENDA'] = $order->id;
                    $orderDetail['CARTELAS'] = method_exists($order, 'cardNumbers') ? $order->cardNumbers() : '';
                    $orderDetail['NOMECILENTE'] = $order->user->name ?? '';
                    $orderDetail['FONECLIENTE'] = $order->user->phone ?? '';
                    $orderDetail['CIDADE'] = $order->user->city ?? '';
                    $orderDetail['VENDEDOR'] = empty($order->seller) ? "Site" : ($order->seller->name ?? '');
                    $orderDetail['VALOR'] = $order->price;
                    $paymentStatus = "Aguardando Pagamento";
                    if ($order->payment_status == 1) {
                        $paymentStatus = "Pago";
                    } else if ($order->payment_status == 2) {
                        $paymentStatus = "Falha no pagamento";
                    }
                    $orderDetail['SITUACAO'] = $paymentStatus;
                    $orderDetail['DATA'] = $order->created_at;
                    fputcsv($FH, $orderDetail, ";");
                }
                // Flush output buffer to avoid memory issues
                if (function_exists('flush')) {
                    flush();
                }
            });
            fclose($FH);
        };

        return response()->stream($callback, 200, $headers);
    //     return Excel::download(new OrdersExport, 'pedidos.csv', \Maatwebsite\Excel\Excel::CSV, [
    //         'Content-Type' => 'text/csv',
    //   ] );
    }
}
