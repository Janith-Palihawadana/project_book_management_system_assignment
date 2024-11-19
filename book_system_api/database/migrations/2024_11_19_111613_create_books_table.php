<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->increments('id');
            $table->string('book_ref',36)->unique()->default(DB::raw('(UUID())'))->index();
            $table->unsignedBigInteger('author_id');
            $table->string('title');
            $table->text('description');
            $table->string('cover_image')->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->unsignedInteger('created_user_id')->nullable();
            $table->unsignedInteger('updated_user_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
