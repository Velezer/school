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
        Schema::create('grades', function (Blueprint $table) {
            $table->string("id")->primary();
            $table->string("subject");
            $table->string("grade");
            $table->string("kkm");
            $table->string("class_rate");
            
            $table->string("report_id");
            $table->foreign("report_id")->references("id")->on("reports");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};
