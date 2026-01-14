<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE purchase_orders MODIFY status ENUM('Open','Sent','Completed','Cancelled') DEFAULT 'Open'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE purchase_orders MODIFY status ENUM('Pending','Sent','Completed','Cancelled') DEFAULT 'Pending'");
    }
};
