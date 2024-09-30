<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('arrival', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('state');
            $table->string('city');
            $table->string('district');
            $table->string('block');
            $table->string('street');
            $table->string('lot');
            $table->string('description');
            $table->date('date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('arrival');
    }
};
