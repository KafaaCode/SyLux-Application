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
        Schema::table('categories', function (Blueprint $table) {
            foreach (['country_id', 'specialization_id', 'section_id'] as $column) {
                try {
                    $table->dropForeign(['' . $column]);
                } catch (\Throwable $e) {
                    // foreign key may not exist, ignore
                }
            }
        });

        Schema::table('categories', function (Blueprint $table) {
            foreach (['country_id', 'specialization_id', 'section_id'] as $column) {
                if (Schema::hasColumn('categories', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->foreignId('section_id')->nullable()->after('id')->constrained('sections')->cascadeOnDelete();
            $table->unsignedBigInteger('country_id')->nullable()->after('image');
            $table->unsignedBigInteger('specialization_id')->nullable()->after('country_id');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->foreign('specialization_id')->references('id')->on('specializations')->onDelete('cascade');
        });
    }
};
