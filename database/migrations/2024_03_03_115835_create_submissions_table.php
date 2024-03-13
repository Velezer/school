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
        Schema::create('submissions', function (Blueprint $table) {
            $table->string("id")->primary();
            $table->string("file");
            $table->string("user_id");
            $table->string("assessment_id");
            $table->foreign("user_id")->references("id")->on("users");
            $table->foreign("assessment_id")->references("id")->on("assessments");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submissions');
    }
};
