<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('goods_receipt_items', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('goods_receipt_id');
            $table->unsignedBigInteger('barang_id');

            $table->integer('received_qty');
            $table->string('condition')->default('Good'); // Good, Broken, etc.

            $table->timestamps();

            $table->foreign('goods_receipt_id')
                  ->references('id')
                  ->on('goods_receipts')
                  ->onDelete('cascade');

            $table->foreign('barang_id')
                  ->references('id')
                  ->on('barang')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('goods_receipt_items');
    }
};
