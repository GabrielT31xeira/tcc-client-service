<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('delivery', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('exit_id')->nullable()->constrained('exit')->nullOnDelete();
            $table->foreignUuid('arrival_id')->nullable()->constrained('arrival')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('delivery');
    }
};
