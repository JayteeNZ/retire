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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('customer_type');
            $table->string('email');
            $table->string('phone');
            $table->string('landline')->nullable();
            $table->string('preferred_name')->nullable();
            $table->timestamp('enquired_at');
            $table->string('description')->nullable();
            $table->string('source');
            $table->string('status');
            $table->foreignId('assigned_to')->nullable();
            $table->foreignId('assigned_by')->nullable();
            $table->foreignId('created_by')->nullable();
            $table->foreignId('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
