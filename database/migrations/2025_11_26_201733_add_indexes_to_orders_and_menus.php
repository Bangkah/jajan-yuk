<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('orders', function (Blueprint $table) {
        $table->index('user_id');
        $table->index('status');
        $table->index('created_at');
    });

    Schema::table('order_items', function (Blueprint $table) {
        $table->index('menu_id');
        $table->index('order_id');
    });

    Schema::table('menus', function (Blueprint $table) {
        $table->index('category_id');
        $table->index('is_available');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders_and_menus', function (Blueprint $table) {
            //
        });
    }
};
