<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('managerFullName');
            $table->string('managerAddress');
            $table->string('managerCardId');
            $table->string('managerBirth');
            $table->enum('legalStatus', ['SARL', 'SARL AU']);
            $table->enum('signing', ['conjoint', 'single']);
            $table->string('companyName')->nullable();
            $table->string('companyAddress')->nullable();
            $table->integer('capital')->nullable();
            $table->foreignId('activity_id')->constrained()->cascadeOnDelete();
            $table->foreignId('city_id')->constrained()->cascadeOnDelete();
            $table->enum('status', ['in progress', 'created', 'rejected', 'canceled']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
