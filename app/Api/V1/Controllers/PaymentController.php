<?php

namespace App\Api\V1\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Order;
use App\Payment;

class PaymentController extends Controller
{

    public function index($invoice)
    {
        $order = Order::where('invoice', $invoice)->firstOrFail();
        return response()->json(['order' => $order]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'invoice' => 'required|exists:orders,invoice',
            'name' => 'required',
            'transfer_to' => 'required',
            'transfer_date' => 'required',
            'amount' => 'required'            
        ]);

        $order = Order::where('invoice', $request->invoice)->first();

        if($order->sub_total != $request->amount) return response()->json(['status' => 'Error, Pembayaran harus sama dengan tagihan'], 422);
        if($order->status === 'UNPAY') {
            $payment = Payment::create([
                'order_id' => $request->order_id,
                'name' => $request->name,
                'transfer_to' => $request->transfer_to,
                'transfer_date' => Carbon::parse($request->transfer_date)->format('Y-m-d'),
                'amount' => $request->amount,
            ]);
            $order->update(['status' => 'PAYED']);

            return response()->json(['status' => 'Pesanan Berhasil di bayar']);
        }

        return response()->json(['status' => 'Pesanan Sudah Pernah Di Bayar']);
    }

}
