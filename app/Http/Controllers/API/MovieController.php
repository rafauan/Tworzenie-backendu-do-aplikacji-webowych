<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $movies = Movie::all();

        if ($movies->isEmpty()) {
            return response()->json(['message' => 'No movies in the database'], 404);
        }

        return $movies;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|unique:movies',
            'director' => 'required',
            'genre' => 'required',
            'release_date' => 'required',
        ];

        $messages = [
            'title.required' => 'This field is required',
            'title.unique' => 'A movie with this title already exists in the database',
            'director.required' => 'This field is required',
            'genre.required' => 'This field is required',
            'release_date.required' => 'This field is required',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $item = Movie::create($request->all());
        return response()->json($item, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $item = Movie::find($id);
        if ($item) {
            return $item;
        } else {
            return response()->json(['message' => 'Movie not found'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'title' => 'unique:movies',
        ];
        
        $messages = [
            'title.unique' => 'A movie with this title already exists in the database',
        ];
        
        $validator = Validator::make($request->all(), $rules, $messages);
        
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        
        $item = Movie::find($id);
        $item->update($request->all());
        return response()->json($item, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $item = Movie::find($id);
        if (!$item) {
            return response()->json(['message' => 'Movie not found'], 404);
        } else {
            $item->delete();
            return response()->json(['message' => "Movie $item->title was removed"], 200);
        }
    }
}
