<?php

use Illuminate\Database\Seeder;

class ArticlsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Article::class, 30)->create();
    }
}
