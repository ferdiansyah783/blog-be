<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\BaseController;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends BaseController
{
    public function index(Request $request)
    {
        $query = Post::with('user')->latest();

        if ($request->has('search')) {
            $query->search($request->search);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $posts = $query->paginate(10);

        return $this->sendResponse($posts);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'status' => 'required|in:draft,published',
        ]);

        $validated['user_id'] = auth()->id();

        $existPost = Post::where('title', $validated['title'])->first();
        if ($existPost) {
            return $this->sendError('Post with this title already exists');
        }

        if ($validated['status'] === 'published') {
            $validated['published_at'] = now();
        }

        $post = Post::create($validated);

        return $this->sendResponse($post->load('user'));
    }

    public function show($postId)
    {
        $post = Post::find($postId);

        if (!$post) {
            return $this->sendError('Post not found', 404);
        }

        return $this->sendResponse($post->load('user'));
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'status' => 'required|in:draft,published',
        ]);

        if ($validated['status'] === 'published' && $post->status === 'draft') {
            $validated['published_at'] = now();
        }

        $post->update($validated);

        return $this->sendResponse($post->load('user'));
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return $this->sendResponse(null, 'Post deleted');
    }
}
