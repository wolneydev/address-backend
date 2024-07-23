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
        Schema::create('inspection', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('event_type');
            $table->longText('old_value');
            $table->string('table_name');
            $table->longText('new_value');
            $table->string('url');
            $table->string('ip_address');
            $table->string('user_agent');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspection');
    }
};
