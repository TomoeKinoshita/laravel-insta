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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();  // unique. you cannot have multiple users with the same email. users must have unique email.
            // $table->timestamp('email_verified_at')->nullable();
            $table->longText('avatar')->nullable();  //  // can be null (empty)
            $table->string('password');
            $table->string('introduction', 100)->nullable();  //
            $table->integer('role_id')->default(2)->comment('1:admin, 2:user');  //
            // default - default value when creatiing
            // comment - note
            // $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.Ω
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
