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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('managerEmail');
            $table->string('managerFullName')->nullable();
            $table->string('managerGender')->nullable();
            $table->string('managerPhone')->nullable();
            $table->string('companyName')->nullable();
            $table->string('activity');
            $table->string('address');
            $table->integer('capital')->nullable();
            $table->enum('structure', ['SARL', 'SARL AU']);
            $table->enum('accountant', ['yes', 'no']);
            $table->enum('nonPartnerManager', ['yes', 'no']);
            $table->enum('delay_creation', ['none', 'week', 'month', 'soon']);
            $table->text('needs');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
