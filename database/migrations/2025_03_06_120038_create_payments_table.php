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
            $table->decimal('jumlah', 10, 2); // Nominal pembayaran
            $table->string('bukti_tf')->nullable(); // Path bukti transfer
            $table->date('tanggal'); // Tanggal pembayaran
            $table->enum('status', ['pending', 'diterima', 'ditolak'])->default('pending');
            $table->integer('angsuran_ke'); // Nomor angsuran
            $table->date('due_date'); // Batas waktu angsuran
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
