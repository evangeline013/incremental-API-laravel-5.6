<?php

namespace App\Http\Controllers;

use App\Http\Resources\TagResource;
use Illuminate\Http\Request;
use App\Tag;
use App\Lesson;

class TagsController extends ApiController
{
    public function index($lessonId = null)
    {
        $tags = $this->getTags($lessonId);
        return TagResource::collection($tags);
    }

    private function getTags($lessonId)
    {
        return $lessonId ? Lesson::findOrFail($lessonId)->tags : Tag::all();
    }
}
