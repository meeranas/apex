<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['debit', 'return_goods', 'discount']);
            $table->string('document_number');
            $table->date('transaction_date');
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->string('customer_name');
            $table->string('customer_city');
            $table->decimal('amount', 15, 2)->nullable();
            $table->string('payment_method')->nullable();
            $table->decimal('total_amount', 15, 2)->nullable();
            $table->text('remarks')->nullable();
            $table->string('issuer_name');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
