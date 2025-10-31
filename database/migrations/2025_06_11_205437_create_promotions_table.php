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
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->unsignedBigInteger('products_id')->nullable();  // promo ciblée produit
            $table->unsignedBigInteger('category_id')->nullable(); // promo ciblée catégorie
            $table->integer('reduction')->comment('Réduction en %');
            $table->date('date_debut');
            $table->date('date_fin');
            $table->timestamps();
            $table->foreign('products_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
