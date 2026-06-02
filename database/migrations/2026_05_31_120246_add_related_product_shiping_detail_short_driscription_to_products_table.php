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
        Schema::table('products', function (Blueprint $table) {
            //
            $table->text('short_driscription')->nullable()->after('description');
            $table->text('shiping_details')->nullable()->after('short_driscription');
            $table->text('related_products')->nullable()->after('shiping_details');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            //
            $table->dropColumn([
                'short_driscription',
                'shiping_details',
                'related_products'
            ]);
            });
    }
};
