@extends('layouts.vertical', ['title' => 'User Payment'])

@section('content')
    @include("layouts.shared/page-title", ["subtitle" => "User", "title" => "Pembayaran Angsuran"])

    <div class="bg-white p-6 rounded-xl shadow-lg max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Pembayaran Angsuran</h1>

        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg" role="alert">
                {{ session('success') }}
            </div>
        @elseif (session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg" role="alert">
                {{ session('error') }}
            </div>
        @endif

        <div class="mb-6 p-4 bg-gray-50 rounded-lg shadow-sm">
            <h3 class="text-lg font-semibold">Detail Pembayaran</h3>
            <p>Biaya Tahunan: Rp {{ number_format($annualFee, 0, ',', '.') }}</p>
            <p>Total Dibayar: Rp {{ number_format($totalPaid, 0, ',', '.') }}</p>
            <p>Sisa Pembayaran: Rp {{ number_format($remaining, 0, ',', '.') }}</p>
        </div>

        <div class="mb-6 p-4 bg-gray-50 rounded-lg shadow-sm">
            <h3 class="text-lg font-semibold">Riwayat Angsuran</h3>
            @if ($payments->isEmpty())
                <p>Tidak ada riwayat angsuran.</p>
            @else
                <ul>
                    @foreach ($payments as $payment)
                        <li>Angsuran {{ $payment->installment_number }}: Rp {{ number_format($payment->amount, 0, ',', '.') }} ({{ $payment->status }}, Tanggal: {{ $payment->payment_date }})</li>
                    @endforeach
                </ul>
            @endif
        </div>

        <form action="{{ route('user.payment.submit') }}" method="POST" enctype="multipart/form-data" class="mt-6">
            @csrf
            <div class="mb-4">
                <label for="amount" class="block text-sm font-medium text-gray-700">Nominal Pembayaran</label>
                <input type="number" name="amount" id="amount" class="w-full p-3 border border-gray-300 rounded-lg" step="1000" min="0" required>
            </div>
            <div class="mb-4">
                <label for="proof" class="block text-sm font-medium text-gray-700">Bukti Transfer</label>
                <input type="file" name="proof" id="proof" class="w-full p-3 border border-gray-300 rounded-lg" accept="image/*,application/pdf">
            </div>
            <button type="submit" class="bg-blue-600 text-white py-3 px-6 rounded-lg hover:bg-blue-700">Ajukan Pembayaran</button>
        </form>
    </div>
@endsection