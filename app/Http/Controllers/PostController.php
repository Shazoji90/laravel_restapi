<?php

namespace App\Http\Controllers;

use App\Http\Resources\Post\PostCollection;
use App\Http\Resources\Post\PostResource;
use App\Models\Post;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = Post::paginate(5);

        return new PostCollection($data);

        // return response()->json($data, 200);
    }

    public function show($id)
    {
        $data = Post::find($id);
        if(is_null($data)) {
            return response()->json([
                'message' => 'Resource not found'
            ], 404);
        }

        return new PostResource($data);

        // return response()->json($data, 200);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $mesages = [
            'title.required' => ':attribute tidak ditemukan.',
            'title.min' => ':attribute minimal :min karakter.',
        ];

        $validator = Validator::make($data, [
            'title' => ['required','min:5']
        ], $mesages);

        if($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ], 400);
        }

        $response = Post::create($data);
        return response()->json($response, 201);
    }

    public function update(Request $request, Post $post)
    {
        $post->update($request->all());
        return response()->json($post, 200);
    }

    public function destroy($id)
    {
        $data = Post::find($id);
        if(is_null($data)) {
            return response()->json([
                'message' => 'Resource not found'
            ], 404);
        }

        $data->delete();
        return response()->json([
            'message' => 'Resource successfully deleted'
        ], 200);
    }
}
