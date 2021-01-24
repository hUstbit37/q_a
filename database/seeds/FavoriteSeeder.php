<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Question;

class FavoriteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('favorites')->delete();

        $usersID = User::pluck('id')->all();
        $usersCount = count($usersID);
        $questions = Question::all();

        foreach ($questions as $question) {
            for ($i = 0; $i < rand(1, $usersCount); $i++) {
                $user = $usersID[$i];

                $question->favorites()->attach($user);
            }
        }
    }
}
