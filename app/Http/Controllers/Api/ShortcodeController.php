<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\ShortcodeHistory;
use App\Models\File;
use tehwave\Shortcodes\Shortcode;
use Illuminate\Support\Facades\Storage;

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

    // UPDATE POST
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $request->validate([
            'content' => 'required'
        ]);

        $parsed = Shortcode::compile($request->content);

        $post->update([
            'content' => $request->content,
            'parsed_content' => $parsed
        ]);

        return response()->json([
            'message' => 'Post updated successfully',
            'data' => $post
        ]);
    }

    // DELETE POST
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return response()->json([
            'message' => 'Post deleted successfully'
        ]);
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

    // FILE UPLOAD
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:5120|mimes:jpg,jpeg,png,gif,svg,pdf,doc,docx,txt,mp4,webm'
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('uploads', 'public');
            $url = Storage::url($path);

            $fileRecord = File::create([
                'filename' => $file->getClientOriginalName(),
                'path' => $path,
                'url' => $url,
                'size' => $file->getSize(),
                'mime_type' => $file->getMimeType()
            ]);

            return response()->json([
                'message' => 'File uploaded successfully',
                'data' => $fileRecord
            ]);
        }

        return response()->json(['message' => 'No file uploaded'], 422);
    }

    // GET ALL UPLOADED FILES
    public function files()
    {
        return response()->json(File::latest()->get());
    }

    // DELETE FILE
    public function fileDelete($id)
    {
        $file = File::findOrFail($id);

        if (Storage::disk('public')->exists($file->path)) {
            Storage::disk('public')->delete($file->path);
        }

        $file->delete();

        return response()->json([
            'message' => 'File deleted successfully'
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
