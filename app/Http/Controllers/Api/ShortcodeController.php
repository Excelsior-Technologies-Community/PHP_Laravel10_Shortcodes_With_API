<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\ShortcodeHistory;
use tehwave\Shortcodes\Shortcode;

class ShortcodeController extends Controller
{

    // GET ALL POSTS
    public function index()
    {
        return response()->json(Post::latest()->get());
    }

    // CREATE + PARSE + SAVE POST
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

    // GET SINGLE POST
    public function show($id)
    {
        $post = Post::findOrFail($id);

        return response()->json($post);
    }

    // PARSE ONLY + SAVE HISTORY
    public function parse(Request $request)
    {
        $request->validate([
            'content' => 'required'
        ]);

        $parsed = Shortcode::compile($request->content);

        ShortcodeHistory::create([
            'original_content' => $request->content,
            'parsed_content' => $parsed
        ]);

        return response()->json([
            'original' => $request->content,
            'parsed' => $parsed
        ]);
    }

    // GET ALL HISTORY
    public function history()
    {
        return response()->json(
            ShortcodeHistory::orderBy('id', 'asc')->get()
        );
    }

    // GET SINGLE HISTORY
    public function historyShow($id)
    {
        return response()->json(
            ShortcodeHistory::findOrFail($id)
        );
    }

    // DELETE HISTORY
    public function historyDelete($id)
    {
        $history = ShortcodeHistory::findOrFail($id);

        $history->delete();

        return response()->json([
            'message' => 'History deleted successfully'
        ]);
    }
}
