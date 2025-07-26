<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\BaseController;
use App\Models\Post;

class SummaryController extends BaseController
{
    public function count($status = null)
    {
        $count = Post::when($status, function ($query) use ($status) {
            $query->where('status', $status);
        })->count();

        return $this->sendResponse($count);
    }
}
