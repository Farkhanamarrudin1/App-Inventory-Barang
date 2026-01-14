<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('purchase_request_items', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('purchase_request_id');
            $table->unsignedBigInteger('barang_id');

            $table->integer('qty');
            $table->string('unit')->default('pcs');

            $table->timestamps();

            // Foreign keys
            $table->foreign('purchase_request_id')
                  ->references('id')
                  ->on('purchase_requests')
                  ->onDelete('cascade');

            $table->foreign('barang_id')
                  ->references('id')
                  ->on('barang')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_request_items');
    }
};
