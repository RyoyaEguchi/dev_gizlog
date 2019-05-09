<?php

use Illuminate\Database\Seeder;

class DailyReportsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('daily_reports')->truncate();
        DB::table('daily_reports')->insert([
            'user_id' => 1,
            'title' => 'テストタイトル',
            'contents' => 'seederによる初期値です',
            'reporting_time' => '2000-11-23',
            'created_at' => Carbon::create(2019, 1, 15, 9, 50, 22),
            'updated_at'   => Carbon::create(2019, 1, 15, 19, 30, 28),
        ]);
    }
}
