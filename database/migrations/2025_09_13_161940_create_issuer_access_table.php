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
        Schema::create('issuer_access', function (Blueprint $table) {
            $table->id();
            $table->foreignId('issuer_id')->constrained('issuers')->onDelete('cascade');
            $table->foreignId('can_view_id')->constrained('issuers')->onDelete('cascade');
            $table->timestamps();
            $table->unique(['issuer_id', 'can_view_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('issuer_access');
    }
};
