<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use tehwave\Shortcodes\Shortcode;

class ShortcodeController extends Controller
{
    // CREATE + PARSE
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required'
        ]);

        $parsed = Shortcode::compile($request->content);

        $post = Post::create([
            'content' => $request->content,
            'parsed_content' => $parsed
        ]);

        return response()->json([
            'message' => 'Post created successfully',
            'data' => $post
        ]);
    }

    // GET ALL POSTS
    public function index()
    {
        return response()->json(Post::latest()->get());
    }

    // GET SINGLE POST
    public function show($id)
    {
        $post = Post::findOrFail($id);

        return response()->json($post);
    }

    // PARSE ONLY (NO SAVE)
    public function parse(Request $request)
    {
        $request->validate([
            'content' => 'required'
        ]);

        $parsed = Shortcode::compile($request->content);

        return response()->json([
            'original' => $request->content,
            'parsed' => $parsed
        ]);
    }
}