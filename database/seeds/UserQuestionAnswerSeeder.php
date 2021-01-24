<?php

use App\Question;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserQuestionAnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('answers')->delete();
        DB::table('questions')->delete();
        DB::table('user')->delete();

        factory(User::class, 3)->create()->each(function ($user) {
            $user->questions()
                ->saveMany(factory(Question::class, rand(2, 10))->make())
                ->each(function ($question) {
                    $question->answers()->saveMany(factory(\App\Answer::class, rand(1, 5))->make());
                });
        });
    }
}
