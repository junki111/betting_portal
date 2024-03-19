<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Game;
use App\Models\Bets;
use App\Models\Accounts;

class GenerateGamesResults extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:results';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate results for the games based on the game date and time.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $games = Game::where('game_date', '<=', now())->where('status', '=', 1)->get();
        foreach($games as $game) {
            $home_team_score = rand(0, 10);
            $away_team_score = rand(0, 10);

            if ($home_team_score > $away_team_score) {
                $game->game_result = $game->home_team;
            } elseif ($home_team_score < $away_team_score) {
                $game->game_result = $game->away_team;
            } else {
                $game->game_result = $game->draw;
            }

            $game->home_team_score = $home_team_score;
            $game->away_team_score = $away_team_score;
            $game->status = 2;
            $game->save();

            //Update the bets
            $bets = Bets::whereRaw("CHARINDEX(?, game_id) > 0", [strval($game->id)])->where('status', '=', 1)->get();

            foreach($bets as $bet) {
                //update bet status to active because on of the games is completed
                $bet->status = 3;
                $bet->save();

                $completedGamesCount = Game::whereIn('id', explode(',', $bet->game_id))->where('status', '=', 2)->count();
                $totalGamesCount = count(explode(',', $bet->game_id));

                if ($completedGamesCount < $totalGamesCount) {
                    // get the games data and confirm results
                    // if even one of the games is a loss then the entire bet is a loss. no need to continue with the bet
                    $gameResults = Game::whereIn('id', explode(',', $bet->game_id))->where('status', '=', 2)->get();
                    foreach($gameResults as $gameResult) {
                        if ($bet->bet_type == $gameResult->game_result) {
                            continue;
                        } else {
                            $bet->result = "loss";
                            $bet->status = 2;
                            $bet->save();

                            //update accounts table
                            Accounts::create([
                                'user_id' => $bet->user_id,
                                'bet_id' => $bet->id,
                                'outcome' => $bet->result,
                                'amount' => $bet->bet_amount
                            ]);
                            break;
                        }
                    }
                } else {
                    // all games are completed
                    // check if the bet is a win or a loss
                    $winCount = Game::whereIn('id', explode(',', $bet->game_id))->where('status', '=', 2)->where('game_result', '=', $bet->bet_type)->count();
                    if ($winCount == $totalGamesCount) {
                        $bet->result = "win";
                        $bet->status = 2;
                        $bet->save();

                        //update accounts table
                        Accounts::create([
                            'user_id' => $bet->user_id,
                            'bet_id' => $bet->id,
                            'outcome' => $bet->result,
                            'amount' => $bet->bet_potential_winnings
                        ]);

                    } else {
                        $bet->result = "loss";
                        $bet->status = 2;
                        $bet->save();

                        //update accounts table
                        Accounts::create([
                            'user_id' => $bet->user_id,
                            'bet_id' => $bet->id,
                            'outcome' => $bet->result,
                            'amount' => $bet->bet_amount
                        ]);
                    }
                }
            }
        }
        
        $this->info('Random scores generated successfully.');   
        return Command::SUCCESS; 
    }
}
