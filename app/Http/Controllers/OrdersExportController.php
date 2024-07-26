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
        $headers = [
                'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0'
            ,   'Content-type'        => 'text/csv'
            ,   'Content-Disposition' => 'attachment; filename=pedidos.csv'
            ,   'Expires'             => '0'
            ,   'Pragma'              => 'public'
        ];

        $orders = OrdersModel::all();
        
        $exportData = [];
        foreach($orders as $order) {
            $orderDetail = [];
            $orderDetail['IDVENDA'] = $order->id;
            $orderDetail['CARTELAS'] = $order->cardNumbers();
            $orderDetail['NOMECILENTE'] = $order->user->name;
            $orderDetail['FONECLIENTE'] = $order->user->phone;
            $orderDetail['CIDADE'] = $order->user->city;
            $orderDetail['VALOR'] = $order->price;
            $paymentStatus = "Aguardando Pagamento";
            if ($order->payment_status == 1)  {
                $paymentStatus = "Pago";
            } else if ($order->payment_status == 1)  {
                $paymentStatus = "Falha no pagamento";
            }
            $orderDetail['SITUACAO'] = $paymentStatus;
            $orderDetail['DATA'] = $order->created_at;
            $exportData[] = $orderDetail;
        }

        # add headers for each column in the CSV download
        array_unshift($exportData, array_keys($exportData[0]));

        $callback = function() use ($exportData) 
        {
            $FH = fopen('php://output', 'w');
            foreach ($exportData as $row) { 
                fputcsv($FH, $row, ";");
            }
            fclose($FH);
        };

        return response()->stream($callback, 200, $headers);
    //     return Excel::download(new OrdersExport, 'pedidos.csv', \Maatwebsite\Excel\Excel::CSV, [
    //         'Content-Type' => 'text/csv',
    //   ] );
    }
}
