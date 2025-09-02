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
        Schema::create('finance_records', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['gold', 'currency', 'fuel']);
            $table->string('name');
            $table->decimal('current_price', 10, 2);
            $table->decimal('previous_price', 10, 2);
            $table->decimal('change_percentage', 5, 2);
            $table->timestamp('last_updated');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('finance_records');
    }
};
