<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Orders as OrdersModel;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;
// use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class OrdersExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $orders = OrdersModel::all();
        
        $exportData = [];
        foreach($orders as $order) {
            $orderDetail = [];
            $orderDetail['IDVENDA'] = $order->id;
            $orderDetail['CARTELAS'] = $order->cardNumbers();
            $orderDetail['NOMECILENTE'] = $order->user->name;
            $orderDetail['FONECLIENTE'] = $order->user->phone;
            $orderDetail['VALOR'] = $order->price;
            $orderDetail['DATA'] = $order->created_at;
            $exportData[] = $orderDetail;
        }

        return new Collection($exportData);
    }

    public function headings(): array
    {
        return ["IDVENDA", "CARTELAS", "NOMECILENTE", "FONECLIENTE" , "VALOR", "DATA"];
    }
}
