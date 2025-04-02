<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserPaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Muat user saat ini dengan relasi payments
        $user = Auth::user()->load('payments'); // Eager load relasi payments

        // Akses payments sebagai koleksi yang sudah dimuat
        $payments = $user->payments->sortBy('installment_number'); // Sort secara koleksi, bukan query builder
        $totalPaid = $user->payments->sum('amount');
        $annualFee = $user->annual_fee ?? 0;
        $remaining = $annualFee - $totalPaid;

        return view('users.payment.index', compact('user', 'payments', 'totalPaid', 'annualFee', 'remaining'));
    }

    public function submitPayment(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $user = Auth::user();
        $totalPaid = $user->payments()->sum('amount'); // Masih bisa gunakan query builder di sini
        $remaining = $user->annual_fee - $totalPaid;

        if ($request->amount > $remaining) {
            return redirect()->back()->with('error', 'Nominal pembayaran melebihi sisa biaya.');
        }

        if ($request->hasFile('proof')) {
            $proofPath = $request->file('proof')->store('proofs', 'public');
        }

        $nextInstallment = $user->payments()->max('installment_number') + 1 ?? 1;
        $payment = new Payment([
            'user_id' => $user->id,
            'amount' => $request->amount,
            'proof_path' => $proofPath ?? null,
            'payment_date' => now(),
            'status' => 'pending',
            'installment_number' => $nextInstallment,
            'due_date' => null, // Admin yang akan set batas waktu
        ]);
        $payment->save();

        return redirect()->back()->with('success', 'Pembayaran angsuran berhasil diajukan. Menunggu persetujuan admin.');
    }
}
