<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('wallet_transactions', function (Blueprint $table) {
            // Menambahkan metode pembayaran dan foto bukti transfer
            $table->string('payment_method')->nullable()->after('amount');
            $table->string('proof_image')->nullable()->after('payment_method');
        });
    }

    public function down(): void
    {
        Schema::table('wallet_transactions', function (Blueprint $table) {
            $table->dropColumn(['payment_method', 'proof_image']);
        });
    }
};