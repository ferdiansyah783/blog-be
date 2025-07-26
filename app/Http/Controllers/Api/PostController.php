<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends BaseController
{
    public function index(Request $request)
    {
        $query = Post::with('user:id,name')
            ->published()
            ->latest('published_at');

        if ($request->has('search')) {
            $query->search($request->search);
        }

        $posts = $query->paginate();

        return $this->sendResponse($posts);
    }

    public function show($slug)
    {
        $post = Post::with('user:id,name')
            ->published()
            ->where('slug', $slug)
            ->first();

        if (!$post) {
            return $this->sendError('Post not found', 404);
        }

        return $this->sendResponse($post);
    }
}
