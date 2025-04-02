<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 10, 2); // Nominal pembayaran
            $table->string('proof_path')->nullable(); // Path bukti transfer
            $table->date('payment_date'); // Tanggal pembayaran
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->integer('installment_number'); // Nomor angsuran
            $table->date('due_date'); // Batas waktu angsuran
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
