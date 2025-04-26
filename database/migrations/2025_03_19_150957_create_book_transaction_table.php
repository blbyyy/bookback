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
        Schema::create('book_transaction', function (Blueprint $table) {
            $table->increments('id');
            $table->string('borrower_name');
            $table->text('book_title');
            $table->string('book_category');
            $table->string('book_borrowing_date');
            $table->string('due_date');
            $table->text('purpose');
            $table->string('status');
            $table->integer('book_id')->unsigned()->nullable();
            $table->foreign('book_id')->references('id')->on('books');
            $table->integer('borrower_id')->unsigned()->nullable();
            $table->foreign('borrower_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_transaction');
    }
};
