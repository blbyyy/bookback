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
        Schema::create('librarians', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('address')->nullable();
            $table->date('birthdate')->nullable();
            $table->string('age')->nullable();
            $table->string('sex')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->unique();
            $table->string('avatar')->nullable()->default('avatar.jpg');
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_librarian');
    }
};
