<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        // получим все посты из модели
        $posts = Post::all();

        return view('posts/index', compact('posts'));

    }
}
