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
        Schema::create('extra_repayment_schedule', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loan_id')->constrained('loans')->onDelete('cascade');
            $table->integer('month_number');
            $table->decimal('starting_balance', 15, 2);
            $table->decimal('monthly_payment', 15, 2);
            $table->decimal('principal_component', 15, 2);
            $table->decimal('interest_component', 15, 2);
            $table->decimal('extra_payment', 15, 2)->default(0.00);
            $table->decimal('ending_balance', 15, 2);
            $table->integer('remaining_loan_term')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('extra_repayment_schedule', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::dropIfExists('extra_repayment_schedule');
    }
};
