<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            if (! Schema::hasColumn('payments', 'payment_account_name')) {
                $table->string('payment_account_name')->nullable()->after('payment_method');
            }

            if (! Schema::hasColumn('payments', 'payment_account_number')) {
                $table->string('payment_account_number')->nullable()->after('payment_account_name');
            }

            if (! Schema::hasColumn('payments', 'bank_name')) {
                $table->string('bank_name')->nullable()->after('payment_account_number');
            }

            if (! Schema::hasColumn('payments', 'payment_reference')) {
                $table->string('payment_reference')->nullable()->after('bank_name');
            }

            if (! Schema::hasColumn('payments', 'card_last_four')) {
                $table->string('card_last_four', 4)->nullable()->after('payment_reference');
            }

            if (! Schema::hasColumn('payments', 'payment_note')) {
                $table->text('payment_note')->nullable()->after('card_last_four');
            }
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            foreach ([
                'payment_account_name',
                'payment_account_number',
                'bank_name',
                'payment_reference',
                'card_last_four',
                'payment_note',
            ] as $column) {
                if (Schema::hasColumn('payments', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};