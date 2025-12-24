<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            // Rename amount to total_amount for clarity
            $table->renameColumn('amount', 'total_amount');

            // Add paid and remaining amounts
            $table->decimal('amount_paid', 10, 2)->default(0)->after('amount');
            $table->decimal('remaining_amount', 10, 2)->default(0)->after('amount_paid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn(['amount_paid', 'remaining_amount']);
            $table->renameColumn('total_amount', 'amount');
        });
    }
};
