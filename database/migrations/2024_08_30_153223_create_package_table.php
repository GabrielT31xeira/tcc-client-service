<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('package', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('width');
            $table->string('height');
            $table->string('weight');
            $table->string('fragility');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('package');
    }
};
