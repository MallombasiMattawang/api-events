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
        Schema::create('event_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->references('id')->on('events')->cascadeOnDelete();
            $table->string('invoice');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('community')->nullable();
            $table->string('name_bib')->nullable();
            $table->string('email');
            $table->string('no_whatsapp');
            $table->foreignId('event_jersey_id')->references('id')->on('event_jerseys')->cascadeOnDelete();            
            $table->foreignId('event_category_id')->references('id')->on('event_categories')->cascadeOnDelete();
            $table->string('gender');
            $table->string('no_hp_emergency');
            $table->integer('payment')->nullable();
            $table->string('payment_receipt')->nullable();
            $table->string('status')->default('PENDING');
            $table->string('no_member')->nullable();
            $table->string('kode_paid')->nullable();
            $table->string('re_register')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_members');
    }
};
