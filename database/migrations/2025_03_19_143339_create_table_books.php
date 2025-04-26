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
        Schema::create('books', function (Blueprint $table) {
            $table->increments('id');
            $table->text('title');
            $table->text('author');
            $table->text('category');
            $table->text('summary');
            $table->text('status')->default('On-Shelf');
            $table->string('img_path')->default('bookphoto.jpg');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_books');
    }
};
