<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('package_delivery', function (Blueprint $table) {
            $table->foreignUuid('package_id')->constrained('package')->onDelete('cascade');
            $table->foreignUuid('delivery_id')->constrained('delivery')->onDelete('cascade');
            $table->primary(['package_id', 'delivery_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('package_delivery');
    }
};
