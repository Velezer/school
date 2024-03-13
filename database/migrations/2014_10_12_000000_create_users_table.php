<?php

use App\Models\User;
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
        Schema::create('users', function (Blueprint $table) {
            $table->string("id")->primary();
            $table->string('avatar')->nullable(true);
            $table->string('name');
            $table->string('password');
            $table->string('role');
            $table->string('address')->nullable(true);
            $table->string('gender')->nullable(true);
            $table->string('religion')->nullable(true);
            $table->string('dob')->nullable(true);
            $table->string('classroom')->nullable(true);
            $table->string('period')->nullable(true);
            $table->timestamps();


            // $table->id();
            // $table->string('name');
            // $table->string('email')->unique();
            // $table->timestamp('email_verified_at')->nullable();
            // $table->string('password');
            // $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
