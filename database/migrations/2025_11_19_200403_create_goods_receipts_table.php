<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('goods_receipts', function (Blueprint $table) {
            $table->id();

            $table->string('gr_number')->unique();
            $table->date('gr_date');

            $table->unsignedBigInteger('purchase_order_id');

            $table->string('received_by'); // nama pegawai
            $table->text('notes')->nullable();

            $table->timestamps();

            $table->foreign('purchase_order_id')
                  ->references('id')
                  ->on('purchase_orders')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('goods_receipts');
    }
};
