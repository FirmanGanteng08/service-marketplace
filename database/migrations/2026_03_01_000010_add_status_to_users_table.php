<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Menambahkan kolom status, phone, dan avatar
            $table->string('status')->default('active')->after('role');
            $table->string('phone')->nullable()->after('status');
            $table->string('avatar')->nullable()->after('phone');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Menghapus kolom jika migrasi di-rollback
            $table->dropColumn(['status', 'phone', 'avatar']);
        });
    }
};