<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    private $tables = [
        'lessons',
        'tags',
        'lesson_tag'
    ];

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->cleanDatabase();

         $this->call(LessonsTableSeeder::class);
         $this->call(TagsTableSeeder::class);
         $this->call(LessonTagTableSeeder::class);
    }

    private function cleanDatabase()
    {
        foreach ($this->tables as $tableName)
        {
            DB::table($tableName)->truncate();
        }
    }
}
