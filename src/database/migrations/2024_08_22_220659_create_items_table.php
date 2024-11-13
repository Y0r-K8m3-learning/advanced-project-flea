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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('seller_id')->constrained(
                'users',
                'id'
            )->onDelete('cascade');
            $table->string('name');
            $table->integer(
                'price'
            );
            $table->integer('description');

            $table->unsignedBigInteger('item_category_id')->constrained(
                'item_category',
                'id'
            )->onDelete('cascade');
            $table->string('image_url');

            $table->boolean('sales_flg')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
