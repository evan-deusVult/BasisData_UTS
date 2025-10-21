<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\{Event, TicketType, Order, OrderItem, Payment};

class OrderController extends Controller
{
    public function addToCart(Request $request, Event $event)
    {
        $data = $request->validate([
            'ticket_type_id' => 'required|exists:ticket_types,id',
            'qty'            => 'required|integer|min:1'
        ]);

        $tt = TicketType::findOrFail($data['ticket_type_id']);
        $subtotal = $tt->price * $data['qty'];

        session(['cart' => [
            'event_id'       => $event->id,
            'ticket_type_id' => $tt->id,
            'qty'            => $data['qty'],
            'unit_price'     => $tt->price,
            'subtotal'       => $subtotal
        ]]);

        return redirect()->route('checkout');
    }

    public function checkout()
    {
        $cart = session('cart');
        abort_if(!$cart, 404);

        $event = Event::findOrFail($cart['event_id']);
        return view('checkout.index', compact('cart', 'event'));
    }

    public function history()
    {
    $user = auth('user')->user() ?? auth('lecturer')->user() ?? auth()->user();

    if (!$user) {
        return redirect()->route('login')->withErrors('Silakan login terlebih dahulu.');
    }

    // Ambil order milik user berdasarkan jenis akun
    $orders = Order::with(['orderItems.event', 'payment'])
        ->when(isset($user->role) && $user->role === 'lecturer', fn($q) => $q->where('lecturer_id', $user->id))
        ->when(isset($user->role) && $user->role === 'user', fn($q) => $q->where('user_id', $user->id))
        ->when(!isset($user->role) || $user->role === 'student', fn($q) => $q->where('student_id', $user->id))
        ->orderByDesc('created_at')
        ->get();

    return view('orders.history', compact('orders'));
    }

    public function placeOrder(Request $request)
    {
        $user = auth('user')->user() ?? auth('lecturer')->user() ?? auth()->user();
        if (!$user) {
            return redirect()->route('login')->withErrors('Harap login dulu sebelum memesan tiket.');
        }

        $cart = session('cart');
        abort_if(!$cart, 404);

        return DB::transaction(function () use ($cart, $user) {
            $orderData = [
                'code'         => 'FTMM-' . now()->format('Ymd') . '-' . Str::upper(Str::random(6)),
                'status'       => 'UNPAID',
                'total_amount' => $cart['subtotal'],
            ];
            // Set correct user id field
            if (isset($user->role) && $user->role === 'lecturer') {
                $orderData['lecturer_id'] = $user->id;
            } elseif (isset($user->role) && $user->role === 'user') {
                $orderData['user_id'] = $user->id;
            } else {
                $orderData['student_id'] = $user->id;
            }

            $order = Order::create($orderData);

            OrderItem::create([
                'order_id'       => $order->id,
                'event_id'       => $cart['event_id'],
                'ticket_type_id' => $cart['ticket_type_id'],
                'qty'            => $cart['qty'],
                'unit_price'     => $cart['unit_price'],
                'subtotal'       => $cart['subtotal'],
            ]);

            Payment::create([
                'order_id' => $order->id,
                'amount'   => $order->total_amount,
                'status'   => 'PENDING',
            ]);

            session()->forget('cart');

            return redirect()->route('payments.showBanks', $order->id)
                ->with('success', 'Order berhasil dibuat. Silakan lanjutkan ke pembayaran dan upload bukti transfer untuk mendapatkan e-ticket.');
        });
    }

    // Handle order dari form order-ticket.blade.php
    public function storeOrder(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'name' => 'required|string',
            'email' => 'required|email',
            'quantity' => 'required|integer|min:1'
        ]);

        // Deteksi user dari guard mana yang login
        $user = null;
        $userType = null;
        
        if (auth('web')->check()) {
            $user = auth('web')->user();
            $userType = 'student';
        } elseif (auth('lecturer')->check()) {
            $user = auth('lecturer')->user();
            $userType = 'lecturer';
        } elseif (auth('user')->check()) {
            $user = auth('user')->user();
            $userType = 'user';
        }

        if (!$user) {
            return redirect()->route('login')->withErrors('Harap login dulu sebelum memesan tiket.');
        }

        $event = Event::findOrFail($request->event_id);
        
        // Hitung total (asumsi event punya price atau pakai ticket_type pertama)
        $price = $event->price ?? 0;
        $totalAmount = $price * $request->quantity;

        return DB::transaction(function () use ($request, $user, $userType, $event, $totalAmount, $price) {
            $orderData = [
                'code'         => 'FTMM-' . now()->format('Ymd') . '-' . Str::upper(Str::random(6)),
                'status'       => 'UNPAID',
                'total_amount' => $totalAmount,
            ];

            // Set correct user id field based on user type
            if ($userType === 'lecturer') {
                $orderData['lecturer_id'] = $user->id;
            } elseif ($userType === 'user') {
                $orderData['user_id'] = $user->id;
            } else { // student
                $orderData['student_id'] = $user->id;
            }

            $order = Order::create($orderData);

            OrderItem::create([
                'order_id'       => $order->id,
                'event_id'       => $request->event_id,
                'ticket_type_id' => null, // atau ambil dari event jika ada
                'qty'            => $request->quantity,
                'unit_price'     => $price,
                'subtotal'       => $totalAmount,
            ]);

            Payment::create([
                'order_id' => $order->id,
                'amount'   => $order->total_amount,
                'status'   => 'PENDING',
            ]);

            return redirect()->route('payment.show', $order->id)
                ->with('success', 'Order berhasil dibuat. Silakan lanjutkan ke pembayaran.');
        });
    }
}
