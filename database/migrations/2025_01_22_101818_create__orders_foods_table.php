<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders_foods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOndelete();
            $table->foreignId('products_id')->constrained('products')->cascadeOndelete();
            $table->integer("quantity");
             $table->decimal("prix_order", 10, 2);
            $table->enum('statut',["en_attente","en_livraison","annuler","livrer"])->default("en_attente");
            $table->dateTime('delivery_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders_foods');
    }
};
