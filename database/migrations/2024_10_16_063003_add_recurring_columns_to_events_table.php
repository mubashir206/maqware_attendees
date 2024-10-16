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
        Schema::table('events', function (Blueprint $table) {
            //
            $table->boolean('is_recurring')->default(false); 
            $table->string('recurrence_type')->default('weekly'); 
            $table->json('recurrence_day')->nullable(); 
            $table->date('recurrence_until')->nullable(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            //

            $table->dropColumn(['is_recurring', 'recurrence_type','recurrence_day','recurrence_until']);
        });
    }
};
