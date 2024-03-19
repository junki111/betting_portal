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
        Schema::create('games', function (Blueprint $table) {
            $table->softDeletes();
            $table->id();
            $table->string('home_team');
            $table->double('home_team_odds');
            $table->string('away_team');
            $table->double('away_team_odds');
            $table->string('draw');
            $table->double('draw_odds');
            $table->dateTime('game_date');
            $table->integer('status')->default(1);
            $table->integer('home_team_score')->nullable();
            $table->integer('away_team_score')->nullable();
            $table->string('game_result')->nullable();
            $table->unsignedBigInteger('game_type_id');
            $table->foreign('game_type_id')->references('id')->on('sports_games_type');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
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
        Schema::table('games', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::dropIfExists('games');
    }
};
