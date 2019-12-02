<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{

    public function index(Request $request)
    {

        if ($request->search) {
            $posts = Post::join('users', 'author_id', '=', 'users.id')
                ->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%')
                ->orWhere('name', 'like', '%' . $request->search . '%')
                ->orderBy('posts.created_at', 'desc')
                ->paginate(12);
            return view('posts/index', compact('posts'));
        }
        $title = 'Блог';
        // получаем все посты из модели
        $posts = Post::join('users', 'author_id', '=', 'users.id')
                ->orderBy('posts.created_at', 'desc')
                ->paginate(4);
        return view('posts/index', compact('posts', 'title'));
    }


    public function create()
    {
        $title = 'Создать пост';
        return view('posts.create', compact('title'));
    }


    public function store(Request $request)
    {
        //dd($request);

        $post = new Post();
        $post->title = $request->title;
        $post->short_title = Str::length($request->title > 30 ? Str::substr($request->title, 0, 30) . '...' : $request->title);
        $post->description = $request->description;
        $post->author_id = rand(1,4);

        if ($request->file('img')) {
            // перемещаем загруженный файл в папку
            $path = Storage::putFile('public', $request->file('img'));
            // сохраняем путь к загруженному файлу
            $url = Storage::url($path);
            // записываем путь к картинке в бд
            $post->img = $url;
        }

        // сохраняем все в БД
        $post->save();

        return redirect()->route('post.index')->with('success', 'Пост успешно добавлен!');


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
