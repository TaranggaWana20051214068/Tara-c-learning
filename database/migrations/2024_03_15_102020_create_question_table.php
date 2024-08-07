<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('deskripsi');
            $table->string('bahasa')->nullable();
            $table->foreignId('author_id')->nullable()->constrained('users');
            $table->foreignId('article_id')->nullable()->constrained();
            $table->unsignedBigInteger('periode_id');
            $table->unsignedBigInteger('subject_id');
            $table->timestamps();

            $table->foreign('periode_id')->references('id')->on('periodes');
            $table->foreign('subject_id')->references('id')->on('subjects');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('question');
    }
};
