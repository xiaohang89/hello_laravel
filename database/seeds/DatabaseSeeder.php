<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {   
        // 按顺序执行 
        // 先生成用户
        $this->call(UsersTableSeeder::class);
		// 接着生成话题
		$this->call(TopicsTableSeeder::class);
        // 最后生成回复
        $this->call(RepliesTableSeeder::class);
    }
}
