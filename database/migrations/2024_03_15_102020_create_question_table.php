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
        Schema::create('question', function (Blueprint $table) {
            $table->id();
            $table->foreignId('challenge_id')->references('id')->on('challenges');
            $table->string('user_id');
            $table->string('status_hasil')->nullable();
            $table->integer('score')->nullable();
            $table->string('access_code')->nullable();
            $table->integer('tab_changes')->nullable();
            $table->foreignId('completed_by')->nullable()->constrained('users');
            $table->timestamp('created_at')->nullable();
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
