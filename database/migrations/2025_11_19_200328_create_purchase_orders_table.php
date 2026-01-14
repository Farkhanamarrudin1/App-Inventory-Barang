<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();

            // Nomor PO unik
            $table->string('po_number')->unique();

            // Tanggal PO
            $table->date('po_date');

            // Relasi ke PR
            $table->unsignedBigInteger('purchase_request_id')->nullable();

            // Data supplier
            $table->string('supplier_name');
            $table->string('supplier_address')->nullable();

            // Status PO
            // Open = baru dibuat
            // Sent = dikirim ke supplier
            // Completed = sudah diterima (GR selesai)
            // Cancelled = dibatalkan
            $table->enum('status', ['Open', 'Sent', 'Completed', 'Cancelled'])
                  ->default('Open');

            $table->unsignedBigInteger('created_by')->nullable();

            $table->timestamps();

            // Foreign key ke PR
            $table->foreign('purchase_request_id')
                  ->references('id')
                  ->on('purchase_requests')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};
