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
        Schema::table('subway', function (Blueprint $table) {
            $table->unsignedBigInteger('subwayline_id'); 
            $table->foreign('subwayline_id')->references('id')->on('subwaylines'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subway', function (Blueprint $table) {
            Schema::dropColumn('subwayline_id');
        });
    }
};
