<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Lesson;
use App\Http\Resources\LessonResource;
use App\Http\Resources\LessonCollection;
use App\LessonFilters;

class LessonsController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth:api')->only('store');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, LessonFilters $filters)
    {
        $limit = $request->input('limit') ? : 5;

        $lesson = Lesson::filter($filters);

        return new LessonCollection($lesson->paginate($limit));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (! $request->input('title') or ! $request->input('body') or $request->input('active') === null)
        {
            return $this->respondValidationError('Parameters failed validation for a lesson.');
        }

        Lesson::create([
            'title' => request('title'),
            'body' => request('body'),
            'views' => request('views'),
            'length' => request('length'),
            'difficulty' => request('difficulty'),
            'some_bool' => request('active')
        ]);

        return $this->respondCreated('Lesson was successfully created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $lesson = Lesson::find($id);

        if (! $lesson) {
            return $this->respondNotFound('Lesson does not exist.');
        }

        return new LessonResource($lesson);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


}
