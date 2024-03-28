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
        Schema::table('notifications', function (Blueprint $table) {
            // Add or modify columns here
            $table->integer('items')->nullable(); // Example: Adding a new integer column named 'items'
        });}
    //     Schema::update('notifications', function (Blueprint $table) {
            
    //         $table->int('items');
    // });}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
