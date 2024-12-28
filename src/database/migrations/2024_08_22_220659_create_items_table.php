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
        Schema::dropIfExists('items');
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('seller_id')->constrained(
                'users',
                'id'
            )->onDelete('cascade');
            $table->string('name');
            $table->string('brand');
            $table->integer(
                'price'
            );
            $table->string('description');

            $table->unsignedBigInteger('condition_id')->constrained(
                'condtions',
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
