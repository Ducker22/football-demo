<?php

use App\Models\Team;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFootballTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('logo')->nullable();
        });

        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('week');
            $table->unsignedInteger('home_team_id');
            $table->unsignedInteger('away_team_id');
            $table->unsignedSmallInteger('home_team_scored')->nullable();
            $table->unsignedSmallInteger('away_team_scored')->nullable();

            $table->foreign('home_team_id')->references('id')->on('teams')->onDelete('CASCADE');
            $table->foreign('away_team_id')->references('id')->on('teams')->onDelete('CASCADE');
        });

        Schema::create('ranks', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('team_id');
            $table->unsignedSmallInteger('game_played')->default(0);
            $table->unsignedSmallInteger('win')->default(0);
            $table->unsignedSmallInteger('loss')->default(0);
            $table->unsignedSmallInteger('draw')->default(0);
            $table->unsignedSmallInteger('points')->default(0);
            $table->unsignedSmallInteger('goal_diff')->default(0);

            $table->foreign('team_id')->references('id')->on('teams')->onDelete('CASCADE');
        });

        $this->seed();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ranks');
        Schema::dropIfExists('results');
        Schema::dropIfExists('teams');
    }

    private function seed()
    {
        $teams = [
            'Chelsea',
            'Arsenal',
            'Lester',
            'Liverpool',
        ];

        $i = 1;
        foreach ($teams as $team) {
            Team::create([
                'name' => $team,
                'logo' => "img/team${i}.png"
            ]);
            $i++;
        }
    }
}
