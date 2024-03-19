<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bets', function (Blueprint $table) {
            $table->softDeletes();
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('game_id');
            $table->string('bet_type');
            $table->double('bet_amount');
            $table->double('bet_potential_winnings');
            $table->string('result')->nullable();
            $table->integer('status')->default(1);
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
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
        //
        Schema::table('bets', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::dropIfExists('bets');
    }
};
