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
        Schema::create('challenges', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('markdown');
            $table->string('problem_type');
            $table->integer('score');
            $table->string('challenges_id');
            $table->json('validations')->nullable();
            $table->unsignedBigInteger('author_id');
            $table->foreignId('article_id')->nullable()->constrained('articles');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('challenges');
    }
};
