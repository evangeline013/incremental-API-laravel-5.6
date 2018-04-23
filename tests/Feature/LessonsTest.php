<?php

namespace Tests\Feature;

use App\Http\Resources\LessonResource;
use Laravel\Passport\Passport;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LessonsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_fetches_lessons()
    {
        $lesson = factory('App\Lesson')->create();
        $this->getJson('api/v1/lessons')
            ->assertSee($lesson->title);
    }

    /** @test */
    public function it_fetches_a_single_lesson()
    {
        $lesson = factory('App\Lesson')->create();
        $this->getJson('api/v1/lessons/1')
            ->assertSee($lesson->title);
    }

    /** @test */
    public function it_returns_404_if_a_lesson_is_not_found()
    {
        $this->getJson('api/v1/lessons/500')
            ->assertStatus(404);
    }

    /** @test */
    public function authorized_user_can_insert_a_lesson()
    {
        Passport::actingAs(factory('App\User')->create());

        $lesson = factory('App\Lesson')->make();

        $this->post('/api/v1/lessons', [
            'title' => $lesson->title,
            'body' => $lesson->body,
            'views' => $lesson->views,
            'length' => $lesson->length,
            'difficulty' => $lesson->difficulty,
            'active' => $lesson->some_bool
        ])->assertStatus(201);

        $this->assertDatabaseHas('lessons', $lesson->toArray());
    }

    /** @test */
    public function it_returns_422_if_a_post_lesson_request_fails_parameter_validation()
    {
        Passport::actingAs(factory('App\User')->create());
        $this->post('/api/v1/lessons')
            ->assertStatus(422);
    }
}
