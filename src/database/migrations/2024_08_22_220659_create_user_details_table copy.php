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

        Schema::create('users_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->constrained(
                'users',
                'id'
            )->onDelete('cascade');
            $table->string('image_id')->nullable();
            $table->string('post_code')->nullable();
            $table->string(
                'address'
            )->nullable();
            $table->string('building')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_details');
    }
};
