<?php

use Illuminate\Database\Seeder;
use App\Lesson;
use App\Tag;

class LessonTagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = Tag::all();

        Lesson::all()->each(function ($lesson) use ($tags){
            $lesson->tags()->attach(
                $tags->random(rand(1,3))->pluck('id')->toArray()
            );
        });
    }
}