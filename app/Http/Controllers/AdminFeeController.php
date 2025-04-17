<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminFeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('role:admin'); // Asumsi middleware role sudah ada
    }

    public function index()
    {
        $users = User::where('level', '!=', 'admin')->with('kos')->get();
        return view('admin.fees.index', compact('users'));
    }

    public function show($userId)
    {
        $user = User::findOrFail($userId);
        $payments = $user->payments()->orderBy('angsuran_ke')->get();
        return view('admin.fees.show', compact('user', 'payments'));
    }

    public function updateFee(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'annual_fee' => 'required|numeric|min:0',
        ]);

        $userId = $request->input('user_id');
        $annualFee = $request->input('annual_fee');

        $user = User::findOrFail($userId);
        $user->update(['annual_fee' => $annualFee]);

        return redirect()->back()->with('success', 'Biaya tahunan untuk ' . $user->nama_lengkap . ' berhasil diperbarui.');
    }

    public function setDueDate(Request $request)
    {
        $userId = $request->input('user_id');
        $installmentNumber = $request->input('installment_number');
        $dueDate = $request->input('due_date');

        $user = User::findOrFail($userId);
        $payment = $user->payments()->where('installment_number', $installmentNumber)->first();
        if ($payment) {
            $payment->update(['due_date' => $dueDate]);
        } else {
            $payment = new Payment([
                'user_id' => $userId,
                'installment_number' => $installmentNumber,
                'due_date' => $dueDate,
                'status' => 'pending',
                'payment_date' => null,
                'amount' => 0,
                'proof_path' => null,
            ]);
            $payment->save();
        }

        return redirect()->back()->with('success', 'Batas waktu angsuran ' . $installmentNumber . ' untuk ' . $user->nama_lengkap . ' berhasil diset.');
    }

    public function summary()
    {
        $users = User::where('level', '!=', 'admin')->with('payments')->get();
        return view('admin.fees.summary', compact('users'));
    }
}
