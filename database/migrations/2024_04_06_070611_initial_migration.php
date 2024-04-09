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
            Schema::create("User", function(Blueprint $table) {
                $table->uuid("uuid")->primary()->unique();
                $table->string("Gender");
                $table->jsonb("Name");
                $table->jsonb("Location");
                $table->smallInteger("age");
                $table->timestamps();
            });

            Schema::create("DailyRecord", function(Blueprint $table) {
                $table->date("date");
                $table->integer("male_count");
                $table->integer("female_count");
                $table->integer("male_avg_age");
                $table->integer("female_avg_age");
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
