<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('price_cis', 12, 2)->nullable()->after('price');
            $table->decimal('price_eu_am', 12, 2)->nullable()->after('price_cis');
            $table->decimal('price_af_au', 12, 2)->nullable()->after('price_eu_am');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['price_cis', 'price_eu_am', 'price_af_au']);
        });
    }
};
