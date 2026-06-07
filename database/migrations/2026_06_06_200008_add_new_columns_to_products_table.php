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
            $table->string('color')->nullable()->after('price');
            $table->string('material')->nullable()->after('color');
            $table->string('available_sizes')->nullable()->after('material');
            $table->unsignedInteger('delivery_duration')->nullable()->comment('in hours or days')->after('available_sizes');
            $table->string('fasil_method')->nullable()->after('delivery_duration');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['color', 'material', 'available_sizes', 'delivery_duration', 'fasil_method']);
        });
    }
};
