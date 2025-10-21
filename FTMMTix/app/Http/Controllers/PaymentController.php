<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\{Order, Bank, Payment, Ticket};
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    // Halaman payment untuk pilih bank dan upload bukti
    public function showPayment(Order $order)
    {
        $order->load('orderItems.event'); // Eager load relasi event
        $banks = Bank::where('is_active', true)->get();
        return view('payments.payment', compact('order', 'banks'));
    }

    // Upload bukti pembayaran
    public function uploadProof(Request $request, Order $order)
    {
        $request->validate([
            'bank_id' => 'required|exists:banks,id',
            'proof' => 'required|image|max:2048'
        ]);

        return DB::transaction(function() use ($order, $request) {
            // Upload bukti
            $proofPath = null;
            if ($request->hasFile('proof')) {
                $proofPath = $request->file('proof')->store('payment_proofs', 'public');
            }

            // Update payment
            $order->payment()->updateOrCreate(
                ['order_id' => $order->id],
                [
                    'bank_id' => $request->bank_id,
                    'amount' => $order->total_amount,
                    'status' => 'PAID',
                    'paid_at' => now(),
                    'proof_path' => $proofPath,
                ]
            );

            // Update order status
            $order->update(['status' => 'PAID']);

            // Generate tickets
            $item = $order->orderItems()->first();
            if ($item) {
                for($i = 0; $i < $item->qty; $i++) {
                    Ticket::create([
                        'order_id' => $order->id,
                        'event_id' => $item->event_id,
                        'code' => strtoupper(uniqid('FTMM')) . $i,
                    ]);
                }
            }

            return redirect()->route('payment.eticket', $order->id);
        });
    }

    // Tampilkan e-ticket
    public function showEticket($orderId)
    {
        $order = Order::with(['orderItems.event', 'student', 'lecturer', 'user'])->findOrFail($orderId);
        return view('payments.eticket', compact('order'));
    }

    public function showBanks(Order $order){
        $banks = Bank::where('is_active',true)->get();
        $payment = $order->payment;
        return view('payments.banks', compact('order','payment','banks'));
    }

    public function chooseBank(Request $request, Order $order){
        $data = $request->validate(['bank_id'=>'required|exists:banks,id']);
        $order->payment->update(['bank_id'=>$data['bank_id'],'status'=>'AWAITING_CONFIRMATION']);
        return back()->with('ok','Silakan transfer sesuai nominal lalu unggah bukti.');
    }

    public function confirmTransfer(Request $request, Order $order){
        $request->validate(['transfer_ref'=>'required|string']);
        return DB::transaction(function() use ($order,$request){
            $order->payment->update([
                'status'=>'PAID',
                'paid_at'=>now(),
                'transfer_ref'=>$request->transfer_ref,
            ]);
            $order->update(['status'=>'PAID']);
            // generate one ticket per qty
            $item = $order->items()->first();
            for($i=0; $i<$item->qty; $i++){
                Ticket::create([
                    'order_id'=>$order->id,
                    'event_id'=>$item->event_id,
                    'code'=> strtoupper(uniqid('FTMM')).$i,
                ]);
            }
            return redirect()->route('tickets.show', $order);
        });
    }
}

