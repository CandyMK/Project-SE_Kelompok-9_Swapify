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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // provider jasa
            $table->foreignId('requested_by')->nullable()->constrained('users')->onDelete('set null'); // user yang request
            $table->string('title');
            $table->text('description');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->integer('delivery_time');
            $table->string('status')->default('pending');
            $table->boolean('is_active')->default(true);

            // Deal
            $table->unsignedBigInteger('deal_with')->nullable();
            $table->boolean('is_dealed')->default(false);

            // Konfirmasi
            $table->boolean('provider_confirmed')->default(false);
            $table->boolean('requester_confirmed')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
