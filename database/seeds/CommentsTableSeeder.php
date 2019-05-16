<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('comments')->truncate();
        DB::table('comments')->insert([
            [
                'user_id' => 1,
                'question_id' => 1,
                'comment' => 'テストコメント',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'user_id' => 2,
                'question_id' => 2,
                'comment' => 'テストコメント2',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],            [
                'user_id' => 2,
                'question_id' => 2,
                'comment' => 'テストコメント3',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'user_id' => 2,
                'question_id' => 2,
                'comment' => 'テストコメント4',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);
    }
}
