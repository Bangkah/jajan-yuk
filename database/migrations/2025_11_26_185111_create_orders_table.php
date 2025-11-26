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
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->decimal('total_price', 12, 2);
        $table->enum('status', ['new', 'processing', 'delivering', 'completed', 'cancelled'])->default('new');
        $table->enum('type', ['food', 'titip']);
        $table->text('notes')->nullable();
        $table->text('address')->nullable(); // hanya untuk titip beli
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
